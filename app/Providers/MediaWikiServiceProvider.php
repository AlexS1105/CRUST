<?php

namespace App\Providers;

use App\Services\MediaWikiService;
use Illuminate\Support\ServiceProvider;

class MediaWikiServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(MediaWikiService::class, function($app) {
            return new MediaWikiService();
        });
    }
}
