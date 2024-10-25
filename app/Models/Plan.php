<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'amount',
        'status',
        'popular',
        'validity',
    ];

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Inactive';
    }

    public function getLastModifiedAttribute()
    {
        return $this->updated_at;

    }

    public function plan_modules()
    {
        return $this->hasMany(ModulePlan::class);
    }

}
