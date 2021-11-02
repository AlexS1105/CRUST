<?php

namespace App\Listeners;

use App\Notifications\ApplicationReapprovalNotification;
use Exception;

class SendDiscordApplicationReapprovalNotification
{
    public function handle($event)
    {
        try {
            $user = $event->user;
            $character = $event->character;

            if (!$user->is($character->user)) {
                $character->user->notify(new ApplicationReapprovalNotification($character, $user));
            }

            if ($character->registrar->id != $user->id) {
                $character->registrar->notify(new ApplicationReapprovalNotification($character, $user, true));
            }
        } catch (Exception $e) {
            
        }
    }
}
