<?php

namespace App\Services\StripeService;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Services\PaymentService\PaymentService;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeService
{
    protected StripeClient $stripe;

    public function __construct(protected OrderRepository $orderRepository,protected PaymentService $paymentService)
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }


    public function stripeCheckout($id){

        $order = $this->orderRepository->findOrderById($id);

        if ($order->status === 'paid') {
            return redirect()->route('orders.show')->with('success', 'Order already paid!');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [[
            'price_data' => [
                'currency'     => 'pkr', // or your supported currency
                'product_data' => [
                    'name' => 'Order #' . $order->id,
                ],
                'unit_amount'  => (int) ($order->total_amount * 100), // amount in cents
            ],
            'quantity' => 1,
        ]];

// Create Checkout Session
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',

            'success_url'          => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('payment.failed'),
            'metadata'    => [
                'order_id' => $order->id,
            ],
        ]);
    }
}
