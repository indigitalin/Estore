<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::firstOrcreate(
            ['email' => 'admin@example.com'],
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'password' => '12345678',
                'email_verified_at' => now(),
                'status' => '1',
            ]);
        $superAdmin = Role::firstOrcreate(
            ['name' => 'super admin'],
            ['guard_name' => 'web']
        );

        $clientAdmin = Role::firstOrcreate(
            ['name' => 'client admin'],
            ['guard_name' => 'web']
        );

        $superAdmin->givePermissionTo(Permission::all());
        $user->roles()->sync($superAdmin->id);
    }
}
