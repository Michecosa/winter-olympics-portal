<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        // I codici sono ISO 3166-1 alpha-2: il frontend li usa per le bandiere
        // (flagcdn.com / flagsapi.com), quindi devono restare in maiuscolo.
        $countries = [
            ['name' => 'Italia', 'code' => 'IT'],
            ['name' => 'Francia', 'code' => 'FR'],
            ['name' => 'Germania', 'code' => 'DE'],
            ['name' => 'Spagna', 'code' => 'ES'],
            ['name' => 'Stati Uniti', 'code' => 'US'],
            ['name' => 'Regno Unito', 'code' => 'GB'],
            ['name' => 'Giappone', 'code' => 'JP'],
            ['name' => 'Norvegia', 'code' => 'NO'],
            ['name' => 'Svezia', 'code' => 'SE'],
            ['name' => 'Finlandia', 'code' => 'FI'],
            ['name' => 'Austria', 'code' => 'AT'],
            ['name' => 'Svizzera', 'code' => 'CH'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'Paesi Bassi', 'code' => 'NL'],
            ['name' => 'Corea del Sud', 'code' => 'KR'],
            ['name' => 'Cina', 'code' => 'CN'],
            ['name' => 'Slovenia', 'code' => 'SI'],
            ['name' => 'Repubblica Ceca', 'code' => 'CZ'],
            ['name' => 'Polonia', 'code' => 'PL'],
        ];

        // I model non dichiarano $fillable, quindi si assegnano i campi uno a uno
        // (il mass assignment verrebbe scartato in silenzio).
        foreach ($countries as $country) {
            $newCountry = Country::where('code', $country['code'])->first() ?? new Country();

            $newCountry->name = $country['name'];
            $newCountry->code = $country['code'];

            $newCountry->save();
        }
    }
}
