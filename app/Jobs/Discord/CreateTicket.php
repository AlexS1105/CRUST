<?php

namespace App\Jobs\Discord;

use App\Services\DiscordService;

class CreateTicket extends TicketJob
{
    public function handle(DiscordService $discordService)
    {
        $discordService->createRegistrationTicket($this->character);
    }
}
