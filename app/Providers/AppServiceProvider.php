<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use URL;

class AppServiceProvider extends ServiceProvider
{
    use \App\Services\notification\Auth;
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        class_alias(\Masmerise\Toaster\Toaster::class, 'Toaster');

        // Override the email notification for verifying email
        VerifyEmail::toMailUsing(function ($notifiable){        
            $verifyUrl = URL::temporarySignedRoute('verification.verify',
            \Illuminate\Support\Carbon::now()->addMinutes(\Illuminate\Support\Facades\Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]);
            return $this->verifyEmail($notifiable, $verifyUrl);
        });

        /**
         * Share view constants
         */
        view()->share('app', json_decode(json_encode([
            'name' => env('APP_NAME'),
            'accent_color' => env('ACCENT_COLOR'),
        ])));
    }
}
