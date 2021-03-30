<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminShowController;
use App\Http\Controllers\Auther\AutherController;



Route::get('/',[AdminLoginController::Class , 'login']);
Route::post('/loginPro' , [AdminLoginController::class , 'loginPro']);
Route::view('/learner/become-auther','writer.become-writer');
Route::post('/learner/becomeAuther',[AutherController::class , 'becomeAuther']);

Route::group(['middleware' => "CheckAdmin"] , function(){
    Route::get('/dashboard' , [AdminController::class , 'dashboard']);
    Route::post('/register' , [AdminLoginController::class , 'register']);
    Route::view('/registerAdmin' , 'registerAdmin');
    Route::view('/authers' , 'authers');
    Route::get('/getAuther',[AdminShowController::class , 'getAuther']);
    Route::get('/deleteAuther/{auther_id}',[AdminShowController::class , 'deleteAuther']);
    Route::get('/acceptAutherRequest/{autrher_id}',[AdminController::class , 'acceptAutherRequest']);
    Route::get('/logout',[AdminLoginController::class , 'logout']);
});
