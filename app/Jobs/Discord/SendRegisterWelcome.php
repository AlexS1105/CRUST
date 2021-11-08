<?php

namespace App\Jobs\Discord;

use App\Jobs\UserJob;
use App\Notifications\RegisteredNotification;

class SendRegisterWelcome extends UserJob
{
    public function handle()
    {
        $this->user->notify(new RegisteredNotification());
    }
}
