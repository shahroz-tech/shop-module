@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">📦 My Orders</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div
                class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between shadow-sm">
                <span>{{ session('success') }}</span>
                <button type="button" onclick="this.parentElement.remove()"
                        class="text-green-700 hover:text-green-900 font-bold">
                    ✕
                </button>
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="space-y-5">
                @foreach($orders as $order)
                    <div x-data="{ open: false }" class="bg-white shadow-lg rounded-xl overflow-hidden hover:shadow-md transition cursor-pointer">

                        <!-- Order Header -->
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center px-6 py-4" @click="open = !open">
                            <div>
                                <p class="text-gray-800 font-semibold text-lg">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Placed: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}
                                </p>
                            </div>
                            <div class="mt-3 md:mt-0 flex items-center space-x-3">
                                <p class="text-gray-800 font-bold text-lg">Rs. {{ number_format($order->total_amount, 2) }}</p>
                                <span class="px-3 py-1 text-xs rounded-full font-semibold
                                {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->status) }}
                            </span>

                                <!-- Pay Button (only if unpaid) -->
                                @if($order->status === 'pending')
                                    <form action="{{ route('order.pay', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-md text-sm shadow-sm transition">
                                            Pay
                                        </button>
                                    </form>
                                @endif
                                <!-- Inside Order Header Buttons -->
                                @if($order->status === 'paid' || $order->status === 'rejected')
                                    <form action="{{ route('refunds.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                        <button type="submit"
                                                class="ml-2 bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-md text-sm shadow-sm transition">
                                            Request Refund
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items (Expandable) -->
                        <div x-show="open" x-collapse class="px-6 py-4 bg-gray-50">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 text-sm font-medium text-gray-600">Product</th>
                                    <th class="p-3 text-sm font-medium text-center text-gray-600">Quantity</th>
                                    <th class="p-3 text-sm font-medium text-center text-gray-600">Price</th>
                                    <th class="p-3 text-sm font-medium text-center text-gray-600">Discount</th>
                                    <th class="p-3 text-sm font-medium text-center text-gray-600">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-b hover:bg-gray-100 transition">
                                        <td class="p-3 text-gray-700">{{ $item->product->name ?? 'Product deleted' }}</td>
                                        <td class="p-3 text-center">{{ $item->quantity }}</td>
                                        <td class="p-3 text-center">Rs. {{ number_format($item->price, 2) }}</td>
                                        <td class="p-2 text-center">{{$item->product->discount}}%</td>

                                        <td class="p-3 text-center font-semibold">Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                <p class="text-gray-600 text-lg mb-4">You don’t have any orders yet 🛍️</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-sm transition">
                    Start Shopping
                </a>
            </div>
        @endif
        @if($orders->count() > 0)
            <div class="space-y-5">
                @foreach($orders as $order)
                    <!-- order card here -->
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                <p class="text-gray-600 text-lg mb-4">You don’t have any orders yet 🛍️</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-sm transition">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
