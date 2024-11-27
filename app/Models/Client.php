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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    public function updateLogo($file, int $isRemoved)
    {
        /**
         * If action is to remove logo, delete logo and set logo as null
         */
        if ($isRemoved) {
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

    public function getDefaultLogoUrlAttribute()
    {
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->business_name);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function getIndustryNameAttribute()
    {
        return $this->industry->name ?? 'Other';
    }

    /**
     * Categories of the client
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Collections of the client
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    /**
     * Users of the client
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class)->store();
    }

    public function websites()
    {
        return $this->hasMany(Website::class)->website();
    }

    public function menus()
    {
        return $this->hasMany(Menu::class)->menu();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function product_types()
    {
        return $this->hasMany(ProductType::class);
    }

    public function product_vendors()
    {
        return $this->hasMany(ProductVendor::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
