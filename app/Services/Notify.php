<?php

namespace App\Services;

use App\Jobs\Email;
use App\Jobs\Notification;

trait Notify{

    /**
     * Dispatch email job
     * @param Email $mail
     */
    public static function email(Email $mail){
        !ENV('EMAIL', false) OR dispatch($mail);
    }

    /**
     * Dispatch notification job
     * @param Notification $notification
     */
    public static function notification(Notification $notification){
        !ENV('NOTIFICATION', false) OR dispatch($notification);
    }

    /**
     * Push web notifications
     * 
     * @param array $notification
     */
    public static function web(array $notification){
        //\App\Models\Notification::create($notification);
        //\App\Models\Notification::insert($notification);
    }
}