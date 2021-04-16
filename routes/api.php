<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => "CheckUser"], function () {
    Route::get('/getNews/{category}/{page}', [NewsController::class, 'getNews']); //in header token , category and noOfData
    Route::post('/bookmark', [NewsController::class, 'bookmark']); //news_id , in header token
    Route::post('/unBookmark', [NewsController::class, 'unBookmark']); //news_id , in header token
    Route::get('/getBookmark/{page}', [NewsController::class, 'getBookmark']); //in header token
    Route::put('/like', [NewsController::class, 'like']); //in header token and news_id,
    Route::put('/disLike', [NewsController::class, 'disLike']); //in header token and news_id,
    Route::get('/getRandomNews/{page}', [NewsController::class, 'getRandomNews']); //in header token
    Route::get('/getTrandingNewsCategory', [NewsController::class, 'getTrandingNewsCategory']);
    Route::get('/getTrendingNews/{category}/{page}', [NewsController::class, 'getTrendingNews']);
});
Route::post('/register', [NewsController::class, 'register']); //user_id
Route::get('/setNewsOnDb', [NewsController::class, 'setNewsOnDb']);
Route::fallback(function () {
    return response()->json([
        'status' => false,
        'msg' => "Route Not Found",
    ]);
});
