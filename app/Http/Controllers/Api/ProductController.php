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
use App\Models\ProductImage; // Ensure you have a ProductImage model
use Illuminate\Support\Facades\Log;

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust as needed
            //  'additional_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

              if ($request->hasFile('image')) {               
           
            $image = $request->file('image');
            $relativePath = $image->store('images', 'public');
            $validatedData['image'] =$relativePath;                  
            $validatedData['image_mime'] = $image->getClientMimeType();
            $validatedData['image_size'] = $image->getSize();
              }
                
        
        $product = Product::create($validatedData);
    
        return response()->json(['data' => $product], 201);
    }

    public function uploadAdditionalImages(Request $request, $productId)
    {
       
        $product = Product::findOrFail($productId);
        Log::info('Attempting to find product with ID:', ['product_id' => $productId]);
        $request->validate([
            'additionalImages.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the images
        ]);
    
        $uploadedImages = [];
    
        if ($request->hasFile('additionalImages')) {
            Log::info('Files received for upload:', ['files' => $request->file('additionalImages')]);
      
            foreach ($request->file('additionalImages') as $image) {
                $path = $image->store('product_images', 'public'); // Store image in the 'public/product_images' directory
    
                // Save the image path to the database
                $productImage = new ProductImage();
                $productImage->product_id = $productId;
                $productImage->image_path = $path;
                $productImage->mime_type = $image->getClientMimeType();
                $productImage->size = $image->getSize();
                $productImage->save();
    
                //$uploadedImages[] = $path;

                $uploadedImages[] = [
                    'product_id' => $productImage->id,
                    'image_path' => $productImage->image_path,
                    'mime_type' => $productImage->mime_type,
                    'size' => $productImage->size,
                ];
            }
        }
    
        return response()->json(['uploaded_images' => $uploadedImages], 200);
    }  
    
    public function getAdditionalImages($productId)
    {
        Log::info('Fetching additional images for product with ID:', ['product_id' => $productId]);

        try {
            // Fetch additional images associated with the product ID
            $images = ProductImage::where('product_id', $productId)->get();

            if ($images->isEmpty()) {
                Log::info('No additional images found for product ID:', ['product_id' => $productId]);
                return response()->json(['message' => 'No additional images found for this product.'], 404);
            }

            Log::info('Additional images fetched successfully for product ID:', ['product_id' => $productId]);
            return response()->json($images, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching additional images:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    
    

    // public function show(Product $product)
    // {
    //     return new ProductResource($product);
    // }

    public function show($id)
    {
        // Fetch the product by ID
        $product = Product::find($id);

        // Check if the product exists
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Return the product details as a JSON response
        return response()->json(['data' => $product], 200);
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