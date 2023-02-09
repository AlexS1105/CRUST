<?php

namespace App\Jobs;

use App\Models\Character;
use App\Services\EstitenceService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReduceEstitence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function handle(EstitenceService $estitenceService)
    {
        Character::affectedByEstitenceReduce()->get()->each(function ($character) use ($estitenceService) {
            $estitenceService->changeEstitence($character, -$this->amount, __('estitence.reduce_log'));
        });
    }
}
