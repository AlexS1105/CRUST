<?php

namespace App\Providers;

use App\Listeners\DiscordEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        DiscordEventSubscriber::class,
    ];

    public function boot()
    {
    }
}
