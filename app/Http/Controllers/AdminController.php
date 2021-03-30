<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
USE App\Models\Auther;

class AdminController extends Controller
{
    public function dashboard(){
        return view('index');
    }

    public function acceptAutherRequest($auther_id){
        dd(Auther::where('auther_id',$auther_id)->get()->first());
    }
}
