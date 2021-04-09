<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\Auther;
use App\Models\TrendingCategory;
use App\Models\TrendingNews;
use App\Models\AutherHistory;
use App\Models\News;
use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Support\Str;
use Mail;
use Validator;

class AdminController extends Controller
{
    public function dashboard(){
        $data['users'] = User::get()->count();
        $data['authers'] = Auther::where('approved',1)->get()->count();
        $data['trendingNews'] = TrendingNews::where('status',1)->get()->count();
        return view('index',$data);
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
                ->subject('Account Verification As An Auther On Instant News');
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

    public function approvePost(Request $request){
        $valid = Validator::make($request->all() , ["amount" => "required"]);
        if($valid->passes()){
            $auther = Auther::where('auther_id',$request->auther_id)->get()->first();
            $categories = ['national','business','sports','world','politics','technology','startup','entertainment','miscellaneous','hatke','automobile'];
            if(in_array($request->category , $categories)){
                $news = News::where('id',$request->news_id)->get()->first();
            }else{
                $news = TrendingNews::where('id',$request->news_id)->get()->first();
            }
            if($auther && $news){
                $news->status = 1;
                $news->save();
                $history = new AutherHistory();
                $history->auther_id = $news->writtenBy;
                $history->category = $news->category;
                $history->news_id = $news->id;
                $history->amount = $request->amount;
                $history->save();
                $auther->amount = $auther->amount + $request->amount;
                $auther->save();
                return response()->json([
                    'status' => true,
                    'msg' => "Amount Added To Auther's Account!!"
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => "Something Went Wrong!!"
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all()
            ]);
        }
    }

    public function withdrawDone($withdrawId){
        $withdraw = Withdraw::where('id',$withdrawId)->get()->first();
        if($withdraw){
            $withdraw->status = 1;
            $withdraw->save();
            return Redirect::to(url('/withdraw'));
        }else{
            return Redirect::to(url('/withdraw'));
        }
    }

    public function deletePost($news_id,$category){
            $categories = ['national','business','sports','world','politics','technology','startup','entertainment','miscellaneous','hatke','automobile'];
            if(in_array($category , $categories)){
                $news = News::where('id',$news_id)->get()->first();
            }else{
                $news = TrendingNews::where('id',$news_id)->get()->first();
            }
            if($news){
                $news->status = 2;
                $news->save();
                return Redirect::to(url('/authersPost'));
            }else{
                return Redirect::to(url('/authersPost'));
            }
    }

}
