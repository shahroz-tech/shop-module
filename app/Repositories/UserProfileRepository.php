<?php
// app/Repositories/UserProfileRepository.php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Log;

class UserProfileRepository
{
    public function getByUser(User $user)
    {
        return UserProfile::where('user_id',$user->id)->first();
    }

    public function store(array $data){
        return UserProfile::create($data);
    }

    public function update(User $user, array $data): UserProfile
    {
        $user->update(['name' => $data['name']]); // update name in users table
        $profile = $this->getByUser($user);
        $profile->update([
            'phone' => $data['phone'] ?? $profile->phone??null,
            'address' => $data['address'] ?? $profile->address ??null,
        ]);
        return $profile;
    }

    public function updateRole(User $user, string $role)
    {
        $profile = $this->getByUser($user);
        Log::info($profile.$role);
        $profile->update(['role' => $role]);
        Log::info($profile.$role);

        return $profile;
    }
}
