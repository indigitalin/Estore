<?php

function file_url($image){
    if(env('UPLOAD_CHANNEL') == 's3'){
        return env('AWS_S3_URL').'/'.$image;
    }
    return asset('images/'.$image);
}
