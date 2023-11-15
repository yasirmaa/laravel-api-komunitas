<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::apiResource('products', ProductController::class)->middleware(['auth:sanctum']);

Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('products', ProductController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('categories', CategoryController::class)->only('store', 'update', 'destroy');
    Route::apiResource('products', ProductController::class)->only('store', 'update', 'destroy');
    Route::apiResource('comments', CommentController::class)->only('store', 'update', 'destroy');
    // Route::apiResource('comments', CommentController::class)->only('store', 'update', 'destroy')->middleware('pemilik-komentar');
    // Route::patch('/products/{id}', [ProductController::class, 'update'])->middleware('pemilik-product');
    // Route::apiResource('products', ProductController::class)->only('update')->middleware('pemilik-product');
});
