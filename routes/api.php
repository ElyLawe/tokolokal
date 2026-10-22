<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthController;

// Endpoint Login untuk mendapatkan Sanctum Token
Route::post('/login', [AuthController::class, 'login']);

// Endpoint yang dilindungi oleh Middleware Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // API Resource untuk Books
    Route::apiResource('books', BookController::class);
});