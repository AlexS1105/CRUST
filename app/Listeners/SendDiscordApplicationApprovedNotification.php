<?php

namespace App\Listeners;

use App\Notifications\ApplicationApprovedNotification;

class SendDiscordApplicationApprovedNotification
{
    public function handle($event)
    {
        $character = $event->character;
        
        $character->user->notify(new ApplicationApprovedNotification($character));
    }
}
