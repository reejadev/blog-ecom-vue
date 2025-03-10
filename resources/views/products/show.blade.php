@extends('layouts.layout')

@section('content')
<p x-text="id"></p>
<main class="p-5">
    <div class="container mx-auto">
        <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
            <!-- Images and Thumbnails Section (3 columns) -->
            <div class="lg:col-span-3">
                <div x-data="{
                    images: [
                        '{{ asset('storage/' . $product->image) }}',
@foreach($product->images as $image)
                            '{{ asset('storage/' . $image->image_path) }}',
@endforeach
                    ],
                    activeImage: null,
                    init() {
                        console.log(this.images); // Debugging: Check the images array
                        this.activeImage = this.images[0];
                    },
                    prev() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === 0) index = this.images.length;
                        this.activeImage = this.images[index - 1];
                    },
                    next() {
                        let index = this.images.indexOf(this.activeImage);
                        if (index === this.images.length - 1) index = -1;
                        this.activeImage = this.images[index + 1];
                    }
                }">
                    <!-- Display Active Image -->
                    <div class="relative mb-6">
                        <template x-if="activeImage">
                            <img :src="activeImage" alt="Active Image" class="rounded-lg w-full h-96 object-cover">
                        </template>

                        <!-- Navigation Buttons -->
                        <button @click="prev"
                            style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); background-color: black; color: white; padding: 8px 16px; border-radius: 8px;">
                            Prev
                        </button>
                        <button @click="next"
                            style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); background-color: black; color: white; padding: 8px 16px; border-radius: 8px;">
                            Next
                        </button>
                    </div>

                    <!-- Additional Images Thumbnails -->
                    <div class="flex flex-wrap gap-4">
                        <template x-for="(image, index) in images" :key="index">
                            <img :src="image" :alt="`Additional Image ${index + 1}`" @click="activeImage = image"
                                class="rounded-lg w-20 h-20 object-cover cursor-pointer border-2"
                                :class="{'border-blue-500': activeImage === image, 'border-gray-300': activeImage !== image}"
                                style="width: 80px; height: 80px;" />
                        </template>
                    </div>
                </div>
            </div>

            <!-- Product Details Section (2 columns) -->
            <div class="lg:col-span-2">
                <h1 class="text-lg font-semibold">
                    {{ $product->slug }}
                </h1>
                <div class="text-xl font-bold mb-6"> {{ $product->price }}</div>
                <div class="flex items-center mb-6">
                    <div class="flex items-center text-orange-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <a href="#" class="ml-3 font-normal text-purple-600 hover:text-purple-500">
                        {{ $product->reviews }} reviews
                    </a>

                </div>
                <div class="flex items-center justify-between mb-5">
                    <label for="quantity" class="block font-bold mr-4">
                        Quantity
                    </label>
                    <input type="number" name="quantity" x-ref="quantityEl" value="{{ $product->quantity }}"
                        class="w-32 focus:border-purple-500 focus:outline-none rounded" />
                </div>
                <button @click="addToCart(id, $refs.quantityEl.value)"
                    class="btn-primary py-4 text-lg flex justify-center min-w-0 w-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Add to Cart
                </button>
                <div class="mb-6" x-data="{expanded: false}">
                    <div x-show="expanded" x-collapse.min.120px class="text-gray-500 wysiwyg-content">
                        <table>
                            <tbody>

                                <tr>
                                    <td>Rating</td>
                                    <td>{{ $product->rating }}</td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td>{{ $product->brand }} </td>
                                </tr>


                            </tbody>
                        </table>

                        <!-- <p class="">
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                            Deserunt suscipit natus quisquam optio voluptatem quo beatae
                            ex similique, pariatur laborum asperiores explicabo delectus
                            culpa cumque corrupti quasi incidunt at quos!
                        </p> -->
                        <h4>About the item</h4>
                        <ul class="list-disc pl-6">
                            <!-- <li>
                                Hero 25K sensor through a software update from G HUB, this
                                upgrade is free to all players: Our most advanced, with 1:1
                                tracking, 400-plus ips, and 100 - 25,600 max dpi sensitivity
                                plus zero smoothing, filtering, or acceleration
                            </li>
                            <li>
                                11 customizable buttons and onboard memory: Assign custom
                                commands to the buttons and save up to five ready to play
                                profiles directly to the mouse
                            </li>
                            <li>
                                Adjustable weight system: Arrange up to five removable 3.6
                                grams weights inside the mouse for personalized weight and
                                balance tuning
                            </li>
                            <li>
                                Programmable RGB Lighting and Lightsync technology:
                                Customize lighting from nearly 16.8 million colors to match
                                your team's colors, sport your own or sync colors with other
                                Logitech G gear
                            </li>
                            <li>
                                Mechanical switch button tensioning: Metal spring tensioning
                                system and pivot hinges are built into left and right gaming
                                mouse buttons for a crisp, clean click feel with rapid click
                                feedback
                            </li> -->

                            <!-- <li>{{ $product->description }}</li> -->

                            @foreach(explode(',', $product->description) as $point)
                            <li>{{ trim($point) }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <p class="text-right">
                        <a @click="expanded = !expanded" href="javascript:void(0)"
                            class="text-purple-500 hover:text-purple-700"
                            x-text="expanded ? 'Read Less' : 'Read More'"></a>

                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Toast -->
<div x-data="toast" x-show="visible" x-transition x-cloak @notify.window="show($event.detail.message)"
    class="fixed w-[400px] left-1/2 -ml-[200px] top-16 py-2 px-4 pb-4 bg-emerald-500 text-white">
    <div class="font-semibold" x-text="message"></div>
    <button @click="close"
        class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <!-- Progress -->
    <div>
        <div class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10" :style="{'width': `${percent}%`}"></div>
    </div>
</div>
<!--/ Toast -->
@endsection