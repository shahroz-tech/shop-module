<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 flex">

<!-- Sidebar -->
<aside class="fixed top-0 left-0 w-64 h-screen bg-gray-800 text-white flex flex-col justify-between p-4">
    <div>
        <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
        <nav class="space-y-3">
            <a href="{{ route('reports.index') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
            <a href="{{ route('users.index') }}" class="block p-2 rounded hover:bg-gray-700">Users</a>
            <a href="{{ route('profile.show') }}" class="block p-2 rounded hover:bg-gray-700">Profile</a>
            <a href="/products" class="block p-2 rounded hover:bg-gray-700">Products</a>
            <a href="{{ route('inventory.index') }}" class="block p-2 rounded hover:bg-gray-700">Inventory</a>
            <a href="{{ route('orders.allOrders') }}" class="block p-2 rounded hover:bg-gray-700">Manage Orders</a>
            <a href="{{ route('refunds.index') }}" class="block p-2 rounded hover:bg-gray-700">Refund Requests</a>
        </nav>
    </div>

    <!-- Logout button at the bottom -->
    <form method="POST" action="/auth/logout" class="mt-6">
        @csrf
        <button type="submit" class="w-full p-2 rounded hover:bg-gray-700 text-red-400 text-left">
            Logout
        </button>
    </form>
</aside>

<!-- Main Content (shifted right by sidebar width) -->
<main class="ml-64 flex-1 p-6">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
