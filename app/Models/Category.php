<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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
        'name',
        'description',
        'client_id',
        'status',
        'parent_id',
        'picture',
        'handle',
        'tax_rate',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];

    public function parent(){
        return $this->belongsTo(self::class);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Inactive';
    }

    public function getPictureAttribute($picture)
    {
        return $picture ?: 'default.png';
    }

    public function getPictureUrlAttribute($picture)
    {
        if ($this->picture == 'default.png') {
            return $this->default_picture_url;
        }
        return file_url($this->picture);
    }

    public function getDefaultPictureUrlAttribute(){
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
    }

    public function updatePicture($file, int $isRemoved){
        /**
         * If action is to remove picture, delete picture and set picture as null
         */
        if($isRemoved){
            $this->removeFile($this->picture);
            $this->update(['picture' => null]);
        }
        /**
         * Upload new picture and remove current picture
         * Dont worry about default.png
         */
        else if ($picture = $this->uploadImage(file: $file, path: 'categories', maxHeight: 400, maxWidth: 400, ratio: '1:1')) {
            if (($this->attributes['picture'] ?? null)) {
                // Delete the current picture
                $this->removeFile($this->picture);
            }
            $this->update(['picture' => $picture]);
        }
    }
}
