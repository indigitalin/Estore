<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Register the routes needed for broadcasting
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel.
         * The private channel here is defined to allow notifications
         * to be broadcasted only to the authenticated user.
         */
        Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
            return (int) $user->id === (int) $id;
        });

        // Load custom channel files if you have additional channels
        require base_path('routes/channels.php');
    }
}
