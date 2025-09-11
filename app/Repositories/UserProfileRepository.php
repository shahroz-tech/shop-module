<?php
// app/Repositories/UserProfileRepository.php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserProfile;

class UserProfileRepository
{
    public function getByUser(User $user): UserProfile
    {
        return $user->profile()->firstOrCreate(['user_id' => $user->id]);
    }

    public function store(array $data){
        return UserProfile::create($data);
    }

    public function update(User $user, array $data): UserProfile
    {
        $user->update(['name' => $data['name']]); // update name in users table
        $profile = $this->getByUser($user);
        $profile->update([
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
        return $profile;
    }
}
