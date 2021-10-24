<?php

namespace App\Listeners;

use App\Notifications\ApplicationReapprovalNotification;

class SendDiscordApplicationReapprovalNotification
{
    public function handle($event)
    {
        $user = $event->user;
        $character = $event->character;

        $notification = new ApplicationReapprovalNotification($character, $user);
        
        $character->user->notify($notification);
        $character->registrar->notify($notification);
    }
}
