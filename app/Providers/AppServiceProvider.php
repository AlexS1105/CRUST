<?php

namespace App\Providers;

use App\Services\DiscordService;
use App\Services\MediaWikiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        DiscordService::class => DiscordServiceProvider::class,
        MediaWikiService::class => MediaWikiServiceProvider::class
    ];
}
