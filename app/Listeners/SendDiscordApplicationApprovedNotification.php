<?php

namespace App\Listeners;

use App\Notifications\ApplicationApprovedNotification;
use Exception;

class SendDiscordApplicationApprovedNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            
            $character->user->notify(new ApplicationApprovedNotification($character));

        } catch (Exception $e) {

        }
    }
}
