<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeService
{
    protected StripeClient $stripe;

    public function __construct(
        protected OrderRepository $orderRepository,
        protected PaymentRepository $paymentRepository,
        protected PaymentService $paymentService
    ) {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function stripeCheckout($id)
    {
        $order = $this->orderRepository->findOrderById($id);

        if ($order->status === 'paid') {
            return redirect()->route('orders.show')->with('success', 'Order already paid!');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [[
            'price_data' => [
                'currency'     => 'pkr',
                'product_data' => [
                    'name' => 'Order #' . $order->id,
                ],
                'unit_amount'  => (int) ($order->total_amount * 100),
            ],
            'quantity' => 1,
        ]];

        return Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('payment.failed'),
            'metadata'             => [
                'order_id' => $order->id,
            ],
        ]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('orders.index')
                ->with('error', '❌ Payment session not found.');
        }

        $session = Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            $order = $this->orderRepository->findOrderById($session->metadata->order_id ?? null);

            if ($order) {
                $this->orderRepository->updateStatus($order, 'paid');

                $this->paymentRepository->updateOrCreatePayment(
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
}
