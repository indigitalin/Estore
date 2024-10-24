<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Helper\Upload;
    protected $fillable = [
        'user_id',
        'business_name',
        'industry_id',
        'description',
        'address',
        'city',
        'state_id',
        'country_id',
        'plan_id',
        'status',
        'pan',
        'gst',
        'whatsapp',
        'website',
        'logo',
        'postcode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Suspended';
    }

    public function getLogoAttribute($logo)
    {
        return $logo ?: 'default.png';
    }

    public function setLogoAttribute($logo)
    {
        /**
         * Upload new image and remove current picture
         * Dont worry about default.png
         */
        if ($logo = $this->uploadImage(file: $logo, path: 'logos', maxHeight: 200, maxWidth: 200, ratio: '1:1')) {
            if ($this->attributes['logo']) {
                // Delete the current logo
                $this->removeFile($this->attributes['logo']);
            }
            $this->attributes['logo'] = $logo;
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
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->business_name);
    }

    public function industry(){
        return $this->belongsTo(Industry::class);
    }

    public function getIndustryNameAttribute(){
        return $this->industry->name ?? 'Other';
    }
}
