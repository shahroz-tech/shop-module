<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class ReportService
{
    protected OrderRepository $orderRepository;
    protected OrderItemRepository $orderItemRepository;
    protected UserRepository $userRepository;

    public function __construct(
        OrderRepository $orderRepository,
        OrderItemRepository $orderItemRepository,
        UserRepository $userRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->userRepository = $userRepository;
    }

    public function getReportData(): array
    {
        $sales = $this->orderRepository->getSalesSummary();
        $topProducts = $this->orderItemRepository->getTopProducts();
//        $newCustomers = $this->userRepository->getNewCustomersThisMonth();
//        $totalUniqueCustomers = $this->orderRepository->getUniqueCustomerCountThisMonth();
//        $returningCustomers = ( $newCustomers - $totalUniqueCustomers );
//        Log::info('newCustomer'.$newCustomers);
//        Log::info('unique'.$totalUniqueCustomers);

        return compact('sales', 'topProducts'
//            , 'newCustomers', 'returningCustomers'
        );
    }

}
