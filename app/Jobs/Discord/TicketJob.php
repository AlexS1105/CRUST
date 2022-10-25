<?php

namespace App\Jobs\Discord;

use App\Jobs\CharacterJob;

class TicketJob extends CharacterJob
{
    public $tries = 3;
    public $backoff = 5;
}
