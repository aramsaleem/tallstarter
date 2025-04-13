<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function generateContent($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
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

            return response()->json($response->json());

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to process request',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
