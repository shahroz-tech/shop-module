<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;

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

    public function getNewCustomersThisMonth()
    {
        return User::whereMonth('created_at', Carbon::now()->month)->count();
    }

}
