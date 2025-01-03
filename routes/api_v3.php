<?php

use App\Http\Controllers\Api\V3\CategoryController;
use App\Http\Controllers\Api\V3\ProductController;
use App\Http\Controllers\Api\V3\SubcategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('lists/categories', [CategoryController::class,  'list']);
Route::get('lists/subcategories', [SubcategoryController::class,  'list']);


Route::apiResource('subcategories', SubcategoryController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('privatelists/subcategories', [SubcategoryController::class,  'privateList']);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class)->middleware('throttle:products');

});
