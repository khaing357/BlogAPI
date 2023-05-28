<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware(['auth:api'])->group(function(){
Route::post('logout',[AuthController::class,'logout']);

//Profile
Route::get('profile',[ProfileController::class,'profile']);
Route::get('profilePosts',[ProfileController::class,'index']);

 //Category
 Route::get('categories',[CategoryController::class,'index']);

 //Post
 Route::get('posts',[PostController::class,'index']);
 Route::get('posts/{postId}',[PostController::class,'show']);
 Route::post('post',[PostController::class,'create']);
});
