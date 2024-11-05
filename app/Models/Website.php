<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Ensure you import the base Model
use Illuminate\Database\Eloquent\Builder;

class Website extends Store
{   
    use HasFactory;

    //Define table name
    protected $table = 'stores';

    // Boot method to listen for model events
    protected static function boot()
    {
        parent::boot();

        // Set the type to 'website' when a record is created
        static::creating(function ($model) {
            $model->type = 'website';
        });
    }

    public function menus(){
        return $this->hasMany(Menu::class)->menu();
    }

    public function banners(){
        return $this->hasMany(Banner::class);
    }
}
