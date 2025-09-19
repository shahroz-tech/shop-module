<?php
// app/Repositories/UserRepository.php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function find($id)
    {
        return User::with('profile')->findOrFail($id);
    }

//    public function getNewCustomersThisMonth()
//    {
//        return User::whereMonth('created_at', Carbon::now()->month)->count();
//    }
    public function getAll()
    {
        return User::latest()->paginate(10);
    }

    public function create(array $data): User
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'customer',
        ]);

        $user->profile()->create([
            'role' => $data['role'] ?? 'customer',
        ]);


        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

//    public function create(array $data): User
//    {
//        // Make sure password is hashed
//        $data['password'] = Hash::make($data['password']);
//
//        return User::create($data);
//    }
}
