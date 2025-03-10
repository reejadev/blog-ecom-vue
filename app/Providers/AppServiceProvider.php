<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use App\Http\Helpers\Cart;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;

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
        View::composer('layouts.layout', function ($view) {
            $cartItems = Cart::getCartItems();
            $ids = Arr::pluck($cartItems, 'product_id');
            $products = Product::query()->whereIn('id', $ids)->get();
            $cartItems = Arr::keyBy($cartItems, 'product_id');
            $total = 0;
            
            foreach ($products as $product) {
                $total += $product->price * $cartItems[$product->id]['quantity'];
            }
    
            $view->with(compact('cartItems', 'products', 'total'));
        });





        Http::macro('twitter', function () {
            return Http::withHeaders([
                'Authorization' => 'Bearer ' . env('AAAAAAAAAAAAAAAAAAAAABWIuAEAAAAA6oJHTdO7w2Fq89WoLPJADSwcSGs%3DVwYu3vVuFuqKkm2RzKPj0C6eyJ1KTPXB8Hjlef7ffdHc5mAIM6'),
                'Content-Type' => 'application/json',
            ])->baseUrl('https://api.twitter.com');
        });

    }
}
