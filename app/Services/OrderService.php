<?php

// app/Services/Order/OrderService.php
namespace App\Services;

use App\Mail\OrderPlacedMail;
use App\Mail\OrderRefundedMail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected StripeService   $stripeService
    )
    {
    }

    public function placeOrder(array $validated, int $userId)
    {
        return DB::transaction(function () use ($validated, $userId) {
            // 1. Calculate total
            $total = collect($validated['items'])->sum(function ($item) {
                $product = Product::findOrFail($item['product_id']);
                $productPrice = $product->price - $product->discount;
                return $item['quantity'] * $productPrice;
            });

            // 2. Create Order
            $order = $this->orderRepository->create([
                'user_id' => $userId,
                'total_amount' => $total,
                'status' => 'pending',
            ]);

            // 3. Create Order Items from Cart
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => ($product->price - $product->discount) * $item['quantity'],
                ]);
            }

            // 4. Clear Cart
            CartItem::where('user_id', $userId)->delete();
            Mail::to($order->user->email)->queue(new OrderPlacedMail($order));

            return [$order->load('items.product')];
        });
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getOrders();
    }

    public function getUserOrder(int $userId)
    {
        $orders = $this->orderRepository->findUserOrderById($userId);

        if (!$orders) {
            throw new ModelNotFoundException("Order not found");
        }

        return $orders;
    }

    public function findOrderById(int $id)
    {
        return $this->orderRepository->findOrderById($id);
    }

    public function markRefunded($id)
    {
        $order = $this->orderRepository->findOrderById($id);
        Mail::to($order->user->email)->queue(new OrderRefundedMail($order));

        return $this->orderRepository->updateStatus($order, 'refunded');
    }

    public function updateStatusApproved(Order $order)
    {
        return $order->update(['status' => 'approved']);
    }

    public function updateStatusRejected(Order $order)
    {
        return $order->update(['status' => 'rejected']);
    }


}
