<?php

namespace App\Providers;

use App\Events\UserActivityLogged;
use App\Listeners\LogUserActivity;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserActivityLogged::class => [
            LogUserActivity::class,
        ],
    ];
}