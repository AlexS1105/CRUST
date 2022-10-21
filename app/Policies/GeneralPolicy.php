<?php

namespace App\Policies;

use App\Models\User;

class GeneralPolicy
{
    public function logs(User $user)
    {
        return $user->hasPermissionTo('logs');
    }

    public function settings(User $user)
    {
        return $user->hasPermissionTo('settings');
    }
}
