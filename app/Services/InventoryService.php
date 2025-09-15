<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class InventoryService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getInventoryData(): array
    {
        return [
            'products'    => $this->productRepository->getAll(),
            'lowStock'    => $this->productRepository->getLowStock(),
            'outOfStock'  => $this->productRepository->getOutOfStock(),
        ];
    }
}
