<?php

namespace App\Http\Controllers\AuthController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function register(RegisterRequest $request)
    {
        $data = $this->authService->register($request->validated());

        $request->session()->regenerate(); // security best practice

        return redirect('/products');

    }

    public function login(LoginRequest $request)
    {
        $data = $this->authService->login($request->validated());

        $request->session()->regenerate(); // prevent session fixation

        return redirect('/products');

    }

    public function logout(Request $request)
    {
//        dd(Auth::user());
        $this->authService->logout($request->user());

        return redirect()->route('login');
    }
}
