<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    public function scopeAdminRoles($q)
    {
        return $q->whereUserId(auth()->user()->employer_id);
    }
}
