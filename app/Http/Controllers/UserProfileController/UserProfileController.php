<?php

namespace App\Http\Controllers\UserProfileController;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileRequest\UpdateUserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Services\UserProfileService;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function __construct(protected UserProfileService $service) {}

    public function show()
    {
        $user = Auth::user();
        $profile = $this->service->show($user);
        $profile->load('user');
        return view('profile.show', [
            'profile' => new UserProfileResource($profile)
        ]);
    }


    public function update(UpdateUserProfileRequest $request)
    {
        $profile = $this->service->update(Auth::user(), $request->validated());
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
}
