<?php

namespace App\Listeners;

use App\Notifications\CharacterCompleteDeletionNotification;

class SendDiscordCharacterCompleteDeletionNotification
{
    public function handle($event)
    {
        $character = $event->character;
        $character->user->notify(new CharacterCompleteDeletionNotification($character));
    }
}
