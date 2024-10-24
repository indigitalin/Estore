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
            case "superAdmin" :
                
                if(!hasRole('super admin|super admin user')){
                    return redirect()->route('index');
                }
            break;

            case "clientAdmin" :
                if(!hasRole('clientAdmin')){
                    return redirect()->route('index');
                }
            break;

            default :
                abort(403);
            break;
        }
        return $next($request);
    }
}
