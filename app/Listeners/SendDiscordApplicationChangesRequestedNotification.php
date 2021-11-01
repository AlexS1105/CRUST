<?php

namespace App\Listeners;

use App\Notifications\ApplicationChangesRequestedNotification;
use Exception;

class SendDiscordApplicationChangesRequestedNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            
            $character->user->notify(new ApplicationChangesRequestedNotification($character));
        } catch (Exception $e) {
            
        }
    }
}
