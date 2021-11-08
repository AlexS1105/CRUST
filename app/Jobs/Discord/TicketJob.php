<?php

namespace App\Jobs\Discord;

use App\Jobs\CharacterJob;
use App\Models\Character;
use App\Services\DiscordService;

class TicketJob extends CharacterJob
{
    public $tries = 3;
    public $backoff = 5;

    public function __construct(Character $character)
    {
        parent::__construct($character);
        $this->onQueue('tickets');
    }
}
