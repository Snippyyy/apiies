<?php

use App\Http\Controllers\Api\V3\CategoryController;
use App\Http\Controllers\Api\V3\CommentController;
use App\Http\Controllers\Api\V3\LoginController;
use App\Http\Controllers\Api\V3\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class);

Route::get('lists/categories', [CategoryController::class,  'list']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);

    //Productos
    Route::get('products', [ProductController::class,  'index'])
        ->middleware('throttle:products');
    Route::get('products/{product}', [ProductController::class,  'show']);
    Route::post('products', [ProductController::class,  'store']);
    Route::put('products/{product}', [ProductController::class,  'update']);
    Route::delete('products/{product}', [ProductController::class,  'destroy']);

    //Comentarios
    Route::get('products/{product}/comments', [CommentController::class,  'index']);
    Route::post('products/{product}', [CommentController::class,  'store']);
    Route::delete('products/{product}/comments/{comment}', [CommentController::class, 'destroy']);
    Route::get('products/{product}/comments/{comment}', [CommentController::class, 'show']);
    Route::put('products/{product}/comments/{comment}', [CommentController::class, 'update'])->scopeBindings();

});
