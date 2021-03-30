<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;
use Validator;
use Session;

class AdminLoginController extends Controller
{
    public function register(Request $request){
        $valid = Validator::make($request->all() , ['name' => "required" , 'email' => "required" , 'password' => "required"]);
        if($valid->passes()){
            $check = Admin::where('email',$request->email)->get()->first();
            if($check){
                return response()->json([
                    'status' => false,
                    'msg' => "Email Already Registered!!"
                ]);
            }
            $new_admin = new Admin();
            $new_admin->name = $request->name;
            $new_admin->email = $request->email;
            $new_admin->password = Hash::make($request->password);
            $new_admin->save();
            return response()->json([
                'status' => true,
                'msg' => 'Admin Registered Successfully!!'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all()
            ]);
        }
    }

    public function loginPro(Request $request){
        $valid = Validator::make($request->all() , ['email' => "required" , 'password' => "required"]);
        if($valid->passes()){
            $admin = Admin::where('email',$request->email)->get()->first();
            if($admin){
                if(Hash::check($request->password,$admin->password)){
                    Session::put('name',$admin->name);
                    Session::put('email',$request->email);
                    return response()->json([
                        'status' => true,
                        'url' => url('/dashboard')
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
                    'msg' => "Enter Correct Email!!"
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'msg' => $valid->errors()->all()
            ]);
        }
    }

    public function logout(Request $req){
        $req->session()->forget('email');
       return Redirect::to(url('/'));
    }

    public function login(){
        if(Session::get('email')){
            return Redirect::to(url('/dashboard'));
        }
        return view('login');
    }
}
