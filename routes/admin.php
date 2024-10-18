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



    // Route::get('/products', \App\Livewire\Admin\Product::class)->name('products.index');
    // Route::get('/users', \App\Livewire\Admin\Users\UserIndex::class)->name('users.index');
    // Route::get('/users/create', \App\Livewire\Admin\Users\UserIndex::class)->name('users.create');
    Route::get('/clients', \App\Livewire\Admin\Clients::class)->name('clients.index');
    Route::get('products', \App\Livewire\Admin\Products\ProductList::class)->name('products');

    Route::get('/roles', \App\Livewire\Admin\Roles\Role::class)->name('roles.index');
});
