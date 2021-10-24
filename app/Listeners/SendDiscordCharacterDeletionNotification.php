<?php

namespace App\Listeners;

use App\Notifications\CharacterDeletionNotification;

class SendDiscordCharacterDeletionNotification
{
    public function handle($event)
    {
        $character = $event->character;
        $character->user->notify(new CharacterDeletionNotification($character));
    }
}
