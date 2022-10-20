<?php

namespace App\Jobs\Discord;

use App\Jobs\CharacterJob;
use App\Models\Character;

class TicketJob extends CharacterJob
{
    public $tries = 3;
    public $backoff = 5;
}
