<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'type',
        'name',
        'address',
        'city',
        'postalcode',
        'state_id',
        'country_id',
        'phone',
        'email',
        'website',
        'logo',
        'latitude',
        'longitude',
        'password',
        'api_key',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'api_key',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
