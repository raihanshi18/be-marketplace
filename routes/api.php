<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('product', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::post('register', [AuthController::class, 'register']);
Route::post('auth', [AuthController::class, 'auth']);

Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::resource('product-type', ProductTypeController::class);
    Route::post('product', [ProductController::class, 'store']);
    Route::post('product-update/{id}', [ProductController::class, 'update']);
});

Route::resource('banner', BannerController::class);
Route::post('banner-update/{id}', [BannerController::class, 'update']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
