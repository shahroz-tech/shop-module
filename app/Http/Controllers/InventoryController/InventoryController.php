<?php

namespace App\Http\Controllers\InventoryController;

use App\Http\Controllers\Controller;
use App\Services\InventoryService;

class InventoryController extends Controller
{
    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $data = $this->inventoryService->getInventoryData();

        return view('manager.inventory.index', $data);
    }
}
