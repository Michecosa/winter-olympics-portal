<?php

namespace Database\Seeders;

use App\Models\Athlete;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AthleteSeeder extends Seeder
{
    public function run(Faker $faker): void
    {
        for ($i=0; $i < 30; $i++) { 
            $newAthlete = new Athlete();
            $newAthlete->first_name = $faker->firstName();
            $newAthlete->last_name = $faker->lastName();
            $newAthlete->birth_date = $faker->dateTimeBetween('-40 years', '-17 years');
            $newAthlete->bio = "Atleta specializzato nelle discipline invernali, ha partecipato a diverse competizioni internazionali rappresentando con orgoglio la propria nazione.";
            $newAthlete->country_id = rand(1,7);
            $newAthlete->save();
        }
    }
}
