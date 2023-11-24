<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::apiResource('products', ProductController::class)->only('index', 'show');
Route::apiResource('comments', CommentController::class)->only('index', 'show');
Route::apiResource('categories', CategoryController::class)->only('index', 'show');

Route::get('category/{category:slug}', [ProductController::class, 'showByCategory']);
Route::get('jual/{user:username}', [ProductController::class, 'showByUser']);
Route::get('image/{filename}', [ImageController::class, 'getImage']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::patch('/profile/{user:id}', [AuthController::class, 'update']);

    Route::apiResource('products', ProductController::class)->only('store', 'update', 'destroy');
    Route::apiResource('comments', CommentController::class)->only('store', 'update', 'destroy');
    Route::apiResource('categories', CategoryController::class)->only('store', 'update', 'destroy');
    // Route::apiResource('comments', CommentController::class)->only('store', 'update', 'destroy')->middleware('pemilik-komentar');
    // Route::patch('/products/{id}', [ProductController::class, 'update'])->middleware('pemilik-product');
    // Route::apiResource('products', ProductController::class)->only('update')->middleware('pemilik-product');
});
