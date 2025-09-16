@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto py-10">
        @if(session('success'))
            <div class="mb-6 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/products') }}"
                       class="px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 shadow">
                        Show Products
                    </a>
                    <button type="button"
                            onclick="this.parentElement.parentElement.remove()"
                            class="text-green-700 hover:text-green-900 font-bold">
                        ✕
                    </button>
                </div>
            </div>
        @endif
        <h1 class="text-2xl font-semibold mb-6">➕ Add Product</h1>

        <form action="/manager/products" method="POST">
            @csrf
            <div class="mb-4">
                <label>Name</label>
                <input required type="text" name="name" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label>Price</label>
                <input required type="number" step="0.01" name="price" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label>Discount</label>
                <input required type="number" step="0.01" name="discount" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label>Stock</label>
                <input required type="number" name="stock" class="w-full border rounded p-2">
            </div>
            <div class="mb-4">
                <label>Description</label>
                <textarea name="description" class="w-full border rounded p-2"></textarea>
            </div>
            <div class="mb-4">
                <label>Category</label>
                <input required type="text" name="category" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Save</button>
        </form>
    </div>
@endsection
