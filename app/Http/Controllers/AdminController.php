<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
USE App\Models\Auther;
USE App\Models\TrendingCategory;
use Illuminate\Support\Str;
use Mail;

class AdminController extends Controller
{
    public function dashboard(){
        return view('index');
    }

    public function acceptAutherRequest($auther_id){
        $auther = Auther::where('auther_id',$auther_id)->get()->first();
        if($auther){
            $password = Str::random(10);
            $to_name = $auther->name;
            $to_email = $auther->email;
            $data = ['name'=>$to_name,"email" => $to_email,"password" => $password];
            Mail::send('emails.accountVerificationEmail', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                ->subject('Account Verification As A Auther On Instant News');
                $message->from('funtoos456@gmail.com','Instant News');
            });
            $auther->password = Hash::make($password);
            $auther->approved = 1;
            $auther->save();
            return Redirect::to(url('/authers'));
        }else{
            return Redirect::to(url('/authers'));
        }
    }

    public function deleteCategory($category_id){
        $category = TrendingCategory::where('id',$category_id)->get()->first();
        if($category){
            $category->delete();
            return Redirect::to(url('/category'));
        }else{
            return Redirect::to(url('/category'));
        }
    }

    public function addCategory(Request $request){
        $img = $request->file('img');
        $extension = $img->getClientOriginalExtension();
        $imgname = time().rand(11111,99999).".".$extension;
        if($extension == 'jpg' || $extension == 'png'){
            $path = $img->move('public/uploads/category', $imgname);
            $new_category = new TrendingCategory();
            $new_category->category = $request->category;
            $new_category->title = $request->title;
            $new_category->img = $imgname;
            $new_category->save();
            return Redirect::to(url('/category'));
        }else{
            return Redirect::to(url('/category'));
        }
    }

    public function editCategoryProcess(Request $request){
        $category = TrendingCategory::where('id',$request->id)->get()->first();
        if($category){
            if($request->category){
                $category->category = $request->category;
            }
            if($request->title){
                $category->title = $request->title;
            }
            if($request->file('img')){
                $img = $request->file('img');
                $extension = $img->getClientOriginalExtension();
                $imgname = time().rand(11111,99999).".".$extension;
                $path = $img->move('public/uploads/category', $imgname);
                $category->img = $imgname;
            }
            $category->save();
            return Redirect::to(url('/category'));
        }else{
            return Redirect::to(url('/editCategory/'.$request->id.'?msg=Something Went Wrong'));
        }
    }


}
