<?php
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Generate file url based on upload channel
 *
 * @param string $image
 */

function file_url(string $image): string
{
    if (env('UPLOAD_CHANNEL') == 's3') {
        return env('AWS_S3_URL') . '/' . $image;
    }
    return asset('images/' . $image);
}

/**
 * Check if current user has given role
 *
 * @param string $role
 */
function hasRole(string $role = null): bool
{
    return auth()->check() && auth()->user()->hasRole($role);
}

function roleRoute(string $routeName, $param = null)
{
    /**
     * Check if role is admin or admin user
     */
    if (isAdmin()) {
        $routeName = str_replace('{role}', 'admin', $routeName);
        if (!Route::has($routeName)) {
            throw new RouteNotFoundException("Route '{$routeName}' not found.");
        }
        return route($routeName, $param);
    }
    /**
     * Check if role is client or client user
     */
    else if (isClient()) {
        $routeName = str_replace('{role}', 'client', $routeName);
        if (!Route::has($routeName)) {
            throw new RouteNotFoundException("Route '{$routeName}' not found.");
        }
        
        return route($routeName, $param);
    }
    return null;
}

/**
 * Check if user is admin or admin user
 */
function isAdmin(){
    return hasRole('super admin|super admin user');
}

/**
 * Check if user client or client user
 */
function isClient(){
    return hasRole('client admin|client admin user');
}