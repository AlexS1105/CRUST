<?php

namespace App\Providers;

use App\Enums\CharacterStat;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Collection::macro('sortByStat', function () {
            return static::sortBy(fn ($skill) => CharacterStat::from($skill->stat->value)->order());
        });
    }
}
