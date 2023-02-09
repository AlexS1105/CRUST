<?php

namespace App\Listeners;

use App\Events\UserAuthorizedInLauncher;
use App\Models\Character;

class UpdateCharacterLastOnline
{
    public function handle(UserAuthorizedInLauncher $event)
    {
        Character::where('login', $event->login)->update(['last_online_at' => now()]);
    }
}
