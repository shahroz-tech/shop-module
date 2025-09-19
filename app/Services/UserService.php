<?php
// app/Services/UserService.php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    public function getUsers()
    {
        return $this->userRepository->getAll();
    }

    public function createUser(array $data): User
    {

        return $this->userRepository->create($data);
    }

    public function deleteUser(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
