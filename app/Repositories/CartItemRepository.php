<?php

namespace App\Repositories;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartItemRepository
{
    public function getUserCart($userId)
    {
        return CartItem::with('product')->where('user_id', $userId)->get();
    }

    public function addItem($userId, Product $product, $quantity)
    {
        return CartItem::updateOrCreate(
            ['user_id' => $userId, 'product_id' => $product->id],
            ['quantity' => $quantity,'price' =>($product->price - $product->discount) * $quantity],
        );
    }

    public function updateItem($userId, $productId, $quantity)
    {

        $item = CartItem::where('user_id', $userId)->where('product_id', $productId)->first();
        if (!$item) return null;
        $product = Product::where('id', $productId)->first();
        $item->update(['quantity' => $quantity,'price'=>  ($product->price - $product->discount) * $quantity]);
        return $item;
    }

    public function removeItem($userId, $productId)
    {
        return CartItem::where('user_id', $userId)->where('product_id', $productId)->delete();
    }

    public function clear($userId)
    {
        return CartItem::where('user_id', $userId)->delete();
    }
}
