@extends('layouts.manager')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Manage Orders</h1>

        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded-md shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded-md shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="space-y-5">
                @foreach($orders as $order)
                    <div x-data="{ open: false }" class="bg-white shadow rounded-lg">
                        <!-- Header -->
                        <div class="flex justify-between items-center p-6 cursor-pointer" @click="open = !open">
                            <div>
                                <p class="font-semibold text-lg text-gray-800">Order #{{ $order->id }}</p>
                                <p class="text-sm text-gray-500">Customer: {{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">Placed: {{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $order->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
                                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Collapsible Content -->
                        <div x-show="open" x-collapse class="p-6 border-t">
                            <!-- Actions -->
                            @if($order->status === 'paid')
                                <div class="flex gap-2 mb-4">
                                    <form action="{{ route('manager.orders.approve', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm">Approve</button>
                                    </form>
                                    <form action="{{ route('manager.orders.reject', $order->id) }}" method="POST">
                                        @csrf
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">Reject</button>
                                    </form>
                                </div>
                            @endif

                            <!-- Items Table -->
                            <table class="w-full text-sm border-collapse">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 text-left">Product</th>
                                    <th class="p-2 text-center">Qty</th>
                                    <th class="p-2 text-center">Price</th>
                                    <th class="p-2 text-center">Discount</th>
                                    <th class="p-2 text-center">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $item->product->name ?? 'Deleted product' }}</td>
                                        <td class="p-2 text-center">{{ $item->quantity }}</td>
                                        <td class="p-2 text-center">Rs. {{ number_format($item->price, 2) }}</td>
                                        <td class="p-2 text-center">{{ $item->product->discount }}%</td>
                                        <td class="p-2 text-center font-semibold">Rs. {{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-500">No orders available yet.</p>
            </div>
        @endif
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>

@endsection
