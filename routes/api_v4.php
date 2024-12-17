<?php

use App\Http\Controllers\Api\V4\CategoryController;
use App\Http\Controllers\Api\V4\CommentController;
use App\Http\Controllers\Api\V4\LoginController;
use App\Http\Controllers\Api\V4\ProductController;
use App\Http\Controllers\Api\V4\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class);

Route::get('lists/categories', [CategoryController::class,  'list']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class);

    //Productos usar luego apiResource
    //Route::get('products', [ProductController::class,  'index'])
    //     ->middleware('throttle:products');
    //Route::get('products/{product}', [ProductController::class,  'show']);
    //Route::post('products', [ProductController::class,  'store']);
    //Route::put('products/{product}', [ProductController::class,  'update']);
    //Route::delete('products/{product}', [ProductController::class,  'destroy']);
    Route::ApiResource('products', ProductController::class)->middleware('throttle:products');




    //Comentarios  ApiResource no usa rutas de doble anidamiento por lo que se debe hacer manualmente1
    Route::get('products/{product}/comments', [CommentController::class,  'index']);
    Route::post('products/{product}', [CommentController::class,  'store']);
    Route::delete('products/{product}/comments/{comment}', [CommentController::class, 'destroy']);
    Route::get('products/{product}/comments/{comment}', [CommentController::class, 'show']);
    Route::put('products/{product}/comments/{comment}', [CommentController::class, 'update'])->scopeBindings();


    //Tags
    Route::get('tags', [TagController::class, 'index']);
    Route::post('tags', [TagController::class, 'store']);
    Route::get('tags/{tag}', [TagController::class, 'show']);
    Route::put('tags/{tag}', [TagController::class, 'update']);
    Route::delete('tags/{tag}', [TagController::class, 'destroy']);

});
