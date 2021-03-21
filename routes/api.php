<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => "CheckUser"],function(){
    Route::get('/getNews/{category}/{noOfData}',[NewsController::class , 'getNews']);
    Route::post('/bookmark',[NewsController::class , 'bookmark']);
    Route::post('/unBookmark',[NewsController::class , 'unBookmark']);
});
Route::get('/setNewsOnDb',[NewsController::class , 'setNewsOnDb']);
Route::fallback(function(){
    return response()->json([
        'status' => false,
        'msg' => "Route Not Found"
    ]);
});
