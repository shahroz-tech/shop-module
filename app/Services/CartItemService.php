<?php

namespace App\Services;

use App\Repositories\CartItemRepository;
use App\Repositories\ProductRepository;

class CartItemService
{
    protected CartItemRepository $cartRepo;
    protected ProductRepository $productRepo;

    public function __construct(CartItemRepository $cartRepo, ProductRepository $productRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->productRepo = $productRepo;
    }

    public function getCart()
    {
        return $this->cartRepo->getUserCart(auth()->id());
    }

    public function addToCart($productId, $quantity)
    {
        $product = $this->productRepo->find($productId);
        return $this->cartRepo->addItem(auth()->id(), $product, $quantity);
    }

    public function updateCart($productId, $quantity)
    {
        return $this->cartRepo->updateItem(auth()->id(), $productId, $quantity);
    }

    public function removeFromCart($productId)
    {
        return $this->cartRepo->removeItem(auth()->id(), $productId);
    }

    public function clearCart()
    {
        return $this->cartRepo->clear(auth()->id());
    }
}
