<?php
// app/Http/Controllers/Admin/AdminController.php
namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest\AssignRoleRequest;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserRepository;
use App\Services\AdminService;
use App\Services\ReportService;

class AdminController extends Controller
{
    public function __construct(protected AdminService $adminService, protected UserRepository $userRepository,protected UserProfileRepository $userProfileRepository, protected ReportService  $reportService) {}

    public function index()
    {
        $reportData = $this->reportService->getReportData();

        return view('admin.dashboard', compact('reportData'));
    }

    public function users()
    {
        $users = $this->adminService->getUsers();
        $roles = ['customer', 'manager'];
        return view('admin.users', compact('users','roles'));
    }

    public function assignRole(AssignRoleRequest $request, $id)
    {
        $user = $this->userRepository->find($id);

        // Only update the role in user_profiles
        $this->userProfileRepository->updateRole($user, $request->role);

        return redirect()->back()->with('success', 'Role updated successfully.');
    }
}

