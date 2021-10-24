<?php

namespace App\Listeners;

use App\Notifications\ApplicationTakenNotification;
use Exception;

class SendDiscordApplicationTakenNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            $character->user->notify(new ApplicationTakenNotification($character));
        } catch (Exception $e) {
            
        }
    }
}
