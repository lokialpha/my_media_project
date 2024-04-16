<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrendPostController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\PostCondition;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //admin profile
    Route::get('/dashboard',[ProfileController::class,'index'])->name('dashboard');
    Route::post('/admin/update',[ProfileController::class,'updateAdminInfo'])->name('admin#update');
    Route::get('admin/changePassword',[ProfileController::class,'adminChangePassword'])->name('admin#changePassword');
    Route::post('admin/changePassword',[ProfileController::class,'PasswordChange'])->name('admin#passwordChange');

    // category
    Route::get('category',[CategoryController::class,'index'])->name('admin#category');
    Route::post('category',[CategoryController::class,'createCategory'])->name('admin#createCategory');
    Route::get('category/delete/{id}',[CategoryController::class,'deleteCategory'])->name('admin#deleteCategory');
    Route::post('category/search',[CategoryController::class,'categorySearch'])->name('admin#categorySearch');
    Route::get('category/edit/{id}',[CategoryController::class,'categoryEditPage'])->name('admin#categoryEditPage');
    Route::post('category/update/{id}',[CategoryController::class,'categoryUpdate'])->name('admin#categoryUpdate');

    //admin list
    Route::get('admin/list',[ListController::class,'index'])->name('admin#list');
    Route::get('admin/delete/{id}',[ListController::class,'deleteAccount'])->name('admin#deleteAccount');
    Route::post('admin/list',[ListController::class,'adminSearchList'])->name('admin#searchList');

    //post
    Route::get('post',[PostController::class,'index'])->name('admin#post');
    Route::post('admin/createPost',[PostController::class,'postCreate'])->name('admin#postCreate');
    Route::get('admin/deletePost/{id}',[PostController::class,'postDelete'])->name('admin#postDelete');
    Route::get('admin/editPost/{id}',[PostController::class,'PostEditPage'])->name('admin#postEditPage');
    Route::post('admin/updatePost/{id}',[PostController::class,'updatePost'])->name('admin#updatePost');

    //trend post
    Route::get('trendPost',[TrendPostController::class,'index'])->name('admin#trendPost');
    Route::get('trendPost/details/{id}',[TrendPostController::class,'trendPostDetails'])->name('admin#trendPostDetail');
});
