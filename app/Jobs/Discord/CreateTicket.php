<?php

namespace App\Jobs\Discord;

use App\Services\DiscordService;

class CreateTicket extends TicketJob
{
    public function handle(DiscordService $discordService)
    {
        if (! isset($this->character->ticket)) {
            $discordService->createRegistrationTicket($this->character);
        } else {
            $discordService->deleteRegistrationTicket($this->character);
        }
    }
}
