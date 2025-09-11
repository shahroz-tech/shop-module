@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">🔄 Refund Requests</h1>

        @if($refunds->count() > 0)
            <div class="space-y-5">
                @foreach($refunds as $refund)
                    <div class="bg-white shadow rounded-lg p-6 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold">Order #{{ $refund->order->id }}</p>
                            <p class="text-gray-600">Requested by: {{ $refund->user->name }}</p>
                            <p class="text-sm text-gray-500 mt-1">Reason: {{ $refund->reason ?? 'No reason provided' }}</p>
                            <p class="text-sm mt-1">
                                Status:
                                <span class="font-semibold {{ $refund->status === 'approved' ? 'text-green-600' : ($refund->status === 'rejected' ? 'text-red-600' : 'text-yellow-600') }}">
                                    {{ ucfirst($refund->status) }}
                                </span>
                            </p>
                        </div>

                        @if($refund->status === 'pending')
                            <form action="{{ route('manager.refunds.approve', $refund->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow">
                                    Approve Refund
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-8 rounded-lg shadow text-center">
                <p class="text-gray-600 text-lg">No refund requests yet 🙌</p>
            </div>
        @endif
    </div>
@endsection
