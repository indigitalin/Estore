<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::if('superAdmin', function () {
            return hasRole('super admin');
        });

        Blade::if('clientAdmin', function () {
            return hasRole('client admin');
        });
    }
}
