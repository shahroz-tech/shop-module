<!-- resources/views/admin/create-user.blade.php -->
@extends('layouts.manager')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Register New User</h1>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block font-medium">Name</label>
            <input type="text" name="name" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block font-medium">Email</label>
            <input type="email" name="email" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block font-medium">Password</label>
            <input type="password" name="password" class="border p-2 rounded w-full" required>
        </div>

        <div>
            <label class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" class="border p-2 rounded w-full" required>
        </div>


        <div>
            <label class="block font-medium">Role</label>
            <select name="role" class="border p-2 rounded w-full">
                <option value="customer">Customer</option>
                <option value="manager">Manager</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Register
        </button>
    </form>
@endsection
