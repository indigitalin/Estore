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

    Route::group(['prefix'=>'roles', 'as' => 'roles.','namespace' => '\App\Livewire\Admin\Roles'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{role}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');

    Route::group(['prefix'=>'users', 'as' => 'users.','namespace' => '\App\Livewire\Admin\Users'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{user}', Show::class)->name('show');
        Route::get('/{user}/edit', Form::class)->name('edit');
        
    })->middleware('wirenavigate');

    Route::group(['prefix'=>'stores', 'as' => 'stores.','namespace' => '\App\Livewire\Client\Stores'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{store}', Show::class)->name('show');
        Route::get('/{store}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');

    Route::group(['prefix'=>'websites', 'as' => 'websites.','namespace' => '\App\Livewire\Client\Websites'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{website}/edit', Form::class)->name('edit');

        Route::get('/{website}', Settings\Menus\Index::class)->name('settings.index');
        Route::get('/{website}/menus', Settings\Menus\Index::class)->name('settings.menus.index');
        Route::get('/{website}/menus/create', Settings\Menus\Form::class)->name('settings.menus.create');
        Route::get('/{website}/menus/{menu}/edit', Settings\Menus\Form::class)->name('settings.menus.edit');

        Route::get('/{website}/banners', Settings\Banners\Index::class)->name('settings.banners.index');
        Route::get('/{website}/banners/create', Settings\Banners\Form::class)->name('settings.banners.create');
        Route::get('/{website}/banners/{banner}/edit', Settings\Banners\Form::class)->name('settings.banners.edit');
        
    })->middleware('wirenavigate');
});
