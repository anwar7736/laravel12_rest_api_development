<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function(){
    Route::middleware('auth:sanctum')->group(function(){
        Route::apiResource('products', ProductController::class);
        Route::post('user-logout', [AuthController::class, 'logout']);
    });
    Route::post('user-registration', [AuthController::class, 'register']);
    Route::login('user-login', [AuthController::class, 'login']);
});
