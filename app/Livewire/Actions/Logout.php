<?php

namespace App\Livewire\Actions;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        try{
            Auth::guard('web')->logout();
            Session::invalidate();
            Session::regenerateToken();
        }
        catch(Exception $e){
          
    
        }
        
        
    }
}
