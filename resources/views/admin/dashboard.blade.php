<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard</h1>
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold">Total Orders</h2>
            <p class="text-2xl mt-2">{{ $sales['total_orders'] }}</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold">Total Revenue</h2>
            <p class="text-2xl mt-2">Rs{{ number_format($sales['total_revenue'], 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-semibold">Sales by User</h2>
            <ul class="mt-2 space-y-1">
                @foreach($sales['sales_by_user'] as $sale)
                    <li>{{ $sale->user->name ?? 'Unknown' }}: Rs{{ $sale->revenue }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
