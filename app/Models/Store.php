<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{   
    use HasFactory;
    use \App\Helper\Upload;
    use SoftDeletes;    
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
        'postcode',
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

    // Boot method to listen for model events
    protected static function boot()
    {
        parent::boot();

        // Set the type to 'store' when a record is created
        static::creating(function ($model) {
            $model->type = 'store';
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeStore($q)
    {
        return $q->whereType('store');
    }

    public function scopeWebsite($q)
    {
        return $q->whereType('website');
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Suspended';
    }

    public function getLogoAttribute($logo)
    {
        return $logo ?: 'default.png';
    }

    public function updateLogo($file, int $isRemoved){
        /**
         * If action is to remove logo, delete logo and set logo as null
         */
        if($isRemoved){
            $this->removeFile($this->logo);
            $this->update(['logo' => null]);
        }
        /**
         * Upload new logo and remove current logo
         * Dont worry about default.png
         */
        else if ($logo = $this->uploadImage(file: $file, path: 'logos', maxHeight: 200, maxWidth: 200, ratio: '1:1')) {
            if (($this->attributes['logo'] ?? null)) {
                // Delete the current logo
                $this->removeFile($this->logo);
            }
            $this->update(['logo' => $logo]);
        }
    }

    public function getLogoUrlAttribute($logo)
    {
        if ($this->logo == 'default.png') {
            return $this->default_logo_url;
        }
        return file_url($this->logo);
    }

    public function getDefaultLogoUrlAttribute(){
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
    }
}
