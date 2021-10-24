<?php

namespace App\Listeners;

use App\Events\CharacterSent;
use App\Notifications\ApplicationCanceledNotification;
use Exception;

class SendDiscordApplicationCanceledNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            
            $character->user->notify(new ApplicationCanceledNotification($character));

            event(new CharacterSent($character));
        } catch (Exception $e) {
            
        }
    }
}
