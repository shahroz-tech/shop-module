{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto py-10 px-6">
        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/orders') }}"
                       class="px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 shadow">
                        Show Orders
                    </a>
                    <button type="button"
                            onclick="this.parentElement.parentElement.remove()"
                            class="text-green-700 hover:text-green-900 font-bold">
                        ✕
                    </button>
                </div>
            </div>
        @endif
            @if(session('success_update'))
                <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between">
                    <span>{{ session('success_update') }}</span>
                    <div class="flex items-center gap-3">
                        <button type="button"
                                onclick="this.parentElement.parentElement.remove()"
                                class="text-green-700 hover:text-green-900 font-bold">
                            ✕
                        </button>
                    </div>
                </div>
            @endif
        <h1 class="text-3xl font-semibold text-gray-800 mb-8">🛒 Your Cart</h1>

        @if($cartItems->count() > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="p-4">Product</th>
                        <th class="p-4 text-center">Price</th>
                        <th class="p-4 text-center">Quantity</th>
                        <th class="p-4 text-center">Subtotal</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cartItems as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-4 flex items-center space-x-3">
                                <span class="font-medium text-gray-700">{{ $item->product->name }}</span>
                            </td>
                            <td class="p-4 text-center text-gray-600">Rs. {{ number_format($item->product->price, 2) }}</td>
                            <td class="p-4 text-center">
                                <form action="/cart/update/{{$item->product->id}}" method="POST" class="flex justify-center items-center space-x-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                           min="1" class="w-16 border rounded-md text-center">
                                    <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">
                                        Update
                                    </button>
                                </form>
                            </td>
                            <td class="p-4 text-center text-gray-700 font-semibold">
                                Rs. {{ number_format($item->quantity * $item->product->price, 2) }}
                            </td>
                            <td class="p-4 text-center">
                                <form action="/cart/remove/{{$item->product->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm">
                                        Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Summary Section -->
                <div class="flex justify-between items-center p-6 bg-gray-50 border-t">
                    <div>
                        <p class="text-gray-600">Total Items:
                            <span class="font-semibold">{{ $cartItems->sum('quantity') }}</span>
                        </p>
                        <p class="text-gray-600">Last Updated:
                            <span class="font-semibold">{{ now()->format('d M Y, h:i A') }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-800">
                            Total: Rs. {{ number_format($cartItems->sum(fn($i) => $i->quantity * $i->product->price), 2) }}
                        </p>

                        <!-- Place Order Form -->
                        <form action="{{ url('/orders') }}" method="POST">
                            @csrf
                            @foreach($cartItems as $item)
                                <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}">
                            @endforeach

                            <button type="submit"
                                    class="inline-block mt-3 bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg shadow-md transition">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
        @else
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-600 text-lg">Your cart is empty 🛍️</p>
                <a href="{{ route('products.index') }}"
                   class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>
@endsection
