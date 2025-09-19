@extends('layouts.manager')

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 Manager Dashboard</h1>

        <!-- Sales Overview -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-lg font-semibold">Total Revenue</h2>
                <p class="text-2xl font-bold text-green-600">PKR{{ number_format($sales->revenue, 2) }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-lg font-semibold">Orders</h2>
                <p class="text-2xl font-bold text-blue-600">{{ $sales->orders }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <h2 class="text-lg font-semibold">Avg Order</h2>
                <p class="text-2xl font-bold text-purple-600">PKR{{ number_format($sales->avg_order, 2) }}</p>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white shadow rounded-xl p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">🔥 Top Products</h2>
            <table class="w-full border">
                <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Product</th>
                    <th class="p-2">Sold</th>
                    <th class="p-2">Revenue</th>
                </tr>
                </thead>
                <tbody>
                @foreach($topProducts as $product)
                    <tr>
                        <td class="p-2">{{ $product->product->name }}</td>
                        <td class="p-2">{{ $product->sold }}</td>
                        <td class="p-2">${{ number_format($product->revenue, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Customer Trends -->
{{--        <div class="bg-white shadow rounded-xl p-6 w-[50%]">--}}
{{--            <h2 class="text-xl font-semibold mb-4">👥 Customer Trends</h2>--}}
{{--            <p>New Customers: <strong>{{ $newCustomers }}</strong></p>--}}
{{--            <p>Returning Customers: <strong>{{ $returningCustomers }}</strong></p>--}}
{{--            <canvas id="customerChart" class="h-20 w-20 mt-4"></canvas>--}}
{{--        </div>--}}
    </div>
@endsection

{{--@push('scripts')--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
{{--    <script>--}}
{{--        new Chart(document.getElementById('customerChart'), {--}}
{{--            type: 'doughnut',--}}
{{--            data: {--}}
{{--                labels: ['New', 'Returning'],--}}
{{--                datasets: [{--}}
{{--                    data: [{{ $newCustomers }}, {{ $returningCustomers }}],--}}
{{--                    backgroundColor: ['#34d399', '#60a5fa']--}}
{{--                }]--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
