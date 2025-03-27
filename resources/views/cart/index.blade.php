@extends('layouts.layout')

@section('content')
<main class="p-5">
    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">My Cart Items</h1>

        <div x-data="{
            cartItems: {{ json_encode($products->map(fn($product) => [
                'id' => $product->id,
                'slug' => $product->slug,
                'image' => asset('storage/' . $product->image),
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $cartItems[$product->id]['quantity'] ?? 1,
                'href' => route('products.view', $product->slug),
                'removeUrl' => route('cart.remove', $product),
                'updateQuantityUrl' => route('cart.update-quantity', $product),
            ])) }},
            
            get total() {
                return this.cartItems.reduce((accum, next) => accum + (next.price * next.quantity), 0).toFixed(2);
            },

            removeItemFromCart(product) {
                this.cartItems = this.cartItems.filter(p => p.id !== product.id);
            }
        }">

            <template x-for="product in cartItems" :key="product.id">
                <div x-data="productItem(product)">

                    <div class="flex items-center justify-between p-4 border-b">
                        <!-- Product Image -->
                        <a :href="product.href" class="w-20 h-20 product-image-container">
                            <img :src="product.image" class="object-cover w-full h-full" :alt="product.title" />
                        </a>

                        <!-- Product Details -->
                        <div class="flex-1 flex flex-col justify-between ml-4">
                            <div class="flex justify-between mb-3 ml-2 flex-1">
                                <h3 x-text="product.title" class="font-bold"></h3>
                                <span class="text-lg font-semibold">$<span x-text="product.price"></span></span>
                            </div>

                            <!-- Quantity & Remove Button -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center ml-2 flex-1">
                                    Qty:
                                    <input type="number" min="1" x-model="product.quantity" @change="changeQuantity()"
                                        class="ml-3 py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16" />
                                </div>
                                <a href="#" class="text-purple-600 hover:text-purple-500"
                                    x-on:click.prevent="removeItemFromCart()">Remove</a>

                            </div>
                        </div>
                    </div>
                </div>
            </template>


            <template x-if="!cartItems.length">
                <div class="text-center py-8 text-gray-500">
                    No items in cart
                </div>
            </template>



            <div class="border-t border-gray-300 pt-4">
                <div class="flex justify-between">
                    <span class="font-semibold">Subtotal</span>
                    <span class="text-xl font-bold" x-text="`$${total}`"></span>
                </div>
                <p class="text-gray-500 mb-6">
                    Shipping and taxes calculated at checkout.
                </p>
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary w-full py-3 text-lg">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</main>
@endsection