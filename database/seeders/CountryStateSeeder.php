<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = \App\Models\Country::firstOrCreate([
            'name' => 'India',
            'code' => 'IN'
        ],['currency' => '₹']);

        $country->states()->createMany([
            ['name' => 'Andhra Pradesh'],
            ['name' => 'Arunachal Pradesh'],
            ['name' => 'Assam'],
            ['name' => 'Bihar'],
            ['name' => 'Chhattisgarh'],
            ['name' => 'Goa'],
            ['name' => 'Gujarat'],
            ['name' => 'Haryana'],
            ['name' => 'Himachal Pradesh'],
            ['name' => 'Jharkhand'],
            ['name' => 'Karnataka'],
            ['name' => 'Kerala'],
            ['name' => 'Madhya Pradesh'],
            ['name' => 'Maharashtra'],
            ['name' => 'Manipur'],
            ['name' => 'Meghalaya'],
            ['name' => 'Mizoram'],
            ['name' => 'Nagaland'],
            ['name' => 'Odisha'],
            ['name' => 'Punjab'],
            ['name' => 'Rajasthan'],
            ['name' => 'Sikkim'],
            ['name' => 'Tamil Nadu'],
            ['name' => 'Telangana'],
            ['name' => 'Tripura'],
            ['name' => 'Uttar Pradesh'],
            ['name' => 'Uttarakhand'],
            ['name' => 'West Bengal'],
            ['name' => 'Andaman and Nicobar Islands'],  // Union Territory
            ['name' => 'Chandigarh'],                  // Union Territory
            ['name' => 'Dadra and Nagar Haveli and Daman and Diu'], // Union Territory
            ['name' => 'Lakshadweep'],                 // Union Territory
            ['name' => 'Delhi'],                       // Union Territory
            ['name' => 'Puducherry'],                  // Union Territory
            ['name' => 'Ladakh'],                      // Union Territory
            ['name' => 'Jammu and Kashmir'],           // Union Territory
        ]);        
    }
}
