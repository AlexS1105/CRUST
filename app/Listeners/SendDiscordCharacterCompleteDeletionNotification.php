<?php

namespace App\Listeners;

use App\Notifications\CharacterCompleteDeletionNotification;
use Exception;

class SendDiscordCharacterCompleteDeletionNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            $character->user->notify(new CharacterCompleteDeletionNotification($character));
        } catch (Exception $e) {
            
        }
    }
}
