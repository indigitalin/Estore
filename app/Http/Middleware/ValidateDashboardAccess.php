<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateDashboardAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $access): Response
    {
        switch($access){
            case "superadmin" :
                if(hasRole('super admin')){
                    return redirect()->route('index');
                }
            break;

            case "clientadmin" :
                if(hasRole('client admin')){
                    return redirect()->route('index');
                }
            break;
        }
        return $next($request);
    }
}
