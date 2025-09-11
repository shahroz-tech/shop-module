@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-6">
        @if(session('success'))
            <div class="mb-6 bg-green-100 text-green-800 border border-green-300 px-4 py-3 rounded-md shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        <h1 class="text-2xl font-semibold mb-6">💸 Refund Requests</h1>

        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Request #</th>
                <th class="border px-4 py-2">Order #</th>
                <th class="border px-4 py-2">Customer</th>
                <th class="border px-4 py-2">Reason</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($refunds as $refund)
                <tr>
                    <td class="border px-4 py-2">{{ $refund->id }}</td>
                    <td class="border px-4 py-2">{{ $refund->order_id }}</td>
                    <td class="border px-4 py-2">{{ $refund->user->name }}</td>
                    <td class="border px-4 py-2">{{ $refund->reason }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($refund->status) }}</td>
                    <td class="border px-4 py-2">
                        @if($refund->status === 'pending')
                            <form action="{{ route('manager.refunds.approve',$refund->id)}}" method="POST">
                                @csrf
                                <button class="bg-green-600 text-white px-3 py-1 rounded-md">Approve Refund</button>
                            </form>
                        @else
                            <span class="text-gray-500">Processed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
