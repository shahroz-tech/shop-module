<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;

class UserRepository
{
    public function all()
    {
        return User::with('profile')->get();
    }

    public function find($id)
    {
        return User::with('profile')->findOrFail($id);
    }


}
