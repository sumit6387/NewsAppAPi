<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\News;
use App\Models\User;


class NewsController extends Controller
{
    public function register(Request $request){
        if(User::where('user_id',$request->user_id)->get()->first()){
            return response()->json([
                'status' => false,
                'msg' => "Already Registered!!"
            ]);
        }
        $user = new User();
        $user->user_id = $request->user_id;
        $user->save();
        return response()->json([
            'status' => true,
            'msg' => 'User Registered!!'
        ]);
    }
    public function getNews($category , $noOfData){
        $news = News::latest()->where('category',$category)->take($noOfData)->get();
        if(count($news)){
            return response()->json([
                'status' => true,
                'data' => $news
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
        $chunks = array_chunk($data , 50);
        foreach ($chunks as $key => $value){
            News::insert($value);
        }
        return response()->json([
            'status' => true,
            'data' => "Data Added Into Database"
        ]);
    }

    public function bookmark(Request $request){
        $token  = $request->header('user_id');
        $user = User::where('user_id' , $token)->get()->first();
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
        $token  = $request->header('user_id');
        $user = User::where('user_id' , $token)->get()->first();
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

    public function getBookmark(Request $request){
        $bookmark_ids = User::where('user_id' , $request->header('user_id'))->get()->first()->bookmarks;
        if($bookmark_ids != null){
            $bookmark_id = explode(',',$bookmark_ids);
            $data = array();
            for ($i=0; $i < count($bookmark_id); $i++) { 
                $news = News::where('id',$bookmark_id[$i])->get()->first();
                array_push($data , $news);
            }
            if(count($data)){
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

    public function bookmarkDetail($bookmark_id){
        $news = News::where('id' , $bookmark_id)->get()->first();
        if($news){
            return response()->json([
                'status' => true,
                'data' => $news
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong"
            ]);
        }
    }
}
