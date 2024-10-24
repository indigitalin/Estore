<?php

/**
 * Generate file url based on upload channel
 * 
 * @param string $image
 */
function file_url(string $image) : string{
    if(env('UPLOAD_CHANNEL') == 's3'){
        return env('AWS_S3_URL').'/'.$image;
    }
    return asset('images/'.$image);
}

/**
 * Check if current user has given role
 * 
 * @param string $role
 */
function hasRole(string $role = null) : bool{
    return auth()->check() && auth()->user()->hasRole($role);
}
