<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
route::post('/auth/create_account',[AuthController::class,'create_account']);
route::post('/auth/login',[AuthController::class,'login']);


Route::middleware('auth:Api')->get('/user', function (Request $request) {
    return $request->user();

});
Route::post('/categories',[CategoryController::class,'store']);
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/categories/{id}',[CategoryController::class,'show']);
Route::patch('/categories/{id}',[CategoryController::class,'update']);
Route::delete('/categories/{id}',[CategoryController::class,'delete']);
Route::post('/products',[ProductController::class,'store']);
Route::get('/products',[ProductController::class,'index']);
Route::get('/products/{id}',[ProductController::class,'show']);
Route::patch('/products/{id}',[ProductController::class,'update']);
Route::delete('/products/{id}',[ProductController::class,'delete']);
Route::post('/users/{userId}/products/{productId}/favorites', [ProductController::class, 'addToFavorites']);
Route::delete('/users/{userId}/products/{productId}/favorites', [ProductController::class, 'removeFromFavorites']);
Route::get('/users/{userId}/favorites', [ProductController::class, 'getFavoriteProducts']);







