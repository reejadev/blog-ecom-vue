@extends('layouts.layout')

@section('content')

<header>

    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-4 block md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- <div x-data x-init="$store.header.fetchCart()">
        <span x-text="$store.header.cartItems"></span>
    </div> -->

    <main class="p-5">

        <!-- Product List -->
        <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
            <!-- Product Item -->


            @foreach($products as $product)


            <div x-data="productItem({{ json_encode([
        'id' => $product->id,
        'title' => $product->title,
        'description' => $product->description,
        'price' => $product->price,
        'addToCartUrl' => route('cart.add', $product)
        
    ]) }})">

                <a href="{{ route('products.show', $product->id) }}" class="block overflow-hidden">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"
                        class="rounded-lg hover:scale-105 hover:rotate-1 transition-transform" />
                </a>

                <div class="p-4">
                    <h3 class="font-bold">{{ $product->title }}
                    </h3>
                    <h3 class="text-lg">{{ $product->description }}
                    </h3>
                    <h5 class="font-bold">{{ $product->price }}</h5>

                </div>


                <div class="flex justify-between py-3 px-4">
                    <button
                        class="w-10 h-10 rounded-full border border-1 border-purple-600 flex items-center justify-center text-purple-600 hover:bg-purple-600 hover:text-white active:bg-purple-800 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <button x-data class="btn-primary" @click="addToCart()">Add to Cart</button>



                </div>
            </div>
            @endforeach
        </div>
        <!--/ Product List -->

    </main>


    <div class="block fixed z-10 top-0 bottom-0  w-[220px] transition-all bg-slate-900 md:hidden">
        <!-- Add your menu items here -->
    </div>




</header>


@endsection