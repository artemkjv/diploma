<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class ClientRequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user) {
        return $user->role === Role::ADMIN->value;
    }

}
