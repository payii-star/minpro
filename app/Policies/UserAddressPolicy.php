<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserAddress;

class UserAddressPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserAddress $address): bool
    {
        return $user->id === $address->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // semua user terautentikasi boleh membuat alamat
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserAddress $address): bool
    {
        return $user->id === $address->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserAddress $address): bool
    {
        return $user->id === $address->user_id;
    }

    // jika controller pakai authorize('manage', $address), tambahkan alias manage:
    public function manage(User $user, UserAddress $address): bool
    {
        return $user->id === $address->user_id;
    }
}
