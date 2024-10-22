<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;
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
        'last_login'
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
            return ('https://ui-avatars.com/api//?background=5c60f5&color=fff&name=' . $this->name);
        }
        return file_url($this->picture);
    }

    public function scopeSearchAgent($q, Request $request){
        return $q->when($request->aq, function($q) use($request){
            return $q->where('firstname', 'LIKE', "%{$request->aq}%")->orWhere('lastname', 'LIKE', "%{$request->aq}%")
            ->orWhere(function($q) use($request){
                return $q->whereHas('seller', fn($q) => $q->where('company_name', 'LIKE', "%{$request->aq}%"));
            });
        })->when($request->agentCategory, fn($q) => $q->whereHas('ads', fn($q) => $q->whereHas('categories', fn($q) => $q->whereIn('categories.id', (array) $request->agentCategory))));
    }

    
    
    public function getRoleNameAttribute(){
        return $this->roles()->pluck('name')->first() ?? null;
    }

    public function getRoleIdAttribute(){
        return $this->roles()->pluck('id')->first() ?? null;
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
        return $this->parent_id ? : $this->id;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Illuminate\Support\Facades\Hash::make($password);
    }
}
