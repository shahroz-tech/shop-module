@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Product Info -->
            <div class="lg:col-span-1">
                <div class="sticky top-20 border border-gray-200 bg-white rounded-2xl p-6 shadow-md">
                    <!-- Flash Success -->
                    @if(session('success'))
                        <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between">
                            <span>{{ session('success') }}</span>
                            <div class="flex items-center gap-3">
                                <a href="{{ url('/cart') }}"
                                   class="px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 shadow">
                                    Show Cart
                                </a>
                                <button type="button"
                                        onclick="this.parentElement.parentElement.remove()"
                                        class="text-green-700 hover:text-green-900 font-bold">
                                    ✕
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Product -->
                    <h1 class="text-2xl font-bold text-gray-900">{{ $product['name'] }}</h1>
                    <p class="mt-2 text-gray-600 leading-relaxed">{{ $product['description'] }}</p>

                    <p class="mt-4 text-3xl font-extrabold text-green-700">
                        Rs {{ number_format($product['price'], 2) }}
                    </p>

                    <p class="mt-3">
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        {{ $product['stock'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $product['stock'] ? "In Stock" : "Out of Stock" }}
                    </span>
                    </p>

                    <p class="mt-2 text-sm text-gray-500">
                        Category: <span class="font-medium text-gray-700">{{ $product['category'] }}</span>
                    </p>

                    <!-- CTA -->
                    <div class="mt-6">
                        <form action="/cart/add" method="POST" class="flex flex-col gap-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product['id'] }}">

                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1"
                                       class="mt-1 block w-24 border-gray-300 rounded-md shadow-sm focus:ring-yellow-400 focus:border-yellow-400 sm:text-sm">
                            </div>

                            <button type="submit"
                                    class="px-6 py-2.5 text-center
                                       {{ session('success') ? 'bg-gray-400 cursor-not-allowed' : 'bg-yellow-400 hover:bg-yellow-500' }}
                                       text-gray-900 font-medium rounded-lg shadow transition"
                                {{ session('success') ? 'disabled' : '' }}>
                                {{ session('success') ? 'Added to Cart' : 'Add to Cart' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Reviews -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm h-[75vh] overflow-y-auto">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Reviews</h2>

                    @if($product->reviews->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($product->reviews as $review)
                                <div class="py-4">
                                    <div class="flex items-center justify-between">
                                        <h3 class="font-medium text-gray-800">
                                            {{ $review->user->name ?? 'Anonymous' }}
                                        </h3>
                                        <span class="text-sm text-gray-500">{{ $review->created_at->format('Y-m-d') }}</span>
                                    </div>
                                    <p class="mt-2 text-gray-600 text-sm">{{ $review->review }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No reviews yet. Be the first to review!</p>
                    @endif
                </div>

                <!-- Add Review Form -->
                <div class="mt-8 bg-white border border-gray-200 rounded-2xl p-6 shadow-md">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Write a Review</h2>

                    <form action="/review" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" value="{{ $product->id }}" name="product_id">

                        <div>
                            <label for="review" class="block text-sm font-medium text-gray-700">Your Review</label>
                            <textarea id="review" name="review" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                      required></textarea>
                            @error('review')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow transition">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
