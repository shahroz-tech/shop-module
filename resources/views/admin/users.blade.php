<!-- resources/views/admin/users.blade.php -->
@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manage Users</h1>

    <table class="w-full bg-white rounded shadow">
        <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-3">ID</th>
            <th class="p-3">Name</th>
            <th class="p-3">Email</th>
            <th class="p-3">Role</th>
            <th class="p-3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->profile->role}}</td>
                <td class="p-3">
                    <form action="{{ route('admin.assignRole', $user->id) }}" method="POST" class="flex space-x-2">
                        @csrf
                        <select name="role" class="border rounded p-1">
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Assign</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
