<?php
// app/Services/AdminService.php
namespace App\Services\AdminService;

use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;

class AdminService
{
    public function __construct(
        protected UserRepository $userRepo,
        protected OrderRepository $orderRepo,
        protected PaymentRepository $paymentRepo
    ) {}

    public function getUsers()
    {
        return $this->userRepo->all();
    }

    public function getSalesOverview()
    {
        return [
            'total_orders' => $this->orderRepo->totalOrders(),
            'total_revenue' => $this->orderRepo->totalRevenue(),
            'sales_by_user' => $this->orderRepo->salesByUser(),
        ];
    }
}
