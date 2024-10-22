<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Role,User};
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!User::where('email','admin@example.com')->exists()){
            $admin = \App\Models\User::factory()->create([
                'firstname' => 'John',
                'lastname' => 'Doe',
                'email' => 'admin@example.com',
                'password' => '12345678',
                'email_verified_at' => now(),
                'status' => '1',
            ]);

            if(!Role::where('name', 'admin')->where('user_id',null)->exists()){
                $adminRole = Role::create(['name' => 'super admin','guard_name' => 'web','user_id' => null]);  
                $admin->givePermissionTo(Permission::all());
            }
        }

       

     
    }
}
