<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class APIController extends Controller
{
    public function userTimeline()
    {
        $screenName = 'RahulGandhi';
        // Use the twitter macro to make a GET request to the Twitter API
        $response = Http::twitter()->get('/1.1/users/lookup.json', [
            'screen_name' => $screenName,
            'count' => 10,
        ]);
        Log::info('Twitter API Response', ['status' => $response->status(), 'body' => $response->body()]);
        // Handle the response
        if ($response->successful()) {
            $tweets = $response->json();
            return view('twitter.timeline', compact('tweets'));
        } else {
            $error = $response->json();
            return view('twitter.timeline')->withErrors(['error' => 'Unable to fetch tweets']);
        }
    }
}
