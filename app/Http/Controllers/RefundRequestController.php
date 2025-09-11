<?php

namespace App\Http\Controllers;

use App\Models\RefundRequest;
use App\Services\RefundService\RefundService;
use Illuminate\Http\Request;

class RefundRequestController extends Controller
{
    protected $refunds;

    public function __construct(RefundService $refunds)
    {
        $this->refunds = $refunds;
    }

    public function index()
    {
        $refunds = $this->refunds->getAllRefundRequest();
        return view('manager.refunds.index', compact('refunds'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
        ]);
        $this->refunds->requestRefund($data);
        return back()->with('success','Request refunded successfully');
    }

    public function approve($id)
    {
        $this->refunds->handleRefund($id);

        return back()->with('success','Request Approved successfully');
    }
}
