<?php

namespace App\Jobs\Discord;

use App\Jobs\UserJob;
use App\Services\DiscordService;

class VerifyUser extends UserJob
{
    public function handle(DiscordService $discordService)
    {
        $discordService->verifyUser($this->user);
    }
}
