<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository
{
    public function getTopProducts(int $limit = 5)
    {
        return OrderItem::selectRaw('product_id, SUM(quantity) as sold, SUM(price*quantity) as revenue')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('sold')
            ->take($limit)
            ->get();
    }
}
