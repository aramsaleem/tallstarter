<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::get('/{prompt}', [GeminiController::class, 'generateContent']);
Route::get('/prompts', [UserController::class, 'showPrompts']);

Route::get('/debug/gemini', function() {
    return [
        'api_key' => env('GEMINI_API_KEY'),
        'url' => "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=".env('GEMINI_API_KEY'),
        'working_curl' => 'curl "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=YOUR_KEY" -H "Content-Type: application/json" -X POST -d \'{"contents": [{"parts":[{"text": "Explain how AI works"}]}]}\''
    ];
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
