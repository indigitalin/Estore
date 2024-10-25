<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use \App\Services\notification\Auth;
    
    const SUPER_ADMIN_ROLE_ID       = 1;
    const SUPER_ADMIN_USER_ROLE_ID  = 2;
    const CLIENT_ADMIN_ROLE_ID      = 3;
    const CLIENT_ADMIN_ROLE_USER_ID = 4;
    /**
     * Ignore user role names from user when getting user.
     */
    const USER_ROLE_IGNORE_LIST = [
        // 'super admin',
        // 'client admin',
        'super admin user',
        'client admin user'
    ];
    
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;
    use \App\Helper\Upload;
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
        'parent_id',
        'last_login',
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
            'last_login' => 'datetime',
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
            return $this->default_picture_url;
        }
        return file_url($this->picture);
    }

    public function getDefaultPictureUrlAttribute(){
        return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
    }

    public function getRoleNameAttribute()
    {
        return $this->roles()->whereNotIn('name', self::USER_ROLE_IGNORE_LIST)->pluck('name')->first() ?? null;
    }

    public function getRoleIdAttribute()
    {
        return $this->roles()->whereNotIn('name', self::USER_ROLE_IGNORE_LIST)->pluck('id')->first() ?? null;
    }

    public function getPhoneNumberAttribute()
    {
        return $this->phone;
    }

    public function getStatusLabelAttribute()
    {
        return $this->status == "1" ? 'Active' : 'Suspended';
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function staffs()
    {
        if ($this->parent_id) {
            return $this->hasMany(self::class, 'parent_id', 'parent_id')->where('id', '!=', auth()->user()->id);
        } else {
            return $this->hasMany(self::class, 'parent_id', 'id')->where('id', '!=', auth()->user()->id);
        }

    }

    public function getEmployerIdAttribute()
    {
        return $this->parent_id ?: $this->id;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Illuminate\Support\Facades\Hash::make($password);
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
        else if ($picture = $this->uploadImage(file: $file, path: 'avatars', maxHeight: 200, maxWidth: 200, ratio: '1:1')) {
            if (($this->attributes['picture'] ?? null)) {
                // Delete the current picture
                $this->removeFile($this->picture);
            }
            $this->update(['picture' => $picture]);
        }
    }

    /**
	 * Send customized password reset email
	 */
	public function sendPasswordResetNotification($token){
		$this->resetPassword($this, $token);
	}
}
