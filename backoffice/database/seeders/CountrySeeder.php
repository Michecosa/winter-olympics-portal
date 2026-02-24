<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Italia', 'code' => 'IT'],
            ['name' => 'Francia', 'code' => 'FR'],
            ['name' => 'Germania', 'code' => 'DE'],
            ['name' => 'Spagna', 'code' => 'ES'],
            ['name' => 'Stati Uniti', 'code' => 'US'],
            ['name' => 'Regno Unito', 'code' => 'GB'],
            ['name' => 'Giappone', 'code' => 'JP'],
        ];

        foreach ($countries as $country) {
            $newCountry = new Country();

            $newCountry->name = $country['name'];
            $newCountry->code = $country['code'];

            $newCountry->save();
        }
    }
}
