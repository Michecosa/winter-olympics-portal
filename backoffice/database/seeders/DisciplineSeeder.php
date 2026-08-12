<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DisciplineSeeder extends Seeder
{
    /** Cartella (relativa al disco public) in cui finiscono le copertine. */
    private const IMAGE_DIR = 'disciplines_images';

    public function run(): void
    {
        $this->publishImages();

        // cover_image e' il path relativo al disco "public" (storage/app/public),
        // esattamente come quello salvato da Storage::putFile() nel backoffice.
        $disciplines = [
            // Sci
            [
                'name' => 'Sci Alpino', 'sport' => 'Sci',
                'cover_image' => 'disciplines_images/sci-alpino.jpg',
                'description' => 'Disciplina che consiste nello scendere a valle lungo un pendio montano innevato su sci. Comprende specialità come lo Slalom Speciale, lo Slalom Gigante, il Super-G e la Discesa Libera.'
            ],
            [
                'name' => 'Sci di Fondo', 'sport' => 'Sci',
                'cover_image' => 'disciplines_images/sci-di-fondo.jpg',
                'description' => 'Sport di resistenza in cui gli atleti percorrono lunghe distanze su terreni innevati pianeggianti o collinari. È una delle discipline fondamentali dei Giochi Olimpici Invernali.'
            ],
            [
                'name' => 'Salto con gli Sci', 'sport' => 'Sci',
                'cover_image' => 'disciplines_images/salto-con-gli-sci.jpg',
                'description' => 'Competizione in cui gli atleti scendono lungo una rampa per spiccare il volo e atterrare il più lontano possibile, mantenendo stile e controllo durante la fase aerea.'
            ],
            [
                'name' => 'Combinata Nordica', 'sport' => 'Sci',
                'cover_image' => 'disciplines_images/combinata-nordica.jpg',
                'description' => 'Uno sport che unisce due discipline diverse: il salto con gli sci e lo sci di fondo. Richiede sia potenza esplosiva che grande resistenza aerobica.'
            ],
            [
                'name' => 'Sci Freestyle', 'sport' => 'Sci',
                'cover_image' => 'disciplines_images/sci-freestyle.jpg',
                'description' => 'Disciplina spettacolare che include salti, acrobazie e gobbe. Gli atleti vengono valutati sia per la tecnica che per il coefficiente di difficoltà delle loro evoluzioni.'
            ],
            [
                'name' => 'Snowboard', 'sport' => 'Sci',
                'cover_image' => 'disciplines_images/snowboard.jpg',
                'description' => 'Sport nato negli anni \'60 che consiste nel scivolare sulla neve utilizzando una tavola. Include specialità come il Big Air, l\'Halfpipe e lo Slalom Parallelo.'
            ],

            // Pattinaggio
            [
                'name' => 'Pattinaggio di Figura', 'sport' => 'Pattinaggio',
                'cover_image' => 'disciplines_images/pattinaggio-di-figura.jpg',
                'description' => 'Sport artistico eseguito su ghiaccio con pattini a lama. Singoli, coppie o gruppi eseguono salti, piroette e passi su una base musicale.'
            ],
            [
                'name' => 'Pattinaggio di Velocità', 'sport' => 'Pattinaggio',
                'cover_image' => 'disciplines_images/pattinaggio-di-velocita.jpg',
                'description' => 'Corsa su pattini a lama su una pista di ghiaccio di forma ovale. Gli atleti competono contro il tempo su diverse distanze, raggiungendo velocità elevatissime.'
            ],
            [
                'name' => 'Short Track', 'sport' => 'Pattinaggio',
                'cover_image' => 'disciplines_images/short-track.jpg',
                'description' => 'Gara di velocità su ghiaccio che si svolge su una pista corta (111 metri). È noto per i sorpassi aggressivi e la strategia di gara in spazi ristretti.'
            ],

            // Altri Sport
            [
                'name' => 'Biathlon', 'sport' => 'Biathlon',
                'cover_image' => 'disciplines_images/biathlon.jpg',
                'description' => 'Disciplina che combina lo sci di fondo con il tiro a segno con carabina. Gli atleti devono gestire lo sforzo fisico per mantenere la precisione al poligono.'
            ],
            [
                'name' => 'Curling', 'sport' => 'Curling',
                'cover_image' => 'disciplines_images/curling.jpg',
                'description' => 'Sport di squadra soprannominato "scacchi sul ghiaccio". I giocatori fanno scivolare pietre di granito verso un bersaglio, mentre i compagni usano scope per modificare la traiettoria.'
            ],
            [
                'name' => 'Hockey su Ghiaccio', 'sport' => 'Hockey su Ghiaccio',
                'cover_image' => 'disciplines_images/hockey-su-ghiaccio.jpg',
                'description' => 'Sport di contatto veloce e fisico giocato tra due squadre su pattini. L\'obiettivo è segnare un disco (puck) nella rete avversaria usando bastoni ricurvi.'
            ],
            [
                'name' => 'Slittino', 'sport' => 'Slittino',
                'cover_image' => 'disciplines_images/slittino.jpg',
                'description' => 'Gara di velocità su una piccola slitta guidata stando in posizione supina (a pancia in su). È considerata una delle discipline più veloci e pericolose dei giochi.'
            ],
            [
                'name' => 'Bob', 'sport' => 'Bob',
                'cover_image' => 'disciplines_images/bob.jpg',
                'description' => 'Sport invernale in cui equipaggi da due o quattro persone eseguono discese cronometrate lungo una pista ghiacciata a bordo di un mezzo aerodinamico dotato di pattini.'
            ],
            [
                'name' => 'Skeleton', 'sport' => 'Bob',
                'cover_image' => 'disciplines_images/skeleton.jpg',
                'description' => 'Disciplina simile allo slittino, ma l\'atleta scende in posizione prona (a pancia in giù) con la testa in avanti, raggiungendo velocità che superano i 130 km/h.'
            ],
        ];

        // I model non dichiarano $fillable, quindi si assegnano i campi uno a uno
        // (il mass assignment verrebbe scartato in silenzio).
        foreach ($disciplines as $discipline) {
            $newDiscipline = Discipline::where('name', $discipline['name'])->first() ?? new Discipline();

            $newDiscipline->name        = $discipline['name'];
            $newDiscipline->sport       = $discipline['sport'];
            $newDiscipline->cover_image = $discipline['cover_image'];
            $newDiscipline->description = $discipline['description'];

            $newDiscipline->save();
        }
    }

    /**
     * Copia le copertine versionate in database/seeders/images/disciplines
     * dentro storage/app/public, da dove vengono servite via public/storage.
     * Serve dopo un clone del progetto, quando storage/ e' ancora vuota.
     */
    private function publishImages(): void
    {
        $source = database_path('seeders/images/disciplines');

        if (!is_dir($source)) {
            $this->command?->warn("Cartella immagini non trovata: {$source}");

            return;
        }

        foreach (glob($source . '/*.jpg') as $file) {
            $target = self::IMAGE_DIR . '/' . basename($file);

            if (!Storage::disk('public')->exists($target)) {
                Storage::disk('public')->put($target, file_get_contents($file));
            }
        }
    }
}
