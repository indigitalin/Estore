<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'client_id',
        'website_id',
        'parent_id',
        'link',
    ];

    public function scopeMenu($q){
        return $q->whereNull('parent_id');
    }
}