<?php

namespace App\Http\Controllers\OrderController;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest\PlaceOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Payment;
use App\Services\OrderService\OrderService;
use App\Services\StripeService\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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

//    public function webhook(Request $request)
//    {
//        $this->orderService->handlePaymentWebhook($request->all());
//
//        return response()->json(['status' => 'success']);
//    }

    public function pay($id)
    {
        $session = $this->stripeService->stripeCheckout($id);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('orders.index')
                ->with('error', '❌ Payment session not found.');
        }

        // Fetch session from Stripe
        $session = Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            // Find order by metadata
            $order = $this->orderService->findOrderById($session->metadata->order_id ?? null);

            if ($order) {
                $order->update(['status' => 'paid']);

                // optional: update payment table
                Payment::updateOrCreate(
                    ['stripe_payment_intent_id' => $session->payment_intent],
                    [
                        'order_id' => $order->id,
                        'status'   => 'succeeded',
                    ]
                );
            }

            return redirect()->route('orders.index')
                ->with('success', '✅ Payment successful!');
        }

        return redirect()->route('orders.index')
            ->with('error', '❌ Payment could not be verified.');
    }

    public function failed()
    {
        return redirect()->route('orders.index')
            ->with('error', '❌ Payment failed or cancelled.');
    }
}
