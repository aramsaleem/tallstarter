<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function generateContent($prompt)
    {
        $apiKey = "AIzaSyBP6t2ALKUw_UCY93pyW0IrRGtCmQkvfhA";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

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

            // Return the raw response (don't double-encode)
            return response()->json($response->json(), $response->status(), [], JSON_PRETTY_PRINT);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to process request',
                'message' => $e->getMessage(),
                'debug' => [
                    'url' => $url,
                    'prompt' => urldecode($prompt)
                ]
            ], 500);
        }
    }
}
