<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->orderBy('updated_at', 'desc')->paginate(10);
        return view('products.index',[
            'products' =>$products
        ]);
    }

    public function view(Product $product)
    {
        return view('products.view',['product'=>$product]);
    }

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        //dd($product->images); // Fetch product and its additional images
        return view('products.show', compact('product'));
    }
}