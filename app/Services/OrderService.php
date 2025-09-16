<?php

// app/Services/Order/OrderService.php
namespace App\Services;

use App\Mail\OrderPlacedMail;
use App\Mail\OrderRefundedMail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderService
{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected StripeService   $stripeService,
        protected ProductRepository $productRepository,
    )
    {
    }

    public function placeOrder(array $validated, int $userId)
    {
        return DB::transaction(function () use ($validated, $userId) {
            Session::put('cart_count', 0);

            // 1. Calculate total
            $total = $this->orderRepository->calculateTotal($validated['items']);

            // 2. Create Order
            $order = $this->orderRepository->create([
                'user_id'      => $userId,
                'total_amount' => $total,
                'status'       => 'pending',
            ]);

            // 3. Create Order Items
            foreach ($validated['items'] as $item) {


                $this->orderRepository->createOrderItem($order, $item);
            }

            // 4. Clear Cart
            $this->orderRepository->clearCart($userId);

            // 5. Send Confirmation Email
            Mail::to($order->user->email)->queue(new OrderPlacedMail($order));

            return $order->load('items.product');
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
