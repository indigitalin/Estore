<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'custom_link'
    ];

    public function scopeMenu($q){
        return $q->whereNull('parent_id');
    }

    public function childs(){
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
}
