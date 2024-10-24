<?php

use Illuminate\Support\Facades\Route;

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
