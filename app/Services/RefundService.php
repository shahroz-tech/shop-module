<?php

namespace App\Services;

use App\Models\RefundRequest;
use App\Repositories\PaymentRepository;
use App\Repositories\RefundRepository;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class RefundService
{
    protected $refundRepository;
    protected $paymentRepository;
    protected $orderService;
    protected $stripe;

    public function __construct(RefundRepository $refundRepository, OrderService $orderService,PaymentRepository $paymentRepository, StripeClient $stripe)
    {
        $this->refundRepository = $refundRepository;
        $this->orderService = $orderService;
        $this->paymentRepository = $paymentRepository;
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function getAllRefundRequest()
    {
        return RefundRequest::all();
    }

    public function requestRefund(array $data)
    {
        return $this->refundRepository->create($data);
    }

    public function handleRefund($refundId)
    {
        $refund = $this->refundRepository->all()->find($refundId);

        if (!$refund) {
            throw new \Exception("Refund request not found.");
        }

        $payment = $this->paymentRepository->findByOrderId($refund->order_id);

        if (!$payment || !$payment->stripe_payment_intent_id) {
            throw new \Exception("No valid payment found for this order.");
        }

        try {
            // Stripe refund logic
            $this->stripe->refunds->create([
                'payment_intent' => $payment->stripe_payment_intent_id,
            ]);

            // Update order + refund status
            $this->orderService->markRefunded($payment->order_id);
            return $this->refundRepository->updateStatus($refund, 'approved');

        } catch (\Exception $e) {
            // log and rethrow
            Log::error("Refund failed: ".$e->getMessage());
            throw $e;
        }
    }
}
