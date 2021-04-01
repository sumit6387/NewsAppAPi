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

    // for register Admin
    Route::view('/registerAdmin' , 'registerAdmin');
    Route::post('/register' , [AdminLoginController::class , 'register']);

    // for auther
    Route::view('/authers' , 'authers');
    Route::get('/getAuther',[AdminShowController::class , 'getAuther']);
    Route::get('/deleteAuther/{auther_id}',[AdminShowController::class , 'deleteAuther']);
    Route::get('/acceptAutherRequest/{autrher_id}',[AdminController::class , 'acceptAutherRequest']); //not done

    // for trending Category
    Route::get('/category',[AdminShowController::class , 'category']);
    Route::get('/deleteCategory/{category_id}',[AdminController::class, 'deleteCategory']);
    Route::post('/addCategory',[AdminController::class , 'addCategory']);
    Route::get('/editCategory/{category_id}',[AdminShowController::class,'editcategory']);
    Route::post('/editCategoryProcess',[AdminController::class,'editCategoryProcess']);

    Route::get('/logout',[AdminLoginController::class , 'logout']);
});
