<?php

namespace App\Http\Controllers\Manager\OrderController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\StripeService;

class OrderController extends Controller
{
    public function __construct(protected StripeService $stripeService,protected OrderService $orderService){}

    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('manager.orders.index', compact('orders'));
    }


    public function approve(Order $order)
    {
        if ($order->status !== 'paid') {
            return back()->with('error', 'Only paid orders can be approved.');
        }

        $this->orderService->updateStatusApproved($order);
        return back()->with('success', "Order #{$order->id} approved.");
    }

    public function reject(Order $order)
    {
        if (!in_array($order->status, ['pending', 'paid'])) {
            return back()->with('error', 'Only pending/paid orders can be rejected.');
        }
        $this->orderService->updateStatusRejected($order);


        return back()->with('success', "Order #{$order->id} rejected.");
    }

}
