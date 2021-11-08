<?php

namespace App\Jobs\Discord;

use App\Services\DiscordService;

class DeleteTicket extends TicketJob
{
    public function handle(DiscordService $disordService)
    {
        $disordService->deleteRegistrationTicket($this->character);
    }
}
