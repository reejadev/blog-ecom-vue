<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Http\Helpers\Cart;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;


class CartController extends Controller
{

   public function index()   {
    
    list($products,$cartItems) = Cart::getProductsAndCartItems();
 $total = 0;
 foreach($products as $product) {

    $total += $product->price * $cartItems[$product->id]['quantity'];
 }
return view('cart.index', compact('cartItems','products','total'));
   }


   public function add(Request $request, Product $product)
   {
    $quantity = $request->post('quantity', 1);

    // 1. Handle Cookie Cart
    $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
    $productFound = false;

    foreach ($cartItems as &$item) {
        if ($item['product_id'] === $product->id) {
            $item['quantity'] += $quantity;
            $productFound = true;
            break;
        }
    }

    if (!$productFound) {
        $cartItems[] = [
            'product_id' => $product->id,
            'quantity' => $quantity,
            'price' => $product->price,
        ];
    }

    Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30); // 30 days cookie expiration

    // 2. Handle Database Cart (if needed after login)
    // if (auth()->check()) { // Check if user is logged in (optional)
         $cartItem = CartItem::where(['product_id' => $product->id, 'user_id' => null])->first(); //Added user_id null

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => null,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }
    //}

    return response([
        'count' => Cart::getCountFromItems($cartItems), // Using cookie cart count
        'message' => 'The item was added to cart'
    ]);


//    <--code with user -->
    // $quantity = $request->post('quantity', 1);
// $user = $request->user();
// if ($user)
// {
//     $cartItem = CartItem::where(['user_id' => $user->id, 'product_id'=>$product->id])->first();

//     if($cartItem) {
//        $cartItem->quantity += $quantity;
//         $cartItem->update();
//     }else{
//         $data = [
//             'user_id'=> $request->user()->id,
//             'product_id' => $product->id,
//             'quantity' => $quantity,
//         ];

//         CartItem::create($data);
//     }

//     return response([
//         'count' => Cart::getCartItemsCount()
//     ]);
// }else {
//     $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
//     $productFound = false;
//     foreach ($cartItems as &$item) {
//         if($item['product_id'] === $product->id){
//             $item['quantity'] += $quantity;
//             $productFound = true;
//             break;
//         }
//     }
//     if (!$productFound) {
//         $cartItems[]=[
//             'user_id'=>null,
//             'product_id' => $product->id,
//             'quantity' => $quantity,
//             'price' => $product->price
//         ];
//     }
//     Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);
//     return response([
//         'count' => Cart::getCountFromItems($cartItems),
//           'message' => 'The item was added to cart'
//     ]);
 
   }

   public function remove(Request $request, Product $product)
   {
    // $user = $request->user();
    // if ($user){
    //     $cartItem = CartItem::query()->where(['user_id'=> $user->id, 'product_id'=> $product->id])->first();
    //     if ($cartItem){
    //         $cartItem->delete();
            
    //     }
    //     return response([
    //         'count'=>Cart::getCartItemsCount(),
    //     ]);
    // }else{
    //     $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
    //     foreach($cartItems as $i => &$item) {
    //         if($item['product_id']===$product->id){
    //             array_splice($cartItems, $i, 1);
    //             break;
    //         }
    //     }
    //     Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);

    //     return response(['count'=> Cart::getCountFromItems($cartItems)]);
    // }

    $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
    foreach ($cartItems as $i => &$item) {
        if ($item['product_id'] === $product->id) {
            array_splice($cartItems, $i, 1);
            break;
        }
    }
    Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

    // Remove from Database Cart
    $cartItem = CartItem::where(['product_id' => $product->id, 'user_id' => null])->first();
    if ($cartItem) {
        $cartItem->delete();
    }

    // Return Response
    return response(['count' => Cart::getCountFromItems($cartItems)]);
   }

   public function updateQuantity(Request $request, Product $product)
   {
   // $quantity = (int)$request->post('quantity');
    //$user = $request->user();
    // if($user){
    //     CartItem::where(['user_id'=> $request->user()->id, 'product_id'=>$product->id])->update(['quantity'=>$quantity]);

    //     return response([
    //         'count' => Cart::getCartItemsCount(),
    //     ]);
    // }else{
        // $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
        // foreach($cartItems as &$item) {
        //     if($item['product_id']===$product->id){
        //        $item['quantity'] = $quantity;
        //        break;
        //      }
    // }
//     Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);
//     return response(['count'=> Cart::getCountFromItems($cartItems)]);

//    }
$quantity = (int) $request->post('quantity');

// Update Cookie Cart
$cartItems = json_decode($request->cookie('cart_items', '[]'), true);
foreach ($cartItems as &$item) {
    if ($item['product_id'] === $product->id) {
        $item['quantity'] = $quantity;
        break;
    }
}
Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

// Update Database Cart (if needed)
$cartItem = CartItem::where(['product_id' => $product->id, 'user_id' => null])->first();
if ($cartItem) {
    $cartItem->quantity = $quantity;
    $cartItem->save();
} else {
    // If the item doesn't exist in the database, create it
    CartItem::create([
        'user_id' => null,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'price' => $product->price,
    ]);
}

return response(['count' => Cart::getCountFromItems($cartItems)]);

}



}