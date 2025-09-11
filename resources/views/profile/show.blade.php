{{-- resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <div class="flex gap-2 items-end">
        <h1 class="text-2xl font-semibold mb-6">My Profile</h1>
            <span class="text-md font-semibold mb-6">({{$profile['role']}})</span>
        </div>


        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium">Email (cannot edit)</label>
                <input type="text" value="{{ $profile['user']['email']}}" disabled class="w-full border-gray-300 rounded mt-1">
            </div>

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $profile['user']['name']) }}"
                       class="w-full border-gray-300 rounded mt-1">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $profile['phone']) }}"
                       class="w-full border-gray-300 rounded mt-1">
                @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Address</label>
                <input type="text" name="address" value="{{ old('address', $profile['address']) }}"
                       class="w-full border-gray-300 rounded mt-1">
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Profile
            </button>
        </form>
    </div>

    <script>
    </script>
@endsection
