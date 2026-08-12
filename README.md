# Winter Olympics Portal

Un portale completo per la gestione e la visualizzazione dei dati relativi alle Olimpiadi Invernali. Il progetto è diviso in un backoffice amministrativo e un frontoffice per l'utente finale.

Il **backoffice** (Laravel) permette a un utente autenticato di gestire discipline, atleti e assegnazione delle medaglie, ed espone i dati tramite API REST pubbliche. Il **frontoffice** (React) consuma quelle API e presenta il portale pubblico di *Milano Cortina 2026*: medagliere, catalogo discipline, schede atleta e programmazione.

<br />

## 🛠 Tech Stack

- **Backoffice:** [Laravel 11](https://laravel.com/) (PHP 8.2+), Blade, Bootstrap 5 + SASS, Vite
- **Frontoffice:** [React 19](https://reactjs.org/) con [Vite 7](https://vite.dev/), React Router 7, Axios, Bootstrap 5 + CSS Modules
- **Database:** MySQL
- **Autenticazione:** Laravel Breeze (Blade) — solo lato backoffice
- **Storage immagini:** disco `public` di Laravel (`storage/app/public` → `public/storage`)

<br />

## 🚀 Struttura del Progetto

Il repository è organizzato come segue:
- `/backoffice`: API REST, pannello amministrativo e logica di business in Laravel.
- `/frontend`: interfaccia utente pubblica sviluppata in React.
- `/screenshots`: immagini dell'interfaccia usate in questa documentazione.

Ogni sottocartella ha un proprio README con l'albero dei file e le note specifiche:
- [`backoffice/README.md`](./backoffice/README.md)
- [`frontend/README.md`](./frontend/README.md)

<br />

## ✅ Prerequisiti

- PHP >= 8.2 con le estensioni richieste da Laravel
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/) >= 20 e npm
- MySQL (o MariaDB) in esecuzione

<br />

## ⚙️ Installazione

Il progetto richiede **due processi attivi contemporaneamente**: il server Laravel (porta `8000`) e il dev server Vite del frontend (porta `5173`).

### 1. Clonare il repository

```bash
git clone <url-del-repository>
cd winter-olympics-portal
```

### 2. Backoffice (Laravel)

```bash
cd backoffice

# Dipendenze
composer install
npm install

# Configurazione
cp .env.example .env
php artisan key:generate
```

Aprire il file `.env` e configurare la connessione al database (creare prima il database vuoto in MySQL):

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=winter_olympics
DB_USERNAME=root
DB_PASSWORD=

# Deve restare "public": le copertine delle discipline vengono servite via /storage
FILESYSTEM_DISK=public

# Origine autorizzata per le richieste CORS provenienti dal frontend React
APP_FRONTEND_URL=http://localhost:5173
```

> ℹ️ **CORS:** `config/cors.php` autorizza l'origine indicata da `APP_FRONTEND_URL` (default `http://localhost:5173/`). Se il frontend gira su un'altra porta va aggiornata questa variabile, altrimenti le chiamate API verranno bloccate dal browser.

Creare il link simbolico per lo storage pubblico, eseguire le migrazioni e popolare il database:

```bash
php artisan storage:link
php artisan migrate --seed
```

Avviare il server:

```bash
php artisan serve      # http://127.0.0.1:8000
npm run dev            # asset del backoffice (Blade), in un secondo terminale
```

### 3. Frontend (React)

```bash
cd frontend

npm install
cp .env.example .env
npm run dev            # http://localhost:5173
```

Il file `.env` contiene l'URL base del backoffice, usato sia per le API sia per le immagini:

```dotenv
VITE_API_URL=http://127.0.0.1:8000
```

Le variabili Vite vengono lette a build time: dopo una modifica del `.env` è necessario riavviare `npm run dev`.

<br />

## 🌱 Seeding del database

`php artisan db:seed` popola il database in questo ordine (`DatabaseSeeder`):

| Seeder | Cosa crea |
| :--- | :--- |
| `UserSeeder` | Utente di servizio per accedere al backoffice. Se l'account esiste già non viene toccato. |
| `CountrySeeder` | 19 nazioni con codice ISO 3166-1 alpha-2 (usato dal frontend per le bandiere). |
| `DisciplineSeeder` | 15 discipline con descrizione e copertina. Copia le immagini versionate in `database/seeders/images/disciplines` dentro `storage/app/public/disciplines_images`. |
| `AthleteSeeder` | Atleti collegati a nazione e discipline, con il tipo di medaglia sulla tabella pivot. |

I seeder sono **idempotenti**: cercano il record esistente prima di crearlo, quindi possono essere rieseguiti senza duplicare i dati.

**Credenziali di accesso al backoffice** (create da `UserSeeder`):

| Email | Password |
| :--- | :--- |
| `miche@test.com` | `password` |

> ⚠️ Sono credenziali di sviluppo. Vanno cambiate o rimosse in qualsiasi ambiente non locale.

Per ripartire da zero (attenzione: cancella tutti i dati):

```bash
php artisan migrate:fresh --seed
```

<br />

## 🖼️ Interfaccia Utente (UI)

In questa sezione vengono descritte le principali schermate del portale **Milano Cortina 2026**, che collegano il frontoffice React ai dati gestiti dal backoffice Laravel.

### 1. Homepage: Stati e Visualizzazioni
La schermata iniziale gestisce dinamicamente il caricamento dei dati e permette di switchare tra diverse visualizzazioni del medagliere.

| Homepage (Loader) | Homepage (Medagliere Nazioni) | Homepage (Medagliere Atleti) |
| :--- | :--- | :--- |
| ![Loader](./screenshots/HomepageLoader.png) | ![Medagliere Nazioni](./screenshots/HomepageCountries.png) | ![Medagliere Atleti](./screenshots/HomepageAthletes.png) |
| **Stato iniziale:** Feedback visivo durante il fetching delle API. | **Vista Nazioni:** Classifica aggregata per Paese (Oro, Argento, Bronzo). | **Vista Atleti:** Ranking basato sulle prestazioni individuali. |

---

### 2. Directory delle Discipline
Pagina di catalogo che elenca tutti gli sport invernali gestiti dal sistema.

| Anteprima Interfaccia | Descrizione e Funzionalità |
| :--- | :--- |
| ![Directory Discipline](./screenshots/Disciplines.png) | **Caratteristiche:** <br> &bull; Filtro di ricerca testuale dinamico. <br> &bull; Filtro per categoria (es. Sci, Pattinaggio). <br> &bull; Card con contatore atleti in tempo reale. |

---

### 3. Dettaglio Disciplina e Partecipanti
Visualizzazione specifica per ogni sport, con focus sui protagonisti e i risultati.

| Anteprima Interfaccia | Dettagli Tecnici |
| :--- | :--- |
| ![Single Discipline](./screenshots/SingleDiscipline.png) | **Contenuti:** <br> &bull; Descrizione tecnica della disciplina. <br> &bull; Elenco atleti partecipanti con badge nazione. <br> &bull; Visualizzazione podio (Oro, Argento, Bronzo). |

---

### 4. Profilo Atleta e Palmarès
Pagina di dettaglio dedicata ai singoli atleti e alla loro storia olimpica.

| Anteprima Interfaccia | Informazioni Gestite |
| :--- | :--- |
| ![Single Athlete](./screenshots/SingleAthlete.png) | **Dati Biografici:** <br> &bull; Conteggio totale medaglie vinte. <br> &bull; Biografia estesa e data di nascita. <br> &bull; **Timeline:** Elenco di tutte le gare disputate e risultati ottenuti. |

<br />

## 🔐 Backoffice amministrativo

Il pannello è raggiungibile su `http://127.0.0.1:8000` ed è protetto da autenticazione (Laravel Breeze). Tutte le rotte di gestione richiedono i middleware `auth` e `verified`.

| Area | Rotta | Funzionalità |
| :--- | :--- | :--- |
| Dashboard | `/admin` | Homepage amministrativa con riepilogo e accessi rapidi. |
| Discipline | `/disciplines` | CRUD completo, upload copertina, ricerca testuale e filtro per sport. |
| Atleti | `/athletes` | CRUD completo, elenco raggruppato per nazione, associazione alle discipline. |
| Profilo | `/profile` | Gestione dell'account autenticato. |

**Assegnazione delle medaglie:** avviene dalla pagina di modifica della disciplina, scegliendo per ogni atleta associato il valore `gold`, `silver`, `bronze` o `none`. Un controllo di validazione impedisce di assegnare **la stessa medaglia a più atleti nella stessa disciplina**: in caso di duplicato l'operazione viene annullata e viene mostrato un messaggio di errore.

<br />

## 🔌 API REST

Le API sono pubbliche (nessuna autenticazione richiesta) e restituiscono sempre JSON con la stessa struttura:

```json
{
  "success": true,
  "data": { }
}
```

| Metodo | Endpoint | Descrizione |
| :--- | :--- | :--- |
| `GET` | `/api/disciplines` | Elenco discipline ordinate per nome, con atleti e relative nazioni. |
| `GET` | `/api/disciplines/{id}` | Dettaglio disciplina con atleti e nazioni. `404` con `success: false` se non esiste. |
| `GET` | `/api/athletes` | Elenco atleti con nazione e discipline. |
| `GET` | `/api/athletes/{id}` | Dettaglio del singolo atleta. |

**Parametri di query su `/api/disciplines`:**

| Parametro | Esempio | Effetto |
| :--- | :--- | :--- |
| `search` | `?search=sci` | Filtro testuale su `name` **oppure** `sport`. |
| `sport` | `?sport=Pattinaggio` | Filtro esatto per categoria di sport. |

I due parametri sono combinabili: `GET /api/disciplines?search=alpino&sport=Sci`.

Nelle risposte, la relazione molti-a-molti espone il tipo di medaglia nell'oggetto `pivot`:

```json
{
  "id": 1,
  "name": "Sci Alpino",
  "sport": "Sci",
  "cover_image": "disciplines_images/sci-alpino.jpg",
  "athletes": [
    {
      "id": 1,
      "first_name": "Matteo",
      "last_name": "Bordignon",
      "country": { "id": 1, "name": "Italia", "code": "IT" },
      "pivot": { "medal_type": "gold" }
    }
  ]
}
```

Il campo `cover_image` è un percorso **relativo** al disco `public`: l'URL completo si ottiene come `{VITE_API_URL}/storage/{cover_image}` (nel frontend lo costruisce l'helper `storageUrl()` in `src/config.js`).

<br />

## 🗄️ Struttura del Database

| Tabella | Campi principali | Note |
| :--- | :--- | :--- |
| `countries` | `name`, `code` | `code` è ISO 3166-1 alpha-2 maiuscolo (`IT`, `FR`, ...), usato per le bandiere. |
| `disciplines` | `name`, `sport`, `description`, `cover_image` | `sport` è la macro-categoria (Sci, Pattinaggio, Bob...). |
| `athletes` | `first_name`, `last_name`, `birth_date`, `bio`, `country_id` | FK verso `countries`. |
| `athlete_discipline` | `athlete_id`, `discipline_id`, `medal_type` | Pivot molti-a-molti. `medal_type` è un enum: `gold`, `silver`, `bronze`, `none`. |
| `users` | `name`, `email`, `password` | Accesso al backoffice (Breeze). |

**Relazioni Eloquent:**
- `Country` → `hasMany(Athlete)`
- `Athlete` → `belongsTo(Country)` e `belongsToMany(Discipline)` con `withPivot('medal_type')`
- `Discipline` → `belongsToMany(Athlete)` con `withPivot('medal_type')`

Il model `Athlete` espone anche gli accessor `gold_count`, `silver_count` e `bronze_count`, che contano le medaglie a partire dalla pivot.

> ⚠️ I model **non dichiarano `$fillable`**: il mass assignment verrebbe scartato silenziosamente, quindi i campi vanno assegnati uno a uno (è la convenzione seguita da controller e seeder).

<br />

## 🧭 Rotte del Frontoffice

| Rotta | Pagina | Contenuto |
| :--- | :--- | :--- |
| `/` | `Homepage` | Hero, news ticker, medagliere (nazioni/atleti), programma discipline. |
| `/programmazione` | `Programmazione` | Calendario/programma delle discipline. |
| `/discipline` | `Discipline` | Catalogo con ricerca e filtro per sport, persistiti nella query string. |
| `/discipline/:id` | `SingleDiscipline` | Dettaglio disciplina, elenco partecipanti e podio. |
| `/atleti/:id` | `SingleAthlete` | Scheda atleta, palmarès e storico gare. |

<br />

## 📝 Note e limitazioni note

- Le bandiere delle nazioni sono caricate da servizi esterni (`flagcdn.com` e `flagsapi.com`): senza connessione a internet non vengono mostrate.
- Il medagliere in homepage attende volutamente ~6 secondi prima di mostrare i dati, per lasciare visibile l'animazione di caricamento.
- Le API sono in sola lettura: ogni modifica ai dati passa dal backoffice autenticato.
- Il progetto è pensato per l'esecuzione in locale; per un deploy reale vanno rivisti `APP_ENV`, `APP_DEBUG`, le credenziali del seeder e la configurazione CORS.
