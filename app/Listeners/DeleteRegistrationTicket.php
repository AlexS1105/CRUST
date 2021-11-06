<?php

namespace App\Listeners;

use App\Jobs\DeleteTicket;

class DeleteRegistrationTicket
{
    public function handle($event)
    {
        DeleteTicket::dispatchAfterResponse($event->character);
    }
}
