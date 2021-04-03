<?php

namespace App\Http\Controllers\Auther;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Auther;
use App\Models\News;
use App\Models\TrendingNews;
use App\Models\TrendingCategory;
use Validator;
use Session;

class AutherController extends Controller
{
    public function becomeAuther(Request $request){
        $valid = Validator::make($request->all(), ['name' => "required" , "mobile_no" => "required","email" => "required"]);
        if($valid->passes()){
            if($request->blog_link || $request->social_link){
                $auther = Auther::where('email',$request->email)->get()->first();
                if($auther){
                    return response()->json([
                        'status' => false,
                        'msg' => "Your Request Already Send TO The Admin!!"
                    ]);
                }
                $auther = new Auther();
                $auther->auther_id = "auther_".rand(1111111111,9999999999);
                $auther->name = $request->name;
                $auther->email = $request->email;
                $auther->mobile_no = $request->mobile_no;
                if($request->blog_link){
                    $auther->blog_article = $request->blog_link;
                }
                if($request->social_link){
                    $auther->social_link = $request->social_link;
                }
                $auther->save();
                return response()->json([
                    'status' => true,
                    'msg' => "Your Request Send To The Admin!!"
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => "Enter Social Link Or Blog Link!"
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all()
            ]);
        }
    }

    public function autherLogin(Request $request){
        $valid = Validator::make($request->all() , ["email" => "required","password" => "required"]);
        if($valid->passes()){
            $auther = Auther::where(['email'=>$request->email,"approved"=>1])->get()->first();
            if($auther){
                if(Hash::check($request->password,$auther->password)){
                    Session::put('autherEmail',$request->email);
                    Session::put('autherName',$auther->name);
                    return response()->json([
                        'status' => true,
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'msg' => "Enter Correct Password!!"
                    ]);
                }
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => "Enter Registered Email or You are not approved by Admin!!"
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all()
            ]);
        }
    }

    public function login(){
        $email = Session::get('autherEmail');
        if($email){
            return Redirect::to(url('/auther/dashboard'));
        }
        return view('writer.login');
    }

    public function logout(){
        session()->forget('autherEmail');
        session()->forget('autherName');
        return Redirect::to('/auther/auther-login');
    }

    public function dashboard(){
        $email = Session::get('autherEmail');
        $auther_id = Auther::where('email',$email)->get()->first()->auther_id;
        $auther_news = TrendingNews::orderby('id','desc')->where('writtenBy',$auther_id)->take(10)->get();
        $news = News::orderby('id','desc')->where('writtenBy',$auther_id)->take(5)->get();
        $arr = array();
        foreach ($auther_news as  $value) {
            array_push($arr,$value);
        }
        foreach ($news as $key => $value) {
            array_push($arr,$value);
        }
        return view('writer.dashboard',['trendingNews' => $arr]);
    }

    public function writeNews(){
        $data['categories'] = ['national','business','sports','world','politics','technology','startup','entertainment','miscellaneous','hatke','automobile',"others"];
        $data['trenndingCategories'] = TrendingCategory::orderby('id','desc')->get();
        return view('writer.writenews',$data);
    }

    public function submitPost(Request $request){
        $valid = Validator::make($request->all(),["title" => "required" ,"img" => "required" ,"description"=>"required","sourceURL" => "required"]);
        if($valid->passes()){
            if($request->category || $request->trendingCategory){
                date_default_timezone_set("Asia/kolkata"); 
                $time = date('h:i a');
                $date = date('d M');
                $postedAt = $time." ".$date;
                $auther_email = Session::get('autherEmail');
                $auther = Auther::where('email',$auther_email)->get()->first();
                $img = $request->file('img');
                $extension = $img->getClientOriginalExtension();
                $imgname = time().rand(11111,99999).".".$extension;
                $path = $img->move('public/uploads/news', $imgname);
                if($request->category){
                    $add_new_news = new News();
                    $add_new_news->category = $request->category;
                    $add_new_news->title = $request->title;
                    $add_new_news->author = $auther->name;
                    $add_new_news->content = $request->description;
                    $add_new_news->postedAt = $postedAt;
                    $add_new_news->sourceURL = $request->sourceURL;
                    $add_new_news->imgsrc = $path;
                    $add_new_news->writtenBy = $auther->auther_id;
                    $add_new_news->save();
                    session()->forget('title');
                    session()->forget('description');
                    return Redirect::to(url('/auther/writeNews'));
                }
                if($request->trendingCategory){
                    $add_new_news = new TrendingNews();
                    $add_new_news->category = $request->trendingCategory;
                    $add_new_news->title = $request->title;
                    $add_new_news->author = $auther->name;
                    $add_new_news->content = $request->description;
                    $add_new_news->postedAt = $postedAt;
                    $add_new_news->sourceURL = $request->sourceURL;
                    $add_new_news->imgsrc = url('/'.$path);
                    $add_new_news->writtenBy = $auther->auther_id;
                    $add_new_news->save();
                    session()->forget('title');
                    session()->forget('description');
                    return Redirect::to(url('/auther/writeNews'));
                }
            }else{
                Session::put('title',$request->title);
                Session::put('description',$request->description);
                return Redirect::to(url('/auther/writeNews?msg=Select Category or or Trending Category'));
            }
        }else{
            $error = implode(',',$valid->errors()->all());
            Session::put('title',$request->title);
            Session::put('description',$request->description);
            return Redirect::to(url('/auther/writeNews?msg='.$error));
        }
    }
    
}
