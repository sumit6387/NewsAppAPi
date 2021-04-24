<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminShowController;
use App\Http\Controllers\Auther\AutherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdminLoginController::class, 'login']);
Route::post('/loginPro', [AdminLoginController::class, 'loginPro']);

Route::group(['middleware' => "CheckAdmin"], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // for register Admin
    Route::view('/registerAdmin', 'registerAdmin');
    Route::post('/register', [AdminLoginController::class, 'register']);

    // for auther
    Route::view('/authers', 'authers');
    Route::get('/getAuther', [AdminShowController::class, 'getAuther']);
    Route::get('/deleteAuther/{auther_id}', [AdminShowController::class, 'deleteAuther']);
    Route::get('/acceptAutherRequest/{autrher_id}', [AdminController::class, 'acceptAutherRequest']);

    // for trending Category
    Route::get('/category', [AdminShowController::class, 'category']);
    Route::get('/deleteCategory/{category_id}', [AdminController::class, 'deleteCategory']);
    Route::post('/addCategory', [AdminController::class, 'addCategory']);
    Route::get('/editCategory/{category_id}', [AdminShowController::class, 'editcategory']);
    Route::post('/editCategoryProcess', [AdminController::class, 'editCategoryProcess']);

    // author post
    Route::get('/authersPost', [AdminShowController::class, 'authersPost']);
    Route::get('/getautherData/{page}', [AdminShowController::class, 'getautherData']);
    Route::post('/approvePost', [AdminController::class, 'approvePost']);
    Route::get('/deleteAuthersPost/{news_id}/{category}', [AdminController::class, 'deletePost']);

    // withdraw
    Route::get('/withdraw', [AdminShowController::class, 'withdraw']);
    Route::get('/getwithdrawData', [AdminShowController::class, 'getwithdrawData']);
    Route::get('/withdrawDone/{withdrawId}', [AdminController::class, 'withdrawDone']);

    Route::get('/logout', [AdminLoginController::class, 'logout']);
});

// for auther
Route::view('/learner/become-auther', 'writer.become-writer');
Route::get('/auther/auther-login', [AutherController::class, 'login']);
Route::post('/learner/becomeAuther', [AutherController::class, 'becomeAuther']);
Route::post('/auther/autherLogin', [AutherController::class, 'autherLogin']);
Route::post('/auther/forgetPassword', [AutherController::class, 'forgetPassword']);
Route::get('/auther/forgetPasswordProcess/{email}', [AutherController::class, 'forgetPasswordProcess']);
Route::post('/auther/changeForgetPassword', [AutherController::class, 'changeForgetPassword']);

Route::group(['middleware' => "CheckAuther", "prefix" => "auther"], function () {
    Route::get('/dashboard', [AutherController::class, 'dashboard']);
    Route::get('writeNews', [AutherController::class, 'writeNews']);
    Route::get('/logout', [AutherController::class, 'logout']);
    Route::post('/submit-post', [AutherController::class, 'submitPost']);
    Route::get('/changepassword', [AutherController::class, 'changepassword']);
    Route::post('/changePasswordProcess', [AutherController::class, 'changePasswordProcess']);
    Route::get('/coins', [AutherController::class, 'coins']);
    Route::get('/getAutherHistory/{page}', [AutherController::class, 'getAutherHistory']);
    Route::view('/withdraw', 'writer.withdraw');
    Route::post('/withdrawProcess', [AutherController::class, 'withdrawProcess']);
});
Route::fallback(function () {
    return view('404');
});
