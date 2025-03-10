<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/dist/output.css" rel="stylesheet" />
    <!-- Alpine Plugins -->
    <script defer src="https://unpkg.com/@alpinejs/persist@3.10.2/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.10.2/dist/cdn.min.js"></script>
    <script defer src="app.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <style>
    [x-cloak] {
        display: none !important;
    }
    </style>
</head>

<body>
    <header x-data="{mobileMenuOpen: false}" class="flex justify-between bg-slate-800 shadow-md text-white">
        <div>
            <a href="/src" class="block py-navbar-item pl-5"> Logo </a>
        </div>
        <!-- Responsive Menu -->
        <div class="block fixed z-10 top-0 bottom-0 height h-full w-[220px] transition-all bg-slate-900 md:hidden">
            <!-- Add your menu items here -->
        </div>
    </header>
    <main class="container mx-auto mt-5">
        <h1 class="text-2xl font-bold mb-5">{{ $product->title }}</h1>
        <div class="bg-white p-5 rounded shadow">
            <p class="text-gray-700">{{ $product->description }}</p>
            <p class="text-gray-500 mt-3">{{ $product->price }}</p>
            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="150" height="150"> <a </div>
                <div class="mt-5">
                    <a href="{{ route('products.index') }}" class="text-blue-500">Back to Products</a>
                </div>
    </main>
</body>

</html>