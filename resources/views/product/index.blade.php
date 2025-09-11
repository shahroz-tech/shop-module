@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Products</h1>
        {{-- Add Product Button (Managers Only) --}}


        {{-- Filters Form --}}
        <form method="GET" action="{{ route('products.index') }}" class="mb-6 bg-white p-4 rounded-xl shadow-md flex flex-wrap gap-4">
            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2"
                       placeholder="Search by name or description">
            </div>

            {{-- Category --}}
            <div class="flex-1 min-w-[150px]">
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Availability --}}
            <div class="flex-1 min-w-[150px]">
                <select name="in_stock" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">All</option>
                    <option value="1" {{ request('in_stock') === '1' ? 'selected' : '' }}>In Stock</option>
                    <option value="0" {{ request('in_stock') === '0' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>

            {{-- Price Range --}}
            <div class="flex-1 min-w-[100px]">
                <input type="number" name="min_price" value="{{ request('min_price') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Min Price">
            </div>
            <div class="flex-1 min-w-[100px]">
                <input type="number" name="max_price" value="{{ request('max_price') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Max Price">
            </div>

            {{-- Sorting --}}
            <div class="flex-1 min-w-[150px]">
                <select name="sort" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Sort By</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                </select>
            </div>

            {{-- Submit Button --}}
            <div>
                <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Search
                </button>
            </div>
        </form>
        {{-- Add Product Button (Managers Only) --}}
        @can('create', App\Models\Product::class)
            <div class="mb-6 flex justify-end">
                <a href="{{ route('products.create') }}"
                   class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    ➕ Add Product
                </a>
            </div>
        @endcan
         Products List
        @if($products->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                No products available.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-transform transform hover:-translate-y-1 overflow-hidden">
                        <div class="p-4 flex flex-col justify-between h-full">
                            {{-- Product Name --}}
                            <h2 class="text-md font-semibold text-gray-900 mb-1 truncate" title="{{ $product['name'] }}">
                                {{ $product['name'] }}
                            </h2>

                            {{-- Description --}}
                            <p class="text-sm text-gray-500 mb-2 line-clamp-2">
                                {{ $product['description'] }}
                            </p>

                            {{-- Price & Stock --}}
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-lg font-bold text-teal-600">Rs {{ number_format($product['price'], 2) }}</span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                         {{ $product['stock'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $product['stock'] ? "In stock" : "Out of stock" }}
            </span>
                            </div>

                            {{-- Category --}}
                            <div class="mb-3 text-xs text-gray-400 uppercase tracking-wide">
                                {{ $product['category'] ?? 'Uncategorized' }}
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2 mt-2">
                                <a href="{{ route('products.show', $product['id']) }}"
                                   class="flex-1 text-center bg-indigo-600 text-white py-1.5 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                                    View
                                </a>

                                @can('update', App\Models\Product::class)
                                    <a href="/products/{{$product->id}}/edit"
                                       class="flex-1 text-center bg-yellow-500 text-white py-1.5 rounded-lg text-sm font-medium hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                @endcan

                                @can('delete', App\Models\Product::class)
                                    <form action="/products/{{$product->id}}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full bg-red-600 text-white py-1.5 rounded-lg text-sm font-medium hover:bg-red-700 transition"
                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>

                        </div>
                    </div>

                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
