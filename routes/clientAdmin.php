<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware([
    'auth',
    'role:client admin|client admin user',
    'not-role:super admin|super admin user'
])->prefix('/client')->name('client.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('index');
    Route::get('/profile', \App\Livewire\Admin\Profile::class)->name('profile');
    Route::get('/password', \App\Livewire\Admin\Password::class)->name('password');

    Route::get('/settings', \App\Livewire\Client\Settings\Settings::class)->name('settings');

    Route::group(['prefix'=>'categories', 'as' => 'categories.','namespace' => '\App\Livewire\Client\Categories'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{category}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');
});
