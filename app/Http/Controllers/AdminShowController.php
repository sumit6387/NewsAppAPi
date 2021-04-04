<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Auther;
use App\Models\TrendingCategory;
use App\Models\TrendingNews;
use App\Models\News;
use App\Models\Withdraw;

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

        public function authersPost(){
            return view('autherpost');
        }

        public function getautherData($page){
            $autherNews = TrendingNews::orderby('id','desc')->where('status',0)->where('writtenBy',"!=","")->get();
            $arr = array();
            foreach ($autherNews as $key => $value) {
                array_push($arr,$value);
            }
            $news = News::orderby('id','desc')->where('status',0)->where('writtenBy',"!=","")->get();
            foreach ($news as $key => $value) {
                array_push($arr,$value);
            }
            $data = array();
            $arr1 = collect($arr)->forPage($page,5);
            foreach ($arr1 as $key => $value) {
                array_push($data,$value);
            }
            if(count($arr)){
                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => "No Data Found!!"
                ]);
            }
        }

        public function withdraw(){
            return view('withdraw');
        }

        public function getwithdrawData(){
            $withdraw = Withdraw::orderby('id','desc')->where('status',0);
            if(count($withdraw->get())){
                return response()->json([
                    'status' => true,
                    'data' => $withdraw->paginate(10)
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'msg' => "No Data Found!!"
                ]);
            }


        }
}
