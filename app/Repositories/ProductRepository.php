<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{
    public function getAll()
    {
        return Product::all();
    }

    public function getLowStock(int $threshold = 10)
    {
        return Product::where('stock', '<', $threshold)->get();
    }

    public function getOutOfStock()
    {
        return Product::where('stock', '=', 0)->get();
    }
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

    public function getProductCategories(){
        return Product::query()->distinct()->pluck('category');

    }
}
