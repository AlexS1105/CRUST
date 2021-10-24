<?php

namespace App\Listeners;

use App\Notifications\ApplicationTakenNotification;

class SendDiscordApplicationTakenNotification
{
    public function handle($event)
    {
        $character = $event->character;
        $character->user->notify(new ApplicationTakenNotification($character));
    }
}
