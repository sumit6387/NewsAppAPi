<?php

namespace App\Http\Controllers\Auther;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auther;
use Validator;

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
}
