<?php

namespace App\Listeners;

use App\Jobs\CreateTicket;

class CreateRegistrationTicket
{
    public function handle($event)
    {
        CreateTicket::dispatchAfterResponse($event->character);
    }
}
