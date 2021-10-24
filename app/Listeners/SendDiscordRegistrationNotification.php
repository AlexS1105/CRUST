<?php

namespace App\Listeners;

use App\Notifications\RegisteredNotification;
use Exception;

class SendDiscordRegistrationNotification
{
    public function handle($event)
    {
        try {
            $event->user->notify(new RegisteredNotification());
        } catch (Exception $e) {
            
        }
    }
}
