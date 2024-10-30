<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use ZipArchive;
use Illuminate\Support\Facades\Log;
use View;

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

        $this->loadGoogleStorageDriver();
    }

    private function loadGoogleStorageDriver(string $driverName = 'google')
    {
        try {
            // Extend storage with Google Drive
            Storage::extend('google', function ($app, $config) {
                $options = [];
    
                if (!empty($config['teamDriveId'] ?? null)) {
                    $options['teamDriveId'] = $config['teamDriveId'];
                }
    
                if (!empty($config['sharedFolderId'] ?? null)) {
                    $options['sharedFolderId'] = $config['sharedFolderId'];
                }
    
                $client = new \Google\Client();
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);
    
                $service = new \Google\Service\Drive($client);
                $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
                $driver = new \League\Flysystem\Filesystem($adapter);
    
                return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
            });
    
           
        } catch (\Exception $e) {
            Log::error('Failed to load Google Storage Driver: ' . $e->getMessage());
        }
    }
}
