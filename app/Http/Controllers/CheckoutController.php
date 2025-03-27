<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\CartItem;
use App\Enums\OrderStatus;
use App\Http\Helpers\Cart;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{


    public function checkout(Request $request)
{
   \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));


  list($products,$cartItems) =  Cart::getProductsAndCartItems();  
  //dd($products, $cartItems);
   $lineItems = [];
   $totalPrice = 0;
   foreach ($products as $product) {
    $quantity = $cartItems[$product->id]['quantity'];
    $totalPrice += $product->price*$quantity;
        $lineItems[]=[
    'price_data'=> [
        'currency'=> 'usd',
        'product_data'=> [
          'name'=> $product->title,
          'images'=> [$product->image]

        ],
        'unit_amount'=> $product->price*100,
    ],
      'quantity'=> $cartItems[$product->id]['quantity'],
];

   }
 //  dd($lineItems);
   $session = \Stripe\Checkout\Session::create([
    'line_items' => $lineItems,    
    'mode'=> 'payment',
    'success_url'=> route('success',[],true). '?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url'=> route('failure',[],true) ,
   ]);
 // dd($session->id);
//   echo '<pre>';
// var_dump($user->id);
// echo '</pre>';


$orderData = [
    'total_price' =>$totalPrice,
    'status' => OrderStatus::Unpaid,
    // 'created_by'=>$user->id,
    // 'updated_by'=>$user->id,
];
$order = Order::create($orderData);
// echo '<pre>';
// var_dump($order);
// echo '</pre>';

$paymentData = [
    'order_id' => $order->id,
    'amount' => $totalPrice,
    'status'=> PaymentStatus::Pending,
    'type'=>'cc',
    'session_id'=>$session->id
  
];

Payment::create($paymentData);
// echo '<pre>';
// var_dump($payment);
// echo '</pre>';
// exit;


return redirect($session->url);
}


public function success(Request $request)
{
    \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

    try {
        $session_id = $request->get('session_id');
        \Log::info('Session ID received: ' . $session_id); // Log the received session ID

        $session = \Stripe\Checkout\Session::retrieve($session_id);
        if (!$session) {
            \Log::error('Stripe session not found for session ID: ' . $session_id);
            return view('checkout.failure', ['message'=> 'Session does not exist']);
        }
        \Log::info('Stripe session retrieved successfully: ' . $session->id); // log the session id after retrieval

        if ($session->payment_status !== 'paid') {
            \Log::error('Stripe payment not paid for session ID: ' . $session->id . '. Status: ' . $session->payment_status);
            return view('checkout.failure');
        }
        \Log::info('Stripe payment status is paid.');

        $payment = Payment::query()->where(['session_id' => $session->id, 'status' => PaymentStatus::Pending])->first();
        if (!$payment) {
            \Log::error('Payment not found for session ID: ' . $session->id);
            return view('checkout.failure',['message'=> 'Payment does not exist']);
        }
        \Log::info('Payment record found. Payment ID: ' . $payment->id); // Log the payment ID

        $payment->status = PaymentStatus::Paid;
        $payment->update();

        $order = $payment->order;
        $order->status = OrderStatus::Paid;
        $order->update();

         CartItem::query()->delete();
         Cookie::queue(Cookie::forget('cart_items'));
         
        \Log::info('Payment and order statuses updated successfully.');
        return view('checkout.success', compact('session'));

    } catch (\Stripe\Exception\ApiErrorException $e) {
        \Log::error('Stripe API Error: ' . $e->getMessage());
        return view('checkout.failure');

    } catch (\Exception $e) {
        \Log::error('General Error: ' . $e->getMessage());
        return view('checkout.failure',['message'=> $e-> getMessage()]);
    }
}



    public function failure(Request $request)
    {
    dd ($request->all());
    }



}