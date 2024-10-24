<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        
        $user->roles()->sync(\App\Models\User::SUPER_ADMIN_ROLE_ID);
    }
}
