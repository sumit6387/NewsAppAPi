<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\News;


class NewsController extends Controller
{
    public function currentNews($category , $noOfData){
        $categories = ['national','business','sports','world','politics','technology','startup','entertainment','miscellaneous','hatke','hatke','automobile'];
        if(in_array($category,$categories)){
            $response = Http::get('https://newsapi2812.herokuapp.com/en/'.$category.'/'.$noOfData);
            $news = json_decode($response)[0];
            foreach ($news as $value) {
                $news = News::where('title',$value->title)->get();
                if(count($news) == 0){
                    $new_news = new News();
                    $new_news->category = $category;
                    $new_news->title = $value->title;
                    $new_news->author = $value->author;
                    $new_news->content = str_replace( array( "\""), '', $value->content);
                    $new_news->postedAt = $value->postedAt;
                    $new_news->sourceURL = $value->sourceURL;
                    $new_news->imgsrc = $value->imgsrc;
                    $new_news->save();
                }
            }
            $news = News::orderby('id','desc')->where('category',$category)->get();
            if(count($news)){  
                return response()->json([
                    'status' => true,
                    'data' => $news
                ]);
            }else{
                return response()->json([
                    'status' => True,
                    'msg' => "No Data Found!!"
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => "Something Went Wrong"
            ]);
        }
    }
}
