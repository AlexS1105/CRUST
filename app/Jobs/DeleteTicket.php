<?php

namespace App\Jobs;

use App\Models\Character;
use App\Services\DiscordService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function handle(DiscordService $disordService)
    {
        $disordService->deleteRegistrationTicket($this->character);
    }
}
