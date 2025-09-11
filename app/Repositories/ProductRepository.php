<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{
    public function query()
    {
        return Product::query();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function paginate($query, int $perPage = 12): LengthAwarePaginator
    {
        return $query->paginate($perPage);
    }

    public function find($productId)
    {
        return Product::findOrFail($productId);
    }
    public function show($id)
    {
        return Product::with(['reviews.user'])->findOrFail($id);
    }
}
