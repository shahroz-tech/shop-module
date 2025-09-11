<?php

namespace App\Services\ProductService;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(array $filters = [])
    {
        $query = $this->productRepository->query()->where('is_active', true);

        // Search
        if (!empty($filters['search'])) {
            $query->where(function($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        // Category filter
        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        // Price range filter
        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        // Availability filter
        if (isset($filters['in_stock'])) {
            $filters['in_stock']
                ? $query->where('stock', '>', 0)
                : $query->where('stock', '=', 0);
        }

        // Sorting
        if (!empty($filters['sort'])) {
            match ($filters['sort']) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'latest'     => $query->orderBy('created_at', 'desc'),
                default      => null,
            };
        }

        return $this->productRepository->paginate($query);
    }

    public function store(array $data): Product
    {
        return $this->productRepository->create($data);
    }

    public function show(Product $product): Product
    {
        return $this->productRepository->show($product->id);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->productRepository->update($product, $data);
    }

    public function destroy(Product $product): bool
    {
        return $this->productRepository->delete($product);
    }
}
