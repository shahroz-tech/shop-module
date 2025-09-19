<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
        $this->middleware('auth');
        $this->authorizeResource(User::class);
    }

    // List users
    public function index()
    {
        $users = $this->userService->getUsers();
        $roles = ['customer', 'manager'];

        return view('admin.users', compact('users', 'roles'));
    }

    // Show create form
    public function create()
    {
        $this->authorize('create', User::class);

        return view('admin.create');
    }


    // Store a new user
    public function store(RegisterRequest $request)
    {
//        Log::info('user'.$request->validated());
        $this->userService->createUser($request->validated());

        return back()
            ->with('success', 'User created successfully!');
    }

    // Delete user
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $this->userService->deleteUser($user);

        return back()
            ->with('success', 'User deleted successfully!');
    }

}
