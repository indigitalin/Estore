<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([[
            'name' => 'Create Users',
            'guard_name' => 'web',
            'section' => 'Users',
            'type' => 'admin',
        ],[
            'name' => 'Edit Users',
            'guard_name' => 'web',
            'section' => 'Users',
            'type' => 'admin',
        ],[
            'name' => 'Delete Users',
            'guard_name' => 'web',
            'section' => 'Users',
            'type' => 'admin',
        ],[
            'name' => 'View Users',
            'guard_name' => 'web',
            'section' => 'Users',
            'type' => 'admin',
        ]]);

        Permission::insert([[
            'name' => 'Create Roles',
            'guard_name' => 'web',
            'section' => 'Roles',
            'type' => 'admin',
        ],[
            'name' => 'Edit Roles',
            'guard_name' => 'web',
            'section' => 'Roles',
            'type' => 'admin',
        ],[
            'name' => 'Delete Roles',
            'guard_name' => 'web',
            'section' => 'Roles',
            'type' => 'admin',
        ],[
            'name' => 'View Roles',
            'guard_name' => 'web',
            'section' => 'Roles',
            'type' => 'admin',
        ]]);
    }
}
