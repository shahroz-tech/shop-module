<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use App\Repositories\UserProfileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected AuthRepository $authRepository;
    protected UserProfileRepository $profileRepository;

    public function __construct(AuthRepository $authRepository, UserProfileRepository $profileRepository)
    {
        $this->authRepository = $authRepository;
        $this->profileRepository = $profileRepository;
    }

    public function register(array $data): array
    {
        $user = $this->authRepository->createUser([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        // log in the new user (session based)
        Auth::login($user);

        //creating profile
        $this->profileRepository->store([
            'user_id'=>Auth::id(),
            'role' => 'customer',
            'phone' => '',
            'address' => '',
        ]);

        return [
            'user' => $user,
        ];
    }

    public function login(array $data): array
    {
        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials provided.'],
            ]);
        }

        $user = Auth::user();

        return [
            'user' => $user,
        ];
    }


    public function logout($user): void
    {
        Auth::logout(); // log user out of session
    }
}
