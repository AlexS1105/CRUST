<?php

namespace App\Policies;

use App\Enums\CharacterStatus;
use App\Models\Character;
use App\Models\Rumor;
use App\Models\User;

class RumorPolicy
{
    public function seeIndex(User $user)
    {
        return $user->hasPermissionTo('rumors-see');
    }

    public function seeUser(User $user, Rumor $rumor)
    {
        return $user->is($rumor->user) || $user->hasPermissionTo('rumors-see');
    }

    public function create(User $user, Character $character)
    {
        return (! $user->owns($character)
                && $character->status == CharacterStatus::Approved
                && $user->can_rumor
                && $character->rumors()
                    ->where('user_id', $user->id)
                    ->where('created_at', '>', now()->subWeek())
                    ->count() == 0)
            || $user->hasPermissionTo('rumors-manage');
    }

    public function manage(User $user, Rumor $rumor)
    {
        return $user->is($rumor->user) || $user->hasPermissionTo('rumors-manage');
    }
}
