@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Reports & Analytics</h1>

        <!-- Sales Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">Total Revenue</h2>
                <p class="text-2xl font-bold text-green-600">
                    ${{ number_format($reportData['sales']->revenue ?? 0, 2) }}
                </p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">Orders</h2>
                <p class="text-2xl font-bold text-blue-600">
                    {{ $reportData['sales']->orders ?? 0 }}
                </p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">Avg Order Value</h2>
                <p class="text-2xl font-bold text-purple-600">
                    ${{ number_format($reportData['sales']->avg_order ?? 0, 2) }}
                </p>
            </div>
        </div>

        <!-- Customers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">🆕 New Customers (This Month)</h2>
                <p class="text-2xl font-bold text-indigo-600">{{ $reportData['newCustomers'] ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-700">🔁 Returning Customers</h2>
                <p class="text-2xl font-bold text-pink-600">{{ $reportData['returningCustomers'] ?? 0 }}</p>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">🔥 Top Products</h2>
            <table class="min-w-full border-collapse">
                <thead>
                <tr class="bg-gray-100 text-gray-700 text-sm">
                    <th class="py-3 px-4 border-b text-left">Product</th>
                    <th class="py-3 px-4 border-b text-left">Quantity Sold</th>
                    <th class="py-3 px-4 border-b text-left">Revenue</th>
                </tr>
                </thead>
                <tbody>
                @forelse($reportData['topProducts'] as $product)
                    <tr class="text-sm text-gray-600 border-b">
                        <td class="py-3 px-4">{{ $product->product->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $product->total_quantity ?? 0 }}</td>
                        <td class="py-3 px-4">${{ number_format($product->total_revenue ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-center text-gray-500">No data available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
