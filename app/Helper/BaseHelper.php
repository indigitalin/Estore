<?php

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

function roleRoute(string $route, $param = null)
{
    /**
     * Check if role is admin or admin user
     */
    if (isAdmin()) {
        $route = str_replace('{role}', 'admin', $route);
        return route($route, $param);
    }
    /**
     * Check if role is client or client user
     */
    else if (isClient()) {
        $route = str_replace('{role}', 'client', $route);
        return route($route, $param);
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