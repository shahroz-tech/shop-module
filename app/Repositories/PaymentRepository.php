<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    /**
     * Find a payment by order ID.
     */
    public function findByOrderId(int $orderId): ?Payment
    {
        return Payment::where('order_id', $orderId)->first();
    }

    /**
     * Find a payment by Stripe Payment Intent ID.
     */
    public function findByStripeIntent(string $intentId): ?Payment
    {
        return Payment::where('stripe_payment_intent_id', $intentId)->first();
    }

    /**
     * Update payment status.
     */
    public function updateStatus(Payment $payment, string $status): Payment
    {
        $payment->update(['status' => $status]);
        return $payment;
    }
}
