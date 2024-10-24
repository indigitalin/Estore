<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware(['auth', 'role:super admin|super admin user'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('index');
    Route::get('/profile', \App\Livewire\Admin\Profile::class)->name('profile');
    Route::get('/password', \App\Livewire\Admin\Password::class)->name('password');

    Route::group(['prefix'=>'logs', 'as' => 'logs.','namespace' => '\App\Livewire\Admin\Logs'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/{log}', Show::class)->name('show');
    });

    Route::group(['prefix'=>'users', 'as' => 'users.','namespace' => '\App\Livewire\Admin\Users'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{user}', Show::class)->name('show');
        Route::get('/{user}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');

    Route::group(['prefix'=>'subscriptions', 'as' => 'subscriptions.','namespace' => '\App\Livewire\Admin\Subscriptions'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{plan}', Show::class)->name('show');
        Route::get('/{plan}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');

    Route::group(['prefix'=>'roles', 'as' => 'roles.','namespace' => '\App\Livewire\Admin\Roles'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{role}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');

    Route::group(['prefix'=>'clients', 'as' => 'clients.','namespace' => '\App\Livewire\Admin\Clients'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{client}', Show::class)->name('show');
        Route::get('/{client}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');

});
