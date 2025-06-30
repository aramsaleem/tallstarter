<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function generateContent($prompt)
{
    $apiKey = "AIzaSyBP6t2ALKUw_UCY93pyW0IrRGtCmQkvfhA";
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";
        $user = User::create([
            'name' => $prompt,
            'email' => uniqid() . '@prompt.local', // fake unique email (required by users table)
            'password' => bcrypt('password'),      // fake password (required by users table)
        ]);
    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => urldecode($prompt)]
                    ]
                ]
            ]
        ]);

        $responseData = $response->json();

        // Extract just the text content
        $text = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if ($text === null) {
            return response()->json([
                'error' => 'No text content found in response',
                'full_response' => $responseData
            ], 500);
        }

        // Return just the plain text (not JSON)
        return response($text)->header('Content-Type', 'text/plain');

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to process request',
            'message' => $e->getMessage()
        ], 500);
    }
}
}
