<?php

namespace App\Http\Controllers\PaymentController;

use App\Http\Controllers\Controller;
use App\Services\PaymentService\PaymentService;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService){}



}
