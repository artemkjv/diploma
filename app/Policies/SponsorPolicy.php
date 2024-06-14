<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class SponsorPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user) {
        return $user->role === Role::ADMIN->value;
    }

    public function edit(User $user) {
        return $user->role === Role::ADMIN->value;
    }

    public function destroy(User $user) {
        return $user->role === Role::ADMIN->value;
    }

}
