<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\StripeService\StripeService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected StripeService $stripeService){}

    public function index()
    {
        $orders = Order::with('items.product','user')->latest()->paginate(10);
        return view('manager.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user');
        return view('manager.orders.show', compact('order'));
    }

    public function approve(Order $order)
    {
        if ($order->status !== 'paid') {
            return back()->with('error', 'Only paid orders can be approved.');
        }

        $order->update(['status' => 'approved']);
        return back()->with('success', "Order #{$order->id} approved.");
    }

    public function reject(Order $order)
    {
        if (!in_array($order->status, ['pending', 'paid'])) {
            return back()->with('error', 'Only pending/paid orders can be rejected.');
        }

        $order->update(['status' => 'rejected']);
        return back()->with('success', "Order #{$order->id} rejected.");
    }

}
