<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::get('/{prompt}', [GeminiController::class, 'generateContent']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
