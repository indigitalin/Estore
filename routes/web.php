<?php

use Illuminate\Support\Facades\Route;
use App\Services\NotificationService;

Route::get('/', function(){
    
    if(auth()->user()->hasRole('super admin')){
        return redirect()->route('admin.index');
    }else if(auth()->user()->hasRole('client admin')){
        return redirect()->route('client.index');
    }
})->middleware("auth")->name('index');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/clientAdmin.php';


      

Route::get('/test-notification', function () {
    $userId = auth()->id(); // Ensure you're authenticated
    $subject = 'Test Notification';
    $description = 'This is a test notification.';
    $route = '/test-route';

    // Use the NotificationService to store and send the notification
    NotificationService::storeAndSend($userId, $subject, $description, $route);

    return 'Notification sent!';
})->middleware('auth');