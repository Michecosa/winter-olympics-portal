<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplineSeeder extends Seeder
{
public function run(): void
{
    $disciplines = [
        // Sci
        [
            'name' => 'Sci Alpino', 'sport' => 'Sci',
            'description' => 'Disciplina che consiste nello scendere a valle lungo un pendio montano innevato su sci. Comprende specialità come lo Slalom Speciale, lo Slalom Gigante, il Super-G e la Discesa Libera.'
        ],
        [
            'name' => 'Sci di Fondo', 'sport' => 'Sci',
            'description' => 'Sport di resistenza in cui gli atleti percorrono lunghe distanze su terreni innevati pianeggianti o collinari. È una delle discipline fondamentali dei Giochi Olimpici Invernali.'
        ],
        [
            'name' => 'Salto con gli Sci', 'sport' => 'Sci',
            'description' => 'Competizione in cui gli atleti scendono lungo una rampa per spiccare il volo e atterrare il più lontano possibile, mantenendo stile e controllo durante la fase aerea.'
        ],
        [
            'name' => 'Combinata Nordica', 'sport' => 'Sci',
            'description' => 'Uno sport che unisce due discipline diverse: il salto con gli sci e lo sci di fondo. Richiede sia potenza esplosiva che grande resistenza aerobica.'
        ],
        [
            'name' => 'Sci Freestyle', 'sport' => 'Sci',
            'description' => 'Disciplina spettacolare che include salti, acrobazie e gobbe. Gli atleti vengono valutati sia per la tecnica che per il coefficiente di difficoltà delle loro evoluzioni.'
        ],
        [
            'name' => 'Snowboard', 'sport' => 'Sci',
            'description' => 'Sport nato negli anni \'60 che consiste nel scivolare sulla neve utilizzando una tavola. Include specialità come il Big Air, l\'Halfpipe e lo Slalom Parallelo.'
        ],
        
        // Pattinaggio
        [
            'name' => 'Pattinaggio di Figura', 'sport' => 'Pattinaggio',
            'description' => 'Sport artistico eseguito su ghiaccio con pattini a lama. Singoli, coppie o gruppi eseguono salti, piroette e passi su una base musicale.'
        ],
        [
            'name' => 'Pattinaggio di Velocità', 'sport' => 'Pattinaggio',
            'description' => 'Corsa su pattini a lama su una pista di ghiaccio di forma ovale. Gli atleti competono contro il tempo su diverse distanze, raggiungendo velocità elevatissime.'
        ],
        [
            'name' => 'Short Track', 'sport' => 'Pattinaggio',
            'description' => 'Gara di velocità su ghiaccio che si svolge su una pista corta (111 metri). È noto per i sorpassi aggressivi e la strategia di gara in spazi ristretti.'
        ],
        
        // Altri Sport
        [
            'name' => 'Biathlon', 'sport' => 'Biathlon',
            'description' => 'Disciplina che combina lo sci di fondo con il tiro a segno con carabina. Gli atleti devono gestire lo sforzo fisico per mantenere la precisione al poligono.'
        ],
        [
            'name' => 'Curling', 'sport' => 'Curling',
            'description' => 'Sport di squadra soprannominato "scacchi sul ghiaccio". I giocatori fanno scivolare pietre di granito verso un bersaglio, mentre i compagni usano scope per modificare la traiettoria.'
        ],
        [
            'name' => 'Hockey su Ghiaccio', 'sport' => 'Hockey su Ghiaccio',
            'description' => 'Sport di contatto veloce e fisico giocato tra due squadre su pattini. L\'obiettivo è segnare un disco (puck) nella rete avversaria usando bastoni ricurvi.'
        ],
        [
            'name' => 'Slittino', 'sport' => 'Slittino',
            'description' => 'Gara di velocità su una piccola slitta guidata stando in posizione supina (a pancia in su). È considerata una delle discipline più veloci e pericolose dei giochi.'
        ],
        [
            'name' => 'Bob', 'sport' => 'Bob',
            'description' => 'Sport invernale in cui equipaggi da due o quattro persone eseguono discese cronometrate lungo una pista ghiacciata a bordo di un mezzo aerodinamico dotato di pattini.'
        ],
        [
            'name' => 'Skeleton', 'sport' => 'Bob',
            'description' => 'Disciplina simile allo slittino, ma l\'atleta scende in posizione prona (a pancia in giù) con la testa in avanti, raggiungendo velocità che superano i 130 km/h.'
        ],
    ];

    foreach ($disciplines as $discipline) {
        $newDiscipline = new Discipline();
        $newDiscipline->name = $discipline['name'];
        $newDiscipline->sport = $discipline['sport'];
        $newDiscipline->description = $discipline['description'];
        $newDiscipline->save();
    }
}
}
