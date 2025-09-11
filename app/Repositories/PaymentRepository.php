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

    public function updateOrCreatePayment(array $conditions, array $data): Payment
    {
        return Payment::updateOrCreate($conditions, $data);
    }

}
