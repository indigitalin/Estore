<?php

namespace App\Listeners;

use App\Events\UserActivityLogged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ActivityLog;

class LogUserActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    

    /**
     * Handle the event.
     */
    public function handle(UserActivityLogged $event): void
    {
        //
   
        ActivityLog::FirstorCreate([
            'user_id' => $event->userId,
            'action' => $event->action,
            'description' => $event->description,
        ]);
    
    }
}
