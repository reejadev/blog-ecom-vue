<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Models\Product;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\ProductListResource;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // $perPage = $request->get('per_page', 10);
        // $search = $request->get('search', '');
        // $sortField = $request->get('sort_field', 'updated_at');
        // $sortDirection = $request->get('sort_direction', 'desc');

        // $query = Product::query()
        //     ->where('title','like',"%{$search}%")
        //     ->orderBy($sortField, $sortDirection)
        //     ->paginate($perPage);

        //     return ProductListResource::collection($query);

        $products = Product::all();

        foreach ($products as $product) {
            $product->image = url('storage/' . $product->image);
        }

        return response()->json(['data' => $products]);
    }

    //public function store(ProductRequest $request)
    public function store(Request $request)
    {
        // $data = $request->validated();
        // $data['created_by'] = $request->user()->id;
        // $data['updated_by'] = $request->user()->id;

        // $image = $data['image'] ?? null;

        // if($image) {
        //     $relativePath = $this->saveImage($image);
        //     $data['image'] = URL::to(Storage::url($relativePath));
        //     $data['image_mime']=$image->getClientMimeType();
        //     $data['image_size']=$image->getSize();
        // }
        // $product = Product::create($data);

        // return new ProductResource($product);


        //sending image as url

        // $validatedData = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'price' => 'required|numeric',
        //     'image' => 'required|string' // Assuming image is a URL
        // ]);

        // $product = Product::create($validatedData);

        // return response()->json(['data' => $product], 201);

        //sending image as a file
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust as needed
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('images', 'public');
            //$validatedData['image'] = $filePath;
            $validatedData['image'] = Storage::url($filePath);
        }

        $product = Product::create($validatedData);

        return response()->json(['data' => $product], 201);
    }
    
    

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
         
        $image = $data['image'] ?? null;

        if($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            $data['image_mime']=$image->getClientMimeType();
            $data['image_size']=$image->getSize();
        
       if($product->image){
        Storage::deleteDirectory('/public/'.dirname($product->image));
       }
    }
       $product->update($data);

       return new ProductResource($prodcut);
    }

    // public function destroy(Product $product)
    // {
    //     $product->delete();

    //     return response()->noContent();
        
    // }

    public function destroy(Product $product)
{
    \Log::info('Deleting product: ' . $product->id);
    $product->delete();
    \Log::info('Product deleted successfully');
    return response()->noContent();
}

    private function saveImage(UploadedFile $image) {
        $path = 'images/' . Str::random();
        
        // Ensure the path is unique
        while (Storage::exists($path)) {
            $path = 'images/' . Str::random();
        }
        
        // Save the image to the unique path
        $storedPath = $image->storeAs($path, $image->getClientOriginalName());
        
        return $storedPath;
    }
}