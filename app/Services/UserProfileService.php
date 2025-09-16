<?php
// app/Services/UserProfileService.php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserProfileRepository;

class UserProfileService
{
    public function __construct(protected UserProfileRepository $repo) {}

    public function show(User $user)
    {
        return $this->repo->getByUser($user);
    }

    public function update(User $user, array $data)
    {
        return $this->repo->update($user, $data);
    }
}
