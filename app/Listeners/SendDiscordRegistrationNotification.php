<?php

namespace App\Listeners;

use App\Notifications\RegisteredNotification;

class SendDiscordRegistrationNotification
{
    public function handle($event)
    {
        $event->user->notify(new RegisteredNotification());
    }
}
