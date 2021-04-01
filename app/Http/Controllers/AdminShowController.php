<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Auther;
use App\Models\TrendingCategory;

class AdminShowController extends Controller
{
        public function getAuther(){
            $authers = Auther::where("approved",0);
            if($authers->get()){
                return response()->json([
                    'status' => true,
                    'data' => $authers->paginate(10)
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => "No Data Found!!"
                ]);
            }
        }

        public function deleteAuther($auther_id){
            $get_auther = Auther::where('auther_id',$auther_id)->get()->first();
            if($get_auther){
                $get_auther->delete();
                return Redirect::to(url('/authers'));
            }else{
                return Redirect::to(url('/authers'));
            }
        }

        public function category(){
            $categories = TrendingCategory::orderby('id','desc')->get();
            return view('category',['categories' => $categories]);
        }

        public function editcategory($category_id){
            $category = TrendingCategory::where('id',$category_id)->get()->first();
            return view('editcategory',['category'=>$category]);
        }
}
