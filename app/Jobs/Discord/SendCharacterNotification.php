<?php

namespace App\Jobs\Discord;

use App\Jobs\CharacterJob;
use App\Models\Character;
use Illuminate\Notifications\Notification;

class SendCharacterNotification extends CharacterJob
{
    public $notification;

    public function __construct(Character $character, Notification $notification)
    {
        parent::__construct($character);
        $this->notification = $notification;
    }

    public function handle()
    {
        $this->character->user->notify($this->notification);
    }
}
