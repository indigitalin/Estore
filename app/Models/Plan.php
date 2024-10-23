<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Plan extends Model
{
    use HasFactory;
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

}
