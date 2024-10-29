<?php
namespace App\Services;

use App\Models\Notification;
use App\Notifications\UserActivityNotification;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use App\Models\User;

class NotificationService
{
    public static function storeAndSend($userId, $subject, $description, $route)
    {
        // Store notification in the database
        $notification = Notification::FirstorCreate([
            'user_id' => $userId, // Make sure to include this line
            'subject' => $subject,
            'description' => $description,
            'route' => $route,
            'push_time' => now(),
            'notifiable_id' => $userId,
            'notifiable_type' => User::class,
            'type' => UserActivityNotification::class, // Add this line if you have the type column
            'data' => json_encode(['message' => $description]), // Add this line for JSON data
        ]);

        // Check if Pusher is enabled in .env
        if (env('PUSHER_ENABLED', false)) {
            // Send real-time notification via Pusher
            $user = User::find($userId);
          
            if ($user) {
                NotificationFacade::send($user, new UserActivityNotification($description));
            }
            // Optionally update delivered_time if needed
            $notification->update(['delivered_time' => now()]);
        }
    }
}
