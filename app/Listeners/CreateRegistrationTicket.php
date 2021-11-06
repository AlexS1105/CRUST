<?php

namespace App\Listeners;

use App\Services\DiscordService;

class CreateRegistrationTicket
{

    private DiscordService $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function handle($event)
    {
        $this->discordService->createRegistrationTicket($event->character);
    }
}
