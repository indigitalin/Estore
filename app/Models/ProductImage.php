<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
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
        'image_path',
        'product_id',
        'client_id',
    ];

    /**
     * The attributes that are lazy loaded.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return file_url($this->image_path);
    }

    public function updateImage($file)
    {
        if ($image = $this->uploadImage(file: $file, path: 'products', maxHeight: 200, maxWidth: 200, ratio: '1:1')) {
            $this->update(['image_path' => $image]);
        }
    }

    public function remove()
    {
        $this->removeFile($this->image_path);
        $this->forceDelete();
    }
}
