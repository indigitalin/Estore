<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
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
        'file_type',
        'file_path',
        'attachment_type',
        'client_id',
    ];

    /**
     * The attributes that are lazy loaded.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'file_url',
    ];

    public function getFileUrlAttribute(){
        return file_url($this->file_path);
    }
}
