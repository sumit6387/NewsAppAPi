<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;



Route::group(['middleware' => "CheckUser"],function(){
    Route::get('/getNews/{category}/{page}',[NewsController::class , 'getNews']);//in header token , category and noOfData
    Route::post('/bookmark',[NewsController::class , 'bookmark']); //news_id , in header token
    Route::post('/unBookmark',[NewsController::class , 'unBookmark']); //news_id , in header token
    Route::get('/getBookmark/{page}',[NewsController::Class , 'getBookmark']); //in header token 
    Route::put('/like',[NewsController::class , 'like']);//in header token and news_id
    Route::put('/disLike',[NewsController::class , 'disLike']); //in header token and news_id
    Route::get('/getRandomNews/{page}',[NewsController::class , 'getRandomNews']);//in header token
});
Route::post('/register' , [NewsController::Class , 'register']); //user_id
Route::get('/setNewsOnDb',[NewsController::class , 'setNewsOnDb']); 
Route::fallback(function(){
    return response()->json([
        'status' => false,
        'msg' => "Route Not Found"
    ]);
});
