<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create products.
     */
    public function create(User $user): bool
    {

        return $user->profile->role === 'manager'|| $user->profile->role === 'admin';
    }

    /**
     * Determine whether the user can update the product.
     */
    public function update(User $user): bool
    {
        return $user->profile->role === 'manager'||$user->profile->role === 'admin';
    }

    /**
     * Determine whether the user can update the product.
     */
    public function edit(User $user): bool
    {
        return $user->profile->role === 'manager'||$user->profile->role === 'admin';
    }

    /**
     * Determine whether the user can delete the product.
     */
    public function delete(User $user): bool
    {
        return $user->profile->role === 'manager'||$user->profile->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Product $product): bool
    {
        return false;
    }
}
