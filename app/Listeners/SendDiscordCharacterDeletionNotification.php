<?php

namespace App\Listeners;

use App\Notifications\CharacterDeletionNotification;
use Exception;

class SendDiscordCharacterDeletionNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            $character->user->notify(new CharacterDeletionNotification($character));
        } catch (Exception $e) {
            
        }
    }
}
