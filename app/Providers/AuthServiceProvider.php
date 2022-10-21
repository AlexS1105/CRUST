<?php

namespace App\Providers;

use App\Models\Passport\Client;
use App\Policies\GeneralPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }

        Passport::useClientModel(Client::class);
        Passport::tokensExpireIn(now()->addMonth());

        Gate::define('settings', [GeneralPolicy::class, 'settings']);
        Gate::define('logs', [GeneralPolicy::class, 'logs']);
    }
}
