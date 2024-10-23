<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('auth')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('index');
    Route::get('/profile', \App\Livewire\Admin\Profile::class)->name('profile');
    Route::get('/password', \App\Livewire\Admin\Password::class)->name('password');

    Route::group(['prefix'=>'users', 'as' => 'users.','namespace' => '\App\Livewire\Admin\Users'], function(){
        Route::get('/', Index::class)->name('index');
        Route::get('/create', Form::class)->name('create');
        Route::get('/{user}', Show::class)->name('show');
        Route::get('/{user}/edit', Form::class)->name('edit');
    })->middleware('wirenavigate');


    // Route::get('/clients', \App\Livewire\Admin\Clients::class)->name('clients.index');
    // Route::get('products', \App\Livewire\Admin\Products\ProductList::class)->name('products');

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

    // Route::get('/roles', \App\Livewire\Admin\Roles\Role::class)->name('roles.index');
});
