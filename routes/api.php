<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminiController;

Route::get('/{prompt}', [GeminiController::class, 'generateContent']);
Route::get('/ask/{prompt}', function (string $prompt) {

    // Laravel automatically URL-decodes the $prompt parameter from the path

    // Prepare a simple JSON response
    $response = [
        'status'   => 'success',
        'method'   => 'GET',
        'prompt_received_from_url' => $prompt, // The decoded prompt
        'reply'    => "Laravel received the GET prompt: '{$prompt}'"
    ];

    // Return the data as JSON
    return response()->json($response);

})->where('prompt', '.*'); // IMPORTANT: This allows the {prompt} to contain slashes '/'

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
