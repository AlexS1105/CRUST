<?php

namespace App\Providers;

use App\Services\DiscordService;
use Illuminate\Support\ServiceProvider;

class DiscordServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Services\Discord', function($app) {
            return new DiscordService();
        });
    }
}
