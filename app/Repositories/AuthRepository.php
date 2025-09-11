<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;

class AuthRepository
{
    public function createUser(array $data): User
    {

        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function deleteUserTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}
