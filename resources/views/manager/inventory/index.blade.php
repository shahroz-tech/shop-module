@extends('layouts.manager')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">📦 Inventory Management</h1>

        <!-- Stock Overview -->
        <div class="bg-white shadow rounded-xl p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">All Products</h2>
            <table class="w-full border">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Product</th>
                    <th class="p-2 text-left">Stock</th>
                    <th class="p-2 text-left">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr class="{{ $product->stock == 0 ? 'bg-red-100' : ($product->stock < 10 ? 'bg-yellow-100' : '') }}">
                        <td class="p-2">{{ $product->name }}</td>
                        <td class="p-2">{{ $product->stock }}</td>
                        <td class="p-2">
                            @if($product->stock == 0)
                                <span class="text-red-600 font-bold">Out of Stock</span>
                            @elseif($product->stock < 10)
                                <span class="text-yellow-600 font-semibold">Low Stock</span>
                            @else
                                <span class="text-green-600 font-semibold">In Stock</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Alerts -->
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4">
                <h2 class="font-bold text-yellow-700">⚠️ Low Stock</h2>
                <ul>
                    @forelse($lowStock as $product)
                        <li>{{ $product->name }} ({{ $product->stock }} left)</li>
                    @empty
                        <li>No products are low on stock 🎉</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-red-50 border border-red-300 rounded-lg p-4">
                <h2 class="font-bold text-red-700">❌ Out of Stock</h2>
                <ul>
                    @forelse($outOfStock as $product)
                        <li>{{ $product->name }}</li>
                    @empty
                        <li>No products are out of stock 🎉</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
