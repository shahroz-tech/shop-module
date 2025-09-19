<?php
namespace App\Repositories;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function getOrders(){
        return Order::with('items.product','user')->latest()->paginate(10);
    }

    public function findUserOrderById(int $userId)
    {
        return Order::with('items.product')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update(['status' => $status]);
        return $order;
    }

    public function findOrderById(int $id)
    {
        return Order::findOrFail($id);
    }

    public function totalOrders()
    {
        return Order::count();
    }

    public function totalRevenue()
    {
        return Order::sum('total_amount');
    }

    public function salesByUser()
    {
        return Order::selectRaw('user_id, SUM(total_amount) as revenue')
            ->groupBy('user_id')
            ->with('user')
            ->get();
    }

    public function getSalesSummary()
    {
        return Order::selectRaw('SUM(total_amount) as revenue, COUNT(*) as orders, AVG(total_amount) as avg_order')
            ->whereMonth('created_at', Carbon::now()->month)
            ->first();
    }

//    public function getUniqueCustomerCountThisMonth()
//    {
//        return Order::whereMonth('created_at', Carbon::now()->month)
//            ->distinct('user_id')
//            ->count();
//    }
    public function createOrderItem(Order $order, array $item): void
    {
        $product = Product::findOrFail($item['product_id']);
        $product->update(['stock'=>$product->stock -  $item['quantity']]);
        $order->items()->create([
            'product_id' => $product->id,
            'quantity'   => $item['quantity'],
            'price'      => $product->price,
            'subtotal'   => ($product->price - $product->discount) * $item['quantity'],
        ]);
    }

    public function calculateTotal(array $items): float
    {
        return collect($items)->sum(function ($item) {
            $product = Product::findOrFail($item['product_id']);
            return $item['quantity'] * ($product->price - $product->discount);
        });
    }

    public function clearCart(int $userId): void
    {
        CartItem::where('user_id', $userId)->delete();
    }
}
