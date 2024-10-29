<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\ModuleSeeder;
use Database\Seeders\IndustrySeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SuperAdminSeeder;
use Database\Seeders\CountryStateSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            //Dont change the order
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminSeeder::class,
            CountryStateSeeder::class,
            IndustrySeeder::class,
            ModuleSeeder::class
        ]);
    }
}
