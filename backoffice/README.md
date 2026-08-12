# Backoffice — Winter Olympics Portal

Applicazione Laravel 11 che svolge due ruoli:

1. **Pannello amministrativo** in Blade, protetto da autenticazione, per gestire discipline, atleti e assegnazione delle medaglie.
2. **API REST pubbliche** in sola lettura, consumate dal frontoffice React in [`../frontend`](../frontend).

Per le istruzioni di installazione complete (backoffice + frontend) vedi il [README principale](../README.md).

<br />

## ⚡ Avvio rapido

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# configurare DB_* nel file .env, poi:
php artisan storage:link
php artisan migrate --seed

php artisan serve      # http://127.0.0.1:8000
npm run dev            # asset Blade (Bootstrap + SASS), secondo terminale
```

Accesso al pannello con l'utente creato dal seeder: **`miche@test.com` / `password`** (credenziali di sviluppo, da cambiare fuori dal locale).

<br />

## 🔧 Variabili d'ambiente rilevanti

| Variabile | Valore consigliato | Perché |
| :--- | :--- | :--- |
| `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | — | Connessione MySQL. Il database va creato vuoto prima delle migrazioni. |
| `FILESYSTEM_DISK` | `public` | Le copertine delle discipline devono essere servite via `/storage`. Con `local` le immagini non sono raggiungibili dal browser. |
| `APP_FRONTEND_URL` | `http://localhost:5173` | Origine autorizzata in `config/cors.php` per le chiamate del frontend React. Se manca vale il default `http://localhost:5173/`. |

`php artisan storage:link` è necessario una sola volta: crea il symlink `public/storage` → `storage/app/public`.

<br />

## 🌱 Seeder

Ordine di esecuzione definito in `DatabaseSeeder` — conta, perché `AthleteSeeder` collega gli atleti a nazioni e discipline già esistenti.

| Seeder | Contenuto |
| :--- | :--- |
| `UserSeeder` | Utente di servizio per il login al backoffice. Esce subito se l'email esiste già, così una password cambiata a mano non viene sovrascritta. |
| `CountrySeeder` | 19 nazioni con codice ISO 3166-1 alpha-2 maiuscolo. |
| `DisciplineSeeder` | 15 discipline con descrizione e copertina; pubblica le immagini da `database/seeders/images/disciplines` in `storage/app/public/disciplines_images`. |
| `AthleteSeeder` | Atleti con nazione, biografia generata e medaglie sulla pivot (`gold` / `silver` / `bronze` / `none`). |

Tutti i seeder sono **idempotenti**: cercano il record esistente prima di crearlo e usano `sync()` per le relazioni, quindi `php artisan db:seed` può essere rieseguito senza duplicare nulla.

Le copertine sono versionate nel repository, così dopo un clone il portale ha subito le immagini anche se `storage/` è vuota.

```bash
php artisan db:seed                    # popola / aggiorna
php artisan db:seed --class=UserSeeder # singolo seeder
php artisan migrate:fresh --seed       # reset totale (cancella i dati)
```

<br />

## 🧭 Rotte

### Area amministrativa (`auth` + `verified`)

| Metodo | Rotta | Controller | Descrizione |
| :--- | :--- | :--- | :--- |
| `GET` | `/admin` | `Admin\DashboardController@index` | Homepage del pannello. |
| `GET` | `/admin/profile` | `Admin\DashboardController@profile` | Profilo dell'utente loggato. |
| — | `/disciplines` | `Admin\DisciplineController` | Resource completa (index, create, store, show, edit, update, destroy). |
| — | `/athletes` | `Admin\AthleteController` | Resource completa. |
| — | `/profile` | `ProfileController` | Modifica ed eliminazione account (Breeze). |

Le rotte di autenticazione (login, registrazione, reset password, verifica email) sono in `routes/auth.php`.

### API pubbliche (`routes/api.php`)

| Metodo | Endpoint | Note |
| :--- | :--- | :--- |
| `GET` | `/api/disciplines` | Supporta `?search=` (su `name` o `sport`) e `?sport=` (match esatto). Ordinamento per nome. |
| `GET` | `/api/disciplines/{id}` | `404` con `success: false` se la disciplina non esiste. |
| `GET` | `/api/athletes` | Include `country` e `disciplines`. |
| `GET` | `/api/athletes/{id}` | `findOrFail`: `404` se l'atleta non esiste. |

Formato di risposta uniforme: `{ "success": bool, "data": ... }`.

<br />

## 🏅 Gestione delle medaglie

L'assegnazione avviene dalla pagina **modifica disciplina**: per ogni atleta selezionato si sceglie `gold`, `silver`, `bronze` o `none`, e il valore finisce nella colonna `medal_type` della pivot `athlete_discipline`.

`DisciplineController@update` verifica che **la stessa medaglia non venga assegnata a due atleti nella stessa disciplina**: in caso di duplicato la richiesta torna indietro con `withErrors` e l'input compilato, senza salvare nulla.

Le associazioni sono gestite con `sync()`, quindi deselezionare un atleta lo rimuove dalla disciplina. All'eliminazione di una disciplina o di un atleta le relazioni vengono staccate con `detach()` e la copertina caricata viene cancellata dallo storage.

<br />

## 🗄️ Model e relazioni

- `Country` → `hasMany(Athlete)`
- `Athlete` → `belongsTo(Country)`, `belongsToMany(Discipline)` con `withPivot('medal_type')`
- `Discipline` → `belongsToMany(Athlete)` con `withPivot('medal_type')`

`Athlete` espone gli accessor `gold_count`, `silver_count`, `bronze_count`, calcolati sulla collection `disciplines` (richiedono quindi la relazione caricata).

> ⚠️ I model non dichiarano `$fillable`. Il mass assignment verrebbe scartato in silenzio: nei controller e nei seeder i campi si assegnano **uno a uno**.

<br />

## 🖼️ Upload delle immagini

Le copertine delle discipline sono salvate con `Storage::putFile('disciplines_images', ...)` sul disco configurato in `FILESYSTEM_DISK` (deve essere `public`). Nel database viene memorizzato il **percorso relativo** (es. `disciplines_images/sci-alpino.jpg`); l'URL pubblico è `{APP_URL}/storage/{cover_image}`.

<br />

## 🧪 Test

```bash
php artisan test
```

Sono presenti gli scaffold di test di Laravel Breeze in `tests/`.

<br />

## File Tree: backoffice

```
├── app
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Admin
│   │   │   │   ├── AthleteController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   └── DisciplineController.php
│   │   │   ├── Api
│   │   │   │   ├── AthleteController.php
│   │   │   │   └── DisciplineController.php
│   │   │   ├── Auth
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── ConfirmablePasswordController.php
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── Controller.php
│   │   │   └── ProfileController.php
│   │   └── Requests
│   │       ├── Auth
│   │       │   └── LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   ├── Models
│   │   ├── Athlete.php
│   │   ├── Country.php
│   │   ├── Discipline.php
│   │   └── User.php
│   └── Providers
│       └── AppServiceProvider.php
├── bootstrap
├── config
├── database
│   ├── migrations
│   └── seeders
│       ├── images
│       │   └── disciplines
│       ├── AthleteSeeder.php
│       ├── CountrySeeder.php
│       ├── DatabaseSeeder.php
│       ├── DisciplineSeeder.php
│       └── UserSeeder.php
├── public
├── resources
│   ├── js
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── scss
│   │   └── app.scss
│   └── views
│       ├── admin
│       │   ├── athletes
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── disciplines
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   └── homepage.blade.php
│       ├── auth
│       ├── layouts
│       │   ├── app.blade.php
│       │   └── guest.blade.php
│       ├── profile
│       ├── dashboard.blade.php
│       └── welcome.blade.php
├── routes
│   ├── api.php
│   ├── auth.php
│   ├── console.php
│   └── web.php
├── storage
├── tests
├── .editorconfig
├── .env.example
├── .gitattributes
├── .gitignore
├── README.md
├── artisan
├── composer.json
├── package-lock.json
├── package.json
├── phpunit.xml
└── vite.config.js
```
