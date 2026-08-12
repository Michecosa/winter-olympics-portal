<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // L'ordine conta: AthleteSeeder collega atleti a nazioni e discipline.
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            DisciplineSeeder::class,
            AthleteSeeder::class,
        ]);
    }
}
