# Frontend — Winter Olympics Portal

Portale pubblico di *Milano Cortina 2026*, sviluppato in **React 19 + Vite 7**. Consuma le API REST esposte dal backoffice Laravel in [`../backoffice`](../backoffice) e ne mostra medagliere, discipline, atleti e programmazione.

Per le istruzioni di installazione complete (backoffice + frontend) vedi il [README principale](../README.md).

<br />

## ⚡ Avvio rapido

```bash
npm install
cp .env.example .env
npm run dev            # http://localhost:5173
```

> Il backoffice Laravel deve essere in esecuzione su `http://127.0.0.1:8000`, altrimenti le pagine restano vuote e in console compaiono errori di rete.

### Script disponibili

| Comando | Descrizione |
| :--- | :--- |
| `npm run dev` | Dev server Vite con hot reload. |
| `npm run build` | Build di produzione in `dist/`. |
| `npm run preview` | Anteprima locale della build. |
| `npm run lint` | ESLint su tutto il progetto. |

<br />

## ⚙️ Configurazione

Tutte le chiamate passano da `src/config.js`, che legge l'URL base del backoffice dalle variabili d'ambiente Vite:

```dotenv
# .env
VITE_API_URL=http://127.0.0.1:8000
```

```js
import { apiUrl, storageUrl } from "../config";

apiUrl("/disciplines");                 // http://127.0.0.1:8000/api/disciplines
storageUrl("disciplines_images/x.jpg"); // http://127.0.0.1:8000/storage/disciplines_images/x.jpg
```

- `apiUrl(path)` — costruisce l'endpoint API (prefisso `/api` incluso).
- `storageUrl(path)` — costruisce l'URL di un'immagine caricata dal backoffice, a partire dal percorso relativo salvato in `cover_image`.

Se `VITE_API_URL` non è definita si usa il default `http://127.0.0.1:8000`. Eventuali slash finali vengono rimossi automaticamente.

> ⚠️ Le variabili Vite sono lette all'avvio: dopo aver modificato il `.env` bisogna riavviare `npm run dev`.
>
> ⚠️ Cambiare la porta del dev server richiede di aggiornare `APP_FRONTEND_URL` nel `.env` del backoffice, altrimenti il CORS blocca le richieste.

Il file `.env` è ignorato da git; `.env.example` è la versione versionata da copiare.

<br />

## 🧭 Rotte

Definite in `src/App.jsx`, tutte dentro `DefaultLayout` (header + footer condivisi).

| Rotta | Pagina | Contenuto |
| :--- | :--- | :--- |
| `/` | `Homepage` | Hero, news ticker, medagliere, programma discipline, sezione notizie. |
| `/programmazione` | `Programmazione` | Elenco delle discipline in programma. |
| `/discipline` | `Discipline` | Catalogo con ricerca e filtro per sport. |
| `/discipline/:id` | `SingleDiscipline` | Dettaglio disciplina, partecipanti e podio. |
| `/atleti/:id` | `SingleAthlete` | Scheda atleta, medagliere personale e gare disputate. |

<br />

## 🧩 Componenti principali

| Componente | Ruolo |
| :--- | :--- |
| `MedalTracker` | Medagliere della homepage. Scarica le discipline, aggrega le medaglie per **nazione** e per **atleta** e permette di alternare le due viste. |
| `OlympicLoader` | Animazione a cerchi olimpici mostrata durante il fetch dei dati. |
| `Hero` | Sezione di apertura della homepage. |
| `NewsTicker` | Striscia di aggiornamenti scorrevole. |
| `Notizie` | Carosello di notizie (contenuti statici definiti nel componente). |
| `ProgrammaDiscipline` | Blocco di navigazione rapida verso le sezioni del portale. |
| `Header` / `Footer` | Navigazione principale e piè di pagina, usati da `DefaultLayout`. |

Lo styling combina **Bootstrap 5** (layout e utility) e **CSS Modules** per gli stili specifici di ogni componente/pagina.

<br />

## 🔄 Pattern di data fetching

Le pagine seguono uno schema uniforme con Axios dentro `useEffect`:

```jsx
useEffect(() => {
  axios
    .get(apiUrl("/disciplines"))
    .then((response) => {
      if (response.data.success) setDisciplines(response.data.data);
    })
    .catch((err) => console.error("Errore API:", err))
    .finally(() => setLoading(false));
}, []);
```

Note utili:
- La risposta API ha sempre forma `{ success, data }`: il flag `success` va controllato prima di leggere `data`.
- Finché `loading` è `true` viene mostrato `OlympicLoader`.
- In `MedalTracker` il caricamento è volutamente allungato a ~6 secondi (`Promise.all` tra fetch e timer) per lasciare visibile l'animazione.

**Filtri della pagina Discipline:** ricerca testuale e filtro per sport sono salvati nella query string tramite `useSearchParams` (es. `/discipline?search=sci&sport=Sci`), così i filtri restano nell'URL e sopravvivono al refresh o alla condivisione del link. L'elenco degli sport disponibili è ricavato dai dati ricevuti; il filtraggio avviene lato client.

<br />

## 🖼️ Immagini e bandiere

- **Copertine delle discipline:** servite dal backoffice, URL costruito con `storageUrl(d.cover_image)`. Richiedono `php artisan storage:link` e `FILESYSTEM_DISK=public` lato Laravel.
- **Bandiere:** caricate da servizi esterni a partire dal codice ISO della nazione — `flagcdn.com` (`SingleAthlete`, `SingleDiscipline`, medagliere atleti) e `flagsapi.com` (medagliere nazioni). Senza connessione a internet non vengono mostrate.

<br />

## 📦 Dipendenze principali

| Pacchetto | Uso |
| :--- | :--- |
| `react`, `react-dom` 19 | Libreria UI. |
| `react-router-dom` 7 | Routing e gestione della query string. |
| `axios` | Chiamate HTTP alle API. |
| `bootstrap`, `bootstrap-icons` | Layout, componenti di base e icone. |
| `vite`, `@vitejs/plugin-react` | Dev server e build. |
| `eslint` + plugin React | Linting. |

<br />

## File Tree: frontend

```
├── public
│   ├── assets
│   └── vite.svg
├── src
│   ├── assets
│   ├── components
│   │   ├── Footer
│   │   │   ├── Footer.jsx
│   │   │   └── Footer.module.css
│   │   ├── Header
│   │   │   ├── Header.jsx
│   │   │   └── Header.module.css
│   │   ├── Hero
│   │   │   ├── Hero.jsx
│   │   │   └── Hero.module.css
│   │   ├── MedalTracker
│   │   │   ├── MedalTracker.jsx
│   │   │   └── MedalTraker.module.css
│   │   ├── NewsTicker
│   │   │   ├── NewsTicker.jsx
│   │   │   └── NewsTicker.module.css
│   │   ├── Notizie
│   │   │   ├── Notizie.jsx
│   │   │   └── Notizie.module.css
│   │   ├── OlymplicLoader
│   │   │   ├── OlympicLoader.jsx
│   │   │   └── OlympicLoader.module.css
│   │   └── ProgrammaDiscipline
│   │       └── ProgrammaDiscipline.jsx
│   ├── layouts
│   │   └── DefaultLayout.jsx
│   ├── pages
│   │   ├── Discipline.jsx
│   │   ├── Discipline.module.css
│   │   ├── Homepage.jsx
│   │   ├── Programmazione.jsx
│   │   ├── Programmazione.module.css
│   │   ├── SingleAthlete.jsx
│   │   ├── SingleAthlete.module.css
│   │   ├── SingleDiscipline.jsx
│   │   └── SingleDiscipline.module.css
│   ├── App.css
│   ├── App.jsx
│   ├── config.js
│   ├── index.css
│   └── main.jsx
├── .env.example
├── .gitignore
├── README.md
├── eslint.config.js
├── index.html
├── package-lock.json
├── package.json
└── vite.config.js
```
