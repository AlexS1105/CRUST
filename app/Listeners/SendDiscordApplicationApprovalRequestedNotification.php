<?php

namespace App\Listeners;

use App\Notifications\ApplicationApprovalRequestedNotification;
use Exception;

class SendDiscordApplicationApprovalRequestedNotification
{
    public function handle($event)
    {
        try {
            $character = $event->character;
            
            $character->registrar->notify(new ApplicationApprovalRequestedNotification($character));
        } catch (Exception $e) {
            
        }
    }
}
