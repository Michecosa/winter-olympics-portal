<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Utente di servizio per accedere al backoffice dopo un migrate:fresh.
     * Se l'account esiste gia' non viene toccato, cosi' la password scelta
     * manualmente non viene sovrascritta.
     */
    public function run(): void
    {
        if (User::where('email', 'miche@test.com')->exists()) {
            return;
        }

        $user = new User();

        $user->name              = 'Michela';
        $user->email             = 'miche@test.com';
        $user->password          = Hash::make('password');
        $user->email_verified_at = now();

        $user->save();
    }
}
