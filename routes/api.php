<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;



Route::group(['middleware' => "CheckUser"],function(){
    Route::get('/getNews/{category}/{noOfData}',[NewsController::class , 'getNews']);//in header user_id , category and noOfData
    Route::post('/bookmark',[NewsController::class , 'bookmark']); //news_id , in header user_id
    Route::post('/unBookmark',[NewsController::class , 'unBookmark']); //news_id , in header user_id
    Route::get('/getBookmark',[NewsController::Class , 'getBookmark']); //in header user_id
    Route::get('/bookmarkDetail/{bookmark_id}',[NewsController::Class , 'bookmarkDetail']); //in header user_id
});
Route::post('/register' , [NewsController::Class , 'register']); //user_id
Route::get('/setNewsOnDb',[NewsController::class , 'setNewsOnDb']);
Route::fallback(function(){
    return response()->json([
        'status' => false,
        'msg' => "Route Not Found"
    ]);
});
