<?php

use App\Http\Controllers\API\ActionLogController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostListController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\PostCondition;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('user/login',[AuthController::class,'login']);
Route::post('user/register',[AuthController::class,'register']);

//category
Route::get('category',[CategoryController::class,'category']);
Route::post('category/search',[CategoryController::class,'categorySearch']);

//post
Route::get('postList',[PostListController::class,'postList']);
Route::post('post/search',[PostListController::class,'postSearch']);
Route::post('post/detail',[PostListController::class,'postDetail']);

//action log
Route::post('post/actionlog',[ActionLogController::class,'setActionLog']);
