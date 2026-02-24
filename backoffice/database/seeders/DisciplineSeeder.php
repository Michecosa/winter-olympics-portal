<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DisciplineSeeder extends Seeder
{
    public function run(Faker $faker): void
    {
        $disciplines = [
            // Sci
            ['name' => 'Sci Alpino', 'sport' => 'Sci'],
            ['name' => 'Sci di Fondo', 'sport' => 'Sci'],
            ['name' => 'Salto con gli Sci', 'sport' => 'Sci'],
            ['name' => 'Combinata Nordica', 'sport' => 'Sci'],
            ['name' => 'Sci Freestyle', 'sport' => 'Sci'],
            ['name' => 'Snowboard', 'sport' => 'Sci'],
            
            // Pattinaggio
            ['name' => 'Pattinaggio di Figura', 'sport' => 'Pattinaggio'],
            ['name' => 'Pattinaggio di Velocità', 'sport' => 'Pattinaggio'],
            ['name' => 'Short Track', 'sport' => 'Pattinaggio'],
            
            // Altri Sport
            ['name' => 'Biathlon', 'sport' => 'Biathlon'],
            ['name' => 'Curling', 'sport' => 'Curling'],
            ['name' => 'Hockey su Ghiaccio', 'sport' => 'Hockey su Ghiaccio'],
            ['name' => 'Slittino', 'sport' => 'Slittino'],
            ['name' => 'Bob', 'sport' => 'Bob'],
            ['name' => 'Skeleton', 'sport' => 'Bob'],
        ];

        foreach ($disciplines as $discipline) {
            $newDiscipline = new Discipline();

            $newDiscipline->name = $discipline['name'];
            $newDiscipline->sport = $discipline['sport'];
            $newDiscipline->description = $faker->paragraphs(3, true);

            $newDiscipline->save();
        }
    }
}
