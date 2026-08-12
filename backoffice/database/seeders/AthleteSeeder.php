<?php

namespace Database\Seeders;

use App\Models\Athlete;
use App\Models\Country;
use App\Models\Discipline;
use Illuminate\Database\Seeder;

class AthleteSeeder extends Seeder
{
    /**
     * Ogni riga e': [nome, cognome, codice nazione, data di nascita, [disciplina => medaglia]].
     * La medaglia puo' essere 'gold', 'silver', 'bronze' oppure 'none' (partecipante).
     * Alcuni atleti gareggiano in piu' discipline affini, come accade davvero ai Giochi.
     */
    private const ATHLETES = [
        // --- Sci Alpino ---
        ['Matteo', 'Bordignon', 'IT', '1994-11-02', ['Sci Alpino' => 'gold']],
        ['Andreas', 'Gruber', 'AT', '1996-03-14', ['Sci Alpino' => 'silver']],
        ['Lucien', 'Perret', 'FR', '1998-07-21', ['Sci Alpino' => 'bronze']],
        ['Nina', 'Zbinden', 'CH', '1999-01-30', ['Sci Alpino' => 'none']],
        ['Sofia', 'Rinaldi', 'IT', '2001-05-18', ['Sci Alpino' => 'none']],
        ['Kristoffer', 'Dahl', 'NO', '1995-09-08', ['Sci Alpino' => 'none']],
        ['Emily', 'Carter', 'US', '1997-12-11', ['Sci Alpino' => 'none']],
        ['Javier', 'Ortega', 'ES', '2000-04-27', ['Sci Alpino' => 'none']],

        // --- Sci di Fondo / Biathlon ---
        ['Sigrid', 'Halvorsen', 'NO', '1995-02-09', ['Sci di Fondo' => 'gold', 'Biathlon' => 'gold']],
        ['Aino', 'Virtanen', 'FI', '1996-08-16', ['Sci di Fondo' => 'silver', 'Biathlon' => 'bronze']],
        ['Elin', 'Bergström', 'SE', '1993-06-03', ['Sci di Fondo' => 'bronze']],
        ['Federico', 'Zanetti', 'IT', '1998-10-25', ['Sci di Fondo' => 'none', 'Combinata Nordica' => 'none']],
        ['Pavel', 'Novotný', 'CZ', '1994-03-19', ['Sci di Fondo' => 'none', 'Combinata Nordica' => 'none']],
        ['Jonas', 'Lindqvist', 'SE', '1999-11-07', ['Sci di Fondo' => 'none']],
        ['Lukas', 'Brandt', 'DE', '1997-01-22', ['Biathlon' => 'silver']],
        ['Dorothea', 'Keller', 'DE', '1995-05-30', ['Biathlon' => 'none']],
        ['Lisa', 'Gasser', 'AT', '2000-09-12', ['Biathlon' => 'none']],
        ['Tommaso', 'Ferri', 'IT', '1996-12-04', ['Biathlon' => 'none']],

        // --- Salto con gli Sci / Combinata Nordica ---
        ['Jan', 'Kowalski', 'PL', '1994-04-06', ['Salto con gli Sci' => 'gold']],
        ['Matej', 'Zupan', 'SI', '1997-07-14', ['Salto con gli Sci' => 'silver']],
        ['Stefan', 'Hofer', 'AT', '1995-10-01', ['Salto con gli Sci' => 'bronze', 'Combinata Nordica' => 'gold']],
        ['Kenji', 'Nakamura', 'JP', '1992-02-28', ['Salto con gli Sci' => 'none', 'Combinata Nordica' => 'bronze']],
        ['Aleksander', 'Rud', 'NO', '1998-06-17', ['Salto con gli Sci' => 'none', 'Combinata Nordica' => 'silver']],

        // --- Sci Freestyle / Snowboard ---
        ['Chloe', 'Bennett', 'US', '2002-03-25', ['Sci Freestyle' => 'gold']],
        ['Léa', 'Dubois', 'FR', '2001-08-09', ['Sci Freestyle' => 'silver']],
        ['Mia', 'Lindberg', 'SE', '2000-01-16', ['Sci Freestyle' => 'bronze']],
        ['Ryan', 'Mitchell', 'CA', '1999-05-23', ['Sci Freestyle' => 'none']],
        ['Giulia', 'Moretti', 'IT', '2003-09-02', ['Sci Freestyle' => 'none', 'Snowboard' => 'none']],
        ['Tyler', 'Brooks', 'US', '2000-11-19', ['Snowboard' => 'gold']],
        ['Yuki', 'Sato', 'JP', '2002-04-08', ['Snowboard' => 'silver']],
        ['Ethan', 'Wong', 'CA', '1998-12-27', ['Snowboard' => 'bronze']],
        ['Lin', 'Wei', 'CN', '2004-02-13', ['Snowboard' => 'none']],
        ['Anna', 'Nováková', 'CZ', '2001-06-30', ['Snowboard' => 'none']],
        ['Marta', 'Solís', 'ES', '2002-10-11', ['Snowboard' => 'none']],

        // --- Pattinaggio di Figura ---
        ['Haruka', 'Ishikawa', 'JP', '2001-01-05', ['Pattinaggio di Figura' => 'gold']],
        ['Ji-woo', 'Kim', 'KR', '2000-07-26', ['Pattinaggio di Figura' => 'silver']],
        ['Elena', 'Rossi', 'IT', '1999-03-31', ['Pattinaggio di Figura' => 'bronze']],
        ['Sophie', 'Laurent', 'FR', '2002-09-15', ['Pattinaggio di Figura' => 'none']],
        ['Daniel', 'Whitfield', 'GB', '1997-05-12', ['Pattinaggio di Figura' => 'none']],
        ['Meng', 'Li', 'CN', '2003-11-24', ['Pattinaggio di Figura' => 'none']],

        // --- Pattinaggio di Velocità / Short Track ---
        ['Sven', 'de Vries', 'NL', '1994-08-20', ['Pattinaggio di Velocità' => 'gold']],
        ['Bram', 'Jansen', 'NL', '1996-02-07', ['Pattinaggio di Velocità' => 'silver']],
        ['Erik', 'Lund', 'NO', '1995-12-18', ['Pattinaggio di Velocità' => 'bronze']],
        ['Hao', 'Zhang', 'CN', '1998-04-03', ['Pattinaggio di Velocità' => 'none', 'Short Track' => 'silver']],
        ['Sanne', 'Bakker', 'NL', '1999-10-29', ['Pattinaggio di Velocità' => 'none', 'Short Track' => 'none']],
        ['Michael', 'Turner', 'US', '1993-06-21', ['Pattinaggio di Velocità' => 'none']],
        ['Min-jun', 'Park', 'KR', '1999-01-09', ['Short Track' => 'gold']],
        ['Charlotte', 'Dupont', 'FR', '2000-05-27', ['Short Track' => 'bronze']],
        ['Seo-yeon', 'Ryu', 'KR', '2002-08-14', ['Short Track' => 'none']],
        ['Marco', 'Bellini', 'IT', '1997-11-01', ['Short Track' => 'none']],

        // --- Curling ---
        ['Fiona', 'MacLeod', 'GB', '1992-03-08', ['Curling' => 'gold']],
        ['Owen', 'Sinclair', 'CA', '1990-09-19', ['Curling' => 'silver']],
        ['Erik', 'Sundberg', 'SE', '1991-12-02', ['Curling' => 'bronze']],
        ['Hanna', 'Eriksson', 'SE', '1994-07-11', ['Curling' => 'none']],
        ['Stefano', 'Colombo', 'IT', '1993-04-23', ['Curling' => 'none']],
        ['Ji-hoon', 'Kang', 'KR', '1995-10-06', ['Curling' => 'none']],

        // --- Hockey su Ghiaccio ---
        ['Connor', 'Blake', 'CA', '1996-01-28', ['Hockey su Ghiaccio' => 'gold']],
        ['Jesse', 'Koivisto', 'FI', '1995-06-15', ['Hockey su Ghiaccio' => 'silver']],
        ['Erik', 'Wallin', 'SE', '1994-02-04', ['Hockey su Ghiaccio' => 'bronze']],
        ['Jake', 'Sullivan', 'US', '1997-09-22', ['Hockey su Ghiaccio' => 'none']],
        ['Ondřej', 'Doležal', 'CZ', '1993-11-13', ['Hockey su Ghiaccio' => 'none']],
        ['Luca', 'Ferrero', 'IT', '1998-05-07', ['Hockey su Ghiaccio' => 'none']],

        // --- Slittino ---
        ['Felix', 'Bauer', 'DE', '1995-03-17', ['Slittino' => 'gold']],
        ['Dominik', 'Egger', 'AT', '1996-08-05', ['Slittino' => 'silver']],
        ['Sandra', 'Weber', 'DE', '1997-12-20', ['Slittino' => 'bronze']],
        ['Alex', 'Rainer', 'IT', '1999-04-14', ['Slittino' => 'none']],
        ['Katrin', 'Moser', 'AT', '2000-10-02', ['Slittino' => 'none']],

        // --- Bob / Skeleton ---
        ['Julia', 'Hoffmann', 'DE', '1994-05-26', ['Bob' => 'gold']],
        ['Marcus', 'Schulz', 'DE', '1992-09-30', ['Bob' => 'silver']],
        ['Patrick', "O'Neill", 'CA', '1993-01-12', ['Bob' => 'bronze']],
        ['Alberto', 'Costa', 'IT', '1996-07-08', ['Bob' => 'none', 'Skeleton' => 'none']],
        ['Nadia', 'Steiner', 'CH', '1997-02-19', ['Bob' => 'none', 'Skeleton' => 'silver']],
        ['Jamal', 'Reed', 'US', '1995-11-25', ['Bob' => 'none', 'Skeleton' => 'bronze']],
        ['Oliver', 'Grant', 'GB', '1994-06-09', ['Skeleton' => 'gold']],
        ['Amelia', 'Shaw', 'GB', '1998-03-03', ['Skeleton' => 'none']],
    ];

    public function run(): void
    {
        $countries   = Country::pluck('id', 'code');
        $disciplines = Discipline::pluck('id', 'name');

        foreach (self::ATHLETES as $index => [$firstName, $lastName, $countryCode, $birthDate, $results]) {
            // I model non dichiarano $fillable, quindi si assegnano i campi uno a uno
            // (il mass assignment verrebbe scartato in silenzio).
            $athlete = Athlete::where('first_name', $firstName)
                ->where('last_name', $lastName)
                ->first() ?? new Athlete();

            $athlete->first_name = $firstName;
            $athlete->last_name  = $lastName;
            $athlete->birth_date = $birthDate;
            $athlete->country_id = $countries[$countryCode];
            $athlete->bio        = $this->buildBio($firstName, $lastName, array_keys($results), $index);

            $athlete->save();

            // sync() sostituisce le associazioni esistenti: il seeder resta rieseguibile
            $pivot = [];
            foreach ($results as $disciplineName => $medal) {
                $pivot[$disciplines[$disciplineName]] = ['medal_type' => $medal];
            }
            $athlete->disciplines()->sync($pivot);
        }
    }

    /** Articolo determinativo di ogni disciplina, per le preposizioni articolate delle bio. */
    private const ARTICLES = [
        'Sci Alpino'              => 'lo',
        'Sci di Fondo'            => 'lo',
        'Salto con gli Sci'       => 'il',
        'Combinata Nordica'       => 'la',
        'Sci Freestyle'           => 'lo',
        'Snowboard'               => 'lo',
        'Pattinaggio di Figura'   => 'il',
        'Pattinaggio di Velocità' => 'il',
        'Short Track'             => 'lo',
        'Biathlon'                => 'il',
        'Curling'                 => 'il',
        'Hockey su Ghiaccio'      => "l'",
        'Slittino'                => 'lo',
        'Bob'                     => 'il',
        'Skeleton'                => 'lo',
    ];

    /**
     * Costruisce una biografia variata a partire dalle discipline dell'atleta.
     * I testi sono neutri: la stessa frase vale per atleti e atlete.
     */
    private function buildBio(string $firstName, string $lastName, array $disciplines, int $index): string
    {
        $templates = [
            ":nome è oggi tra i profili più seguiti :del_disciplina. Tecnica pulita e grande freddezza nelle gare che contano lo rendono un avversario temuto in ogni prova di Coppa del Mondo.",
            "La carriera di :nome :nel_disciplina si è costruita a colpi di piazzamenti, fino al primo podio internazionale e a una lunga serie di risultati di vertice.",
            ":nome è una delle presenze più spettacolari :del_disciplina: uno stile aggressivo che divide gli appassionati, ma che ha firmato alcune delle prestazioni più ricordate degli ultimi anni.",
            "Un grave infortunio ne ha messo in dubbio la carriera, ma il ritorno ai massimi livelli :del_disciplina ha reso :nome una delle storie più seguite verso Milano Cortina 2026.",
            "Un approccio metodico e attentissimo ai dettagli: :nome lavora tutto l'anno con il proprio staff tecnico per limare centesimi preziosi :nel_disciplina, con una costanza di rendimento rara.",
            "L'esordio di :nome nel circuito maggiore :del_disciplina è arrivato prestissimo e con un impatto immediato. Oggi è il punto di riferimento della propria nazionale.",
        ];

        $bio = strtr($templates[$index % count($templates)], [
            ':nome'           => $firstName . ' ' . $lastName,
            ':del_disciplina' => $this->withPreposition('de', $disciplines[0]),
            ':nel_disciplina' => $this->withPreposition('ne', $disciplines[0]),
        ]);

        if (isset($disciplines[1])) {
            $bio .= " Parallelamente gareggia anche " . $this->withPreposition('ne', $disciplines[1])
                . ", dove ha ottenuto ottimi riscontri.";
        }

        return $bio;
    }

    /** Unisce "de"/"ne" all'articolo della disciplina: dello Sci Alpino, nell'Hockey su Ghiaccio... */
    private function withPreposition(string $preposition, string $discipline): string
    {
        $article = self::ARTICLES[$discipline] ?? 'il';

        return match ($article) {
            'lo' => "{$preposition}llo {$discipline}",
            'la' => "{$preposition}lla {$discipline}",
            "l'" => "{$preposition}ll'{$discipline}",
            default => "{$preposition}l {$discipline}",
        };
    }
}
