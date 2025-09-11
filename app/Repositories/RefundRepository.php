<?php

namespace App\Repositories;

use App\Models\RefundRequest;

class RefundRepository
{
    public function create(array $data)
    {
        return RefundRequest::create($data);
    }

    public function all()
    {
        return RefundRequest::with('order')->get();
    }

    public function updateStatus(RefundRequest $refund, string $status)
    {
        $refund->update(['status' => $status]);
        return $refund;
    }
}
