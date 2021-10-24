<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewApplicationNotification;
use Exception;

class SendDiscordNewApplicationNotification
{
    public function handle($event)
    {
        $registrars = User::whereHas('roles', function ($q) { 
            $q->where('name', 'like', 'registrar'); 
        })->get();

        $character = $event->character;

        foreach ($registrars as $registrar) {
            if ($registrar->can('takeForApproval', $character)) {
                try {
                    $registrar->notify(new NewApplicationNotification($character));
                } catch (Exception $e) {
        
                }
            }
        }
    }
}
