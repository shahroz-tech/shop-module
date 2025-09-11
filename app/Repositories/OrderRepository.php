<?php
// app/Repositories/Order/OrderRepository.php
namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function findUserOrderById(int $userId)
    {
        return Order::with('items.product')
            ->where('user_id', $userId)
            ->get();
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


}
