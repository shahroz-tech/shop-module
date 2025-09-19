@extends('layouts.manager')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Manage Users</h1>
    @can('create',App\Models\User::class)
        <a href="{{ route('users.create') }}"
           class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded">
            + Create New User
        </a>
    @endcan
    <table class="w-full bg-white rounded shadow">
        <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-3">ID</th>
            <th class="p-3">Name</th>
            <th class="p-3">Email</th>
            <th class="p-3">Role</th>
            @if(auth()->user()->profile->role === 'admin')
                <th class="p-3">Action</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="border-b">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->profile->role}}</td>
                @if(auth()->user()->profile->role === 'admin')

                    <td class="p-3">
                        @if($user->profile->role === 'admin')
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6 text-gray-600 inline-block"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <!-- Head -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z"/>
                                <!-- Body -->
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6 20c0-3.31 2.69-6 6-6s6 2.69 6 6"/>
                            </svg>

                        @else
                            <form action="{{ route('admin.assignRole', $user->id) }}" method="POST"
                                  class="flex space-x-2">
                                @csrf
                                <select name="role" class="border rounded p-1">
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Assign</button>
                            </form>
                            @can('delete',App\Models\User::class)

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete
                                    </button>
                                </form>
                            @endcan
                        @endif

                    </td>
                @endif

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
