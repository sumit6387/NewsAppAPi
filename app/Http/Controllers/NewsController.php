<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\News;
use App\Models\User;


class NewsController extends Controller
{
    public function register(Request $request){
        $user = User::where('user_id',$request->user_id)->get()->first();
        if($user){
            return response()->json([
                'status' => false,
                'token' => $user->token
            ]);
        }
        $token = "Bearer ASDBF".rand(111111111111111,999999999999999)."CQWE";
        $user = new User();
        $user->user_id = $request->user_id;
        $user->token = $token;
        if($user->save()){
            return response()->json([
                'status' => true,
                'token' => $token
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'Something Went Wrong!!'
            ]);
        }
    }
    public function getNews(Request $req,$category,$page){
        $news = News::orderby('id','desc')->where('category',$category)->get();
        if(count($news)){
            $newsArr = array();
            $user_id = User::where('token',$req->header('Authorization'))->get()->first()->id;
            foreach ($news as $key => $value) {
                $arr = explode(',',$value->likes);
                $value->userLiked = false;
                if(in_array($user_id , $arr)){
                    $value->userLiked = true;
                }
                array_push($newsArr,$value);
            }
            $news = collect($newsArr)->forPage($page,10);
            $newsArr = array();
            foreach ($news as $key => $value) {
                array_push($newsArr,$value);
            }
            return response()->json([
                'status' => true,
                'data' => $newsArr
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => "No Data Found For THis Category!!"
            ]);
        }
    }

    public function setNewsOnDb(){
        $categories = ['national','business','sports','world','politics','technology','startup','entertainment','miscellaneous','hatke','automobile'];
        $data = array();
        for( $i=0; $i < count($categories); $i++) { 
            $response = Http::get('https://newsapi2812.herokuapp.com/en/'.$categories[$i].'/5');
            $news = json_decode($response)[0];
            foreach ($news as $key => $value) {
                $news = News::where('title',$value->title)->get();
                if(count($news) == 0){
                    $newsData = [
                        "category" => $categories[$i],
                        "title" => $value->title,
                        "author" => $value->author,
                        "content" => $value->content,
                        "sourceURL" => $value->sourceURL,
                        "imgsrc" => $value->imgsrc,
                        "postedAt" => $value->postedAt,
                        'created_at' =>now()->toDateTimeString(),
                        'updated_at' => now()->toDateTimeString()
                    ];
                    array_push($data , $newsData);
                }
            }
        }
        $chunks = array_chunk($data , 80);
        foreach ($chunks as $key => $value){
            News::insert($value);
        }
        return response()->json([
            'status' => true,
            'data' => "Data Added Into Database"
        ]);
    }

    public function bookmark(Request $request){
        $token  = $request->header('Authorization');
        $user = User::where('token' , $token)->get()->first();
        $news = News::where('id',$request->news_id)->get()->first();
        if($news){
            if($user->bookmarks == null){
                $user->bookmarks = $request->news_id;
                $user->save();
            }else{
                $news = explode(',',$user->bookmarks);
                if(in_array($request->news_id , $news)){
                    return response()->json([
                        'status' => true,
                        'msg' => "Already Bookmarked"
                    ]);
                }else{
                    $user->bookmarks = $user->bookmarks.",".$request->news_id;
                }
                $user->save();
            }
            return response()->json([
                'status' => true,
                'msg' => 'News Bookmarked'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong"
            ]);
        }
    }

    public function unBookMark(Request $request){
        $token  = $request->header('Authorization');
        $user = User::where('token' , $token)->get()->first();
        $news = News::where('id',$request->news_id)->get()->first();
        if($news){
            $news = explode(',',$user->bookmarks);
            if(in_array($request->news_id , $news)){
                $res =array_diff($news,[$request->news_id]);
                $arr = implode(',',$res);
                $user->bookmarks = $arr;
                $user->save();
                return response()->json([
                    'status' => true,
                    'msg' => "Bookmark Removed"
                ]);
            }else{
                return response()->json([
                    'status' => true,
                    'msg' => "This News Is Not Bookmarked!!"
                ]);
            }
            $user->save();
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong!!"
            ]);
        }
    }

    public function getBookmark(Request $request,$page){
        $bookmark_ids = User::where('token' , $request->header('Authorization'))->get()->first()->bookmarks;
        if($bookmark_ids != null){
            $bookmark_id = explode(',',$bookmark_ids);
            $data = array();
            for ($i=0; $i < count($bookmark_id); $i++) { 
                $news = News::where('id',$bookmark_id[$i])->get()->first();
                $arr = explode(',',$news);
                $news->userLiked = false;
                if(in_array($bookmark_ids , $arr)){
                    $news->userLiked = true;
                }
                array_push($data , $news);
            }
            if(count($data)){
                $news = collect($data)->forPage($page,10);
                $data = array();
                foreach ($news as $key => $value) {
                    array_push($data,$value);
                }
                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => 'Something Went Wrong!!'
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'Something Went Wrong!!'
            ]);
        } 
    }

    public function like(Request $request){
        $user_id = $request->header('Authorization');
        $user = User::where('token',$user_id)->get()->first()->id;
        $news = News::where('id',$request->news_id)->get()->first();
        if($user && $news){
            if($news->likes == null){
                $news->likes = $user.",";
            }else{
                $news->likes = $news->likes."".$user.",";
            }
            $news->update();
            return response()->json([
                'status' => true,
                'msg' => "You Like The News!!"
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong"
            ]);
        }
    }

    public function disLike(Request $request){
        $user_id = $request->header('Authorization');
        $user = User::where('token',$user_id)->get()->first()->id;
        $news = News::where('id',$request->news_id)->get()->first();
        if($user && $news){
            if($news->likes == null){
                return response()->json([
                    'status' => false,
                    'msg' => "Something Went Wrong"
                ]);
            }else{
                $users = explode(',',$news->likes);
                if(in_array($user,$users)){
                    $arr = array_diff($users , [$user]);
                    $news->likes = implode(',',$arr);
                    $news->update();
                    return response()->json([
                        'status' => true,
                        'msg' => "You Dislike The News!!"
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'msg' => "Something Went Wrong"
                    ]);
                }
            }
            $news->update();
            return response()->json([
                'status' => true,
                'msg' => "You Like The Post!!"
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong"
            ]);
        }
    }

    public function getRandomNews(Request $req,$page){
        $categories = ['national','business','sports','world','politics','technology','startup','entertainment','miscellaneous','hatke','automobile'];
        $newsArr = array();
        $user_id = User::where('token',$req->header('Authorization'))->get()->first()->id;
        for ($i=0; $i < count($categories); $i++) { 
            $news = News::latest()->where('category',$categories[$i])->take(5)->get();
            foreach ($news as $key => $value) {
                $arr = explode(',',$value->likes);
                $value->userLiked = false;
                if(in_array($user_id , $arr)){
                    $value->userLiked = true;
                }
                array_push($newsArr,$value);
            }
        }
        shuffle($newsArr);
        if($newsArr){
            $news = collect($newsArr)->forPage($page,10);
            $newsArr = array();
            foreach ($news as $key => $value) {
                array_push($newsArr,$value);
            }
            return response()->json([
                'status' => true,
                "data" => $newsArr
            ]);
        }else{
            return response()->json([
                'status' => false,
                "msg" => "No Data Found!!"
            ]);
        }
    }
}
