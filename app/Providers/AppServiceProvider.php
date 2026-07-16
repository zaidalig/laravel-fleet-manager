<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('manage-users', fn ($user) => $user->canManageUsers());
        Gate::define('manage-fleet', fn ($user) => $user->canManageFleet());
        Gate::define('log-trips', fn ($user) => $user->canLogTrips());
    }
}
