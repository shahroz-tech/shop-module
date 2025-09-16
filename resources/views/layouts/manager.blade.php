<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>
<body class="flex bg-gray-100">
<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <h2 class="text-2xl font-bold mb-6">Manager Dashboard</h2>
    <nav class="space-y-3">
        <a href="{{ route('manager.reports.index') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
        <a href="{{ route('manager.inventory.index') }}" class="block p-2 rounded hover:bg-gray-700">Inventory</a>
        <a href="/manager/orders" class="block p-2 rounded hover:bg-gray-700">  Manage Orders</a>
        <a href="{{ route('manager.refunds.index') }}" class="block p-2 rounded hover:bg-gray-700"> Refund Requests</a>
        <a href="/products" class="block p-2 rounded hover:bg-gray-700">Products</a>

    </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-6">
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</main>
</body>
</html>
