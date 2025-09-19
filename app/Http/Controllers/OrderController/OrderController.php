<?php

namespace App\Http\Controllers\OrderController;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\StripeService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService, protected StripeService $stripeService) {}

    public function placeOrder(PlaceOrderRequest $request)
    {
        $this->orderService->placeOrder($request->validated(), auth()->id());

        return back()->with('success','Order placed successfully');
    }

    public function  index()
    {
        $orders = $this->orderService->getUserOrder(auth()->id());
        return view('order.index',['orders'=>OrderResource::collection($orders)]);
    }

    public function pay($id)
    {
        $session = $this->stripeService->stripeCheckout($id);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        return $this->stripeService->success($request);
    }

    public function failed()
    {
        return redirect()->route('orders.index')
            ->with('error', '❌ Payment failed or cancelled.');
    }

    public function getAllOrders()
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
