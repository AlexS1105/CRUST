<?php

namespace App\Providers;

use App\Services\DiscordService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        DiscordService::class => DiscordServiceProvider::class,
    ];
}
