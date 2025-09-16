<?php

namespace App\Services;

use App\Repositories\CartItemRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Session;

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
        $addedItem = $this->cartRepo->addItem(auth()->id(), $product, $quantity);
        $cartCount = $this->cartRepo->getUserCart(auth()->id())->count();
        Session::put('cart_count', $cartCount);
        return $addedItem;

    }

    public function updateCart($productId, $quantity)
    {

        $updateItem = $this->cartRepo->updateItem(auth()->id(), $productId, $quantity);

        $cartCount = $this->cartRepo->getUserCart(auth()->id())->count();
        Session::put('cart_count', $cartCount);
        return $updateItem;
    }

    public function removeFromCart($productId)
    {
        $removedItem = $this->cartRepo->removeItem(auth()->id(), $productId);

        $cartCount = $this->cartRepo->getUserCart(auth()->id())->count();
        Session::put('cart_count', $cartCount);        return $removedItem;
    }

    public function clearCart()
    {
        return $this->cartRepo->clear(auth()->id());
    }
}
