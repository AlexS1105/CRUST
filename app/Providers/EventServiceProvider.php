<?php

namespace App\Providers;

use App\Listeners\DiscordEventSubscriber;
use App\Models\Character;
use App\Observers\CharacterObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        DiscordEventSubscriber::class,
    ];

    protected $observers = [
        Character::class => [CharacterObserver::class],
    ];

    public function boot()
    {
    }

    public function shouldDiscoverEvents()
    {
        return true;
    }
}
