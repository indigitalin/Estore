<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are lazy loaded.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'name',
        'picture_url',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'status',
        'email',
        'password',
        'email_verified_at',
        'picture',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getPictureAttribute($picture)
    {
        return $picture ?: 'default.png';
    }

    public function getPictureUrlAttribute($picture)
    {
        if ($this->picture == 'default.png') {
            return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
        }
        return image_url($this->picture);
    }

    public function getPhoneNumberAttribute()
    {
        $value = $this->phone;
        return '' . substr($value, 1, 5) . '' . substr($value, 6, 5);

    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('M d,Y');
    }

    public function getLastLoginAttribute($value)
    {
        return $value != null ? \Carbon\Carbon::parse($value)->format('M d,Y h:i A') : '';
    }

    public function getStatusLabelAttribute()
    {

        return $this->status == "1" ? 'Active' : 'Inactive';
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function scopeAdminStaffs($q){
        return $q->where('id', '!=', auth()->user()->id);
    }
}
