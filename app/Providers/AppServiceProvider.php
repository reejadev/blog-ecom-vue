<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Http::macro('twitter', function () {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . env('AAAAAAAAAAAAAAAAAAAAABWIuAEAAAAA6oJHTdO7w2Fq89WoLPJADSwcSGs%3DVwYu3vVuFuqKkm2RzKPj0C6eyJ1KTPXB8Hjlef7ffdHc5mAIM6'),
                'Content-Type' => 'application/json',
            ])->baseUrl('https://api.twitter.com');
        });

    }
}
