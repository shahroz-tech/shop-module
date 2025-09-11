<?php

namespace App\Http\Controllers\RefundRequestController;

use App\Http\Controllers\Controller;
use App\Http\Requests\RefundRequest\StoreRefundRequest;
use App\Services\RefundService\RefundService;
use Illuminate\Http\Request;

class RefundRequestController extends Controller
{
    protected $refundService;

    public function __construct(RefundService $refundService)
    {
        $this->refundService = $refundService;
    }

    public function index()
    {
        $refunds = $this->refundService->getAllRefundRequest();
        return view('manager.refunds.index', compact('refunds'));
    }

    public function store(StoreRefundRequest $request)
    {
        $this->refundService->requestRefund($request->validated());
        return back()->with('success','Request refunded successfully');
    }

    public function approve($id)
    {
        $this->refundService->handleRefund($id);

        return back()->with('success','Request Approved successfully');
    }
}
