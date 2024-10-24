<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::firstOrcreate(
            ['name' => 'super admin'],
            ['guard_name' => 'web']
        );

        $superAdminUser = Role::firstOrcreate(
            ['name' => 'super admin user'],
            ['guard_name' => 'web']
        );

        $clientAdmin = Role::firstOrcreate(
            ['name' => 'client admin'],
            ['guard_name' => 'web']
        );

        $clientAdminUser = Role::firstOrcreate(
            ['name' => 'client admin user'],
            ['guard_name' => 'web']
        );

        $superAdmin->givePermissionTo(Permission::all());
    }
}
