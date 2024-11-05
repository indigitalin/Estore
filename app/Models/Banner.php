<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
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
        'title',
        'link',
        'position',
        'placement',
        'status',
        'type',
        'mobile',
        'desktop',
        'client_id',
        'website_id',
        'link_newtab',
    ];

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Inactive';
    }

    public function updateDesktopPicture($file, int $isRemoved)
    {
        /**
         * If action is to remove desktop, delete desktop and set desktop as null
         */
        if ($isRemoved) {
            $this->removeFile($this->desktop);
            $this->update(['desktop' => null]);
        }
        /**
         * Upload new desktop and remove current desktop
         * Dont worry about default.png
         */
        else if ($desktop = $this->uploadImage(file: $file, path: 'banners', maxHeight: 400, maxWidth: 400, ratio: '1:1')) {
            if (($this->attributes['desktop'] ?? null)) {
                // Delete the current desktop
                $this->removeFile($this->desktop);
            }
            $this->update(['desktop' => $desktop]);
        }
    }

    public function updateMobilePicture($file, int $isRemoved)
    {
        /**
         * If action is to remove mobile, delete mobile and set mobile as null
         */
        if ($isRemoved) {
            $this->removeFile($this->mobile);
            $this->update(['mobile' => null]);
        }
        /**
         * Upload new mobile and remove current mobile
         * Dont worry about default.png
         */
        else if ($mobile = $this->uploadImage(file: $file, path: 'banners', maxHeight: 400, maxWidth: 400, ratio: '1:1')) {
            if (($this->attributes['mobile'] ?? null)) {
                // Delete the current mobile
                $this->removeFile($this->mobile);
            }
            $this->update(['mobile' => $mobile]);
        }
    }

    public function getDesktopAttribute($desktop)
    {
        return $desktop ?: 'default.png';
    }

    public function getDesktopUrlAttribute($desktop)
    {
        return file_url($this->desktop);
    }

    public function getMobileAttribute($mobile)
    {
        return $mobile ?: 'default.png';
    }

    public function getMobileUrlAttribute($mobile)
    {
        return file_url($this->mobile);
    }

    public function scopeSlider($q)
    {
        return $q->whereType('slider');
    }

    public function scopeBreadcrumb($q)
    {
        return $q->whereType('breadcrumb');
    }
}
