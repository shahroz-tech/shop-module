<?php

namespace App\Http\Controllers\ReportController;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index()
    {
        $data = $this->reportService->getReportData();

        return view('manager.reports.index', $data);
    }
}
