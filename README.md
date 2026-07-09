# Aulab Post

![Laravel](https://img.shields.io/badge/Laravel-11-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![MySQL](https://img.shields.io/badge/Database-MySQL-orange)
![Blade](https://img.shields.io/badge/Template-Blade-purple)
![Vite](https://img.shields.io/badge/Build-Vite-646CFF)
![Tailwind CSS](https://img.shields.io/badge/CSS-Tailwind-38B2AC)

**Aulab Post** è una piattaforma web editoriale sviluppata in **Laravel** come progetto finale del percorso Hackademy/Aulab.

L'applicazione simula un portale di pubblicazione articoli con autenticazione, ruoli autorizzativi, dashboard dedicate, sistema di revisione dei contenuti e gestione candidature.

---

## Screenshot

### Homepage

![Homepage](docs/images/home.jpg)

### Login

![Login](docs/images/login.jpg)

### Creazione articolo

![Creazione articolo](docs/images/creazione-articolo.jpg)

### Dashboard amministratore

![Dashboard amministratore](docs/images/dashboard-admin.jpg)

### Dashboard revisore

![Dashboard revisore](docs/images/dashboard-revisore.jpg)

### Dettaglio articolo

![Dettaglio articolo](docs/images/dettaglio-articolo.jpg)

---

## Highlights

- Autenticazione utenti tramite Laravel Fortify.
- Gestione articoli con creazione, dettaglio, modifica ed eliminazione.
- Sistema di revisione con accettazione o rifiuto dei contenuti.
- Dashboard amministratore per utenti, ruoli e candidature.
- Dashboard revisore per moderazione articoli.
- Ruoli multipli: Admin, Revisor, Writer, Owner e utente registrato.
- Middleware dedicati per proteggere le aree riservate.
- Sezione “Lavora con noi” con gestione candidature.

---

## Obiettivo del progetto

Il progetto nasce per mettere in pratica le competenze acquisite nello sviluppo full stack con Laravel, realizzando un'applicazione completa e strutturata secondo il pattern MVC.

Aulab Post non è solo un esercizio CRUD: include un flusso editoriale con utenti, ruoli, revisione contenuti e pannelli di gestione differenziati.

---

## Workflow articoli

```text
Writer crea articolo
        ↓
Articolo in attesa di revisione
        ↓
Revisor accetta o rifiuta
        ↓
Articolo pubblicato oppure respinto
```

---

## Architettura logica

```text
Browser
  ↓
Laravel Routes
  ↓
Controllers
  ↓
Models / Middleware
  ↓
Database MySQL
```

---

## Tecnologie utilizzate

- PHP 8.2+
- Laravel 11
- Laravel Fortify
- MySQL
- Blade
- Vite
- Tailwind CSS
- JavaScript
- Composer
- NPM

---

## Struttura tecnica

```text
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Models/

database/
├── migrations/

resources/
├── views/

routes/
└── web.php
```

---

## Ruoli gestiti

- **Admin**: gestione utenti, ruoli e candidature.
- **Revisor**: revisione e moderazione articoli.
- **Writer**: creazione, modifica ed eliminazione dei propri articoli.
- **Owner**: gestione avanzata delle candidature.
- **Utente registrato**: accesso alle funzionalità base e candidatura.

---

## Installazione locale

Clonare il repository:

```bash
git clone https://github.com/andrea-bartiromo/aulab_post.git
cd aulab_post
```

Installare le dipendenze PHP:

```bash
composer install
```

Installare le dipendenze frontend:

```bash
npm install
```

Creare il file `.env`:

```bash
cp .env.example .env
```

Generare la chiave applicativa:

```bash
php artisan key:generate
```

Configurare il database nel file `.env`, poi eseguire le migrazioni:

```bash
php artisan migrate
```

Avviare Laravel:

```bash
php artisan serve
```

In un secondo terminale avviare Vite:

```bash
npm run dev
```

---

## Note sul database

Il progetto utilizza MySQL. Prima di avviare l'applicazione è necessario creare un database locale e configurare correttamente queste variabili nel file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_database
DB_USERNAME=root
DB_PASSWORD=
```

---

## Documentazione tecnica

È presente anche una documentazione dedicata all'architettura:

[docs/ARCHITECTURE.md](docs/ARCHITECTURE.md)

---

## Stato del progetto

Il progetto è funzionante in ambiente locale ed è stato sviluppato a scopo formativo come progetto finale del percorso Hackademy/Aulab.

---

## Miglioramenti futuri

- Migliorare la UI delle dashboard.
- Aggiungere test automatici.
- Aggiungere seeders dimostrativi per utenti e ruoli.
- Documentare credenziali demo per ambiente locale.
- Aggiungere deploy dimostrativo.

---

## Autore

**Andrea Bartiromo**  
GitHub: [andrea-bartiromo](https://github.com/andrea-bartiromo)
