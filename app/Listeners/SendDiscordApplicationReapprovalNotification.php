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

            $notification = new ApplicationReapprovalNotification($character, $user);
            
            $character->user->notify($notification);

            if ($character->registrar->id != $user->id) {
                $character->registrar->notify($notification);
            }
        } catch (Exception $e) {
            
        }
    }
}
