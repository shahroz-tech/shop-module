<?php

namespace App\Services\PaymentService;

use App\Repositories\PaymentRepository;
use App\Models\Order;
use App\Models\Payment;
use Exception;

class PaymentService
{
    protected PaymentRepository $payments;

    public function __construct(PaymentRepository $payments)
    {
        $this->payments = $payments;
    }

    /**
     * Get the Stripe Payment Intent for an order.
     */
    public function getStripeIntent(Order $order): string
    {
        $payment = $this->payments->findByOrderId($order->id);

        if (!$payment || !$payment->stripe_payment_intent_id) {
            throw new Exception("No Stripe Payment Intent found for Order #{$order->id}");
        }

        return $payment->stripe_payment_intent_id;
    }

}
