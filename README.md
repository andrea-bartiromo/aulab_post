# Aulab Post

Aulab Post è una piattaforma web sviluppata in **Laravel** come progetto finale del percorso Hackademy/Aulab.  
L'applicazione simula un portale editoriale con gestione degli articoli, autenticazione utenti, ruoli autorizzativi e dashboard dedicate.

## Obiettivo del progetto

Il progetto nasce per mettere in pratica le competenze acquisite nello sviluppo full stack con Laravel, creando un'applicazione completa con:

- autenticazione e registrazione utenti;
- gestione articoli;
- sistema di revisione dei contenuti;
- ruoli multipli;
- dashboard amministrative;
- candidature tramite sezione "Lavora con noi";
- gestione permessi tramite middleware.

## Funzionalità principali

### Utenti e autenticazione

- Registrazione e login tramite Laravel Fortify.
- Logout protetto per utenti autenticati.
- Accesso differenziato in base al ruolo.

### Gestione articoli

- Creazione di nuovi articoli da parte degli utenti autenticati.
- Visualizzazione pubblica degli articoli.
- Dettaglio articolo.
- Filtri per categoria e autore.
- Modifica ed eliminazione degli articoli da parte degli utenti autorizzati.

### Sistema di revisione

- Dashboard dedicata al revisore.
- Possibilità di accettare o rifiutare gli articoli.
- Separazione tra contenuti pubblicati e contenuti in attesa di revisione.

### Area amministratore

- Dashboard admin.
- Assegnazione e rimozione ruoli.
- Gestione utenti.
- Gestione candidature ricevute dalla sezione "Lavora con noi".

### Area owner

- Dashboard dedicata al proprietario.
- Visualizzazione delle candidature.
- Accettazione o rifiuto delle candidature.

### Sezione Lavora con noi

- Form pubblico per l'invio di candidature.
- Gestione delle candidature da pannello admin/owner.

## Tecnologie utilizzate

- **PHP 8.2+**
- **Laravel 11**
- **Laravel Fortify**
- **MySQL**
- **Blade**
- **Vite**
- **Tailwind CSS**
- **JavaScript**
- **Composer**
- **NPM**

## Struttura tecnica

Il progetto segue l'architettura MVC tipica di Laravel:

- `app/Http/Controllers` contiene i controller principali dell'applicazione.
- `app/Http/Middleware` gestisce i controlli sui ruoli utente.
- `app/Models` contiene i model principali: utenti, articoli, categorie e candidature.
- `database/migrations` contiene la struttura del database.
- `resources/views` contiene le viste Blade.
- `routes/web.php` definisce le rotte pubbliche, protette e divise per ruolo.

## Ruoli gestiti

L'applicazione prevede più livelli di autorizzazione:

- **Admin**: gestione utenti, ruoli e candidature.
- **Revisor**: revisione e moderazione articoli.
- **Writer**: creazione, modifica ed eliminazione dei propri articoli.
- **Owner**: gestione avanzata delle candidature.
- **Utente registrato**: accesso alle funzionalità base e candidatura.

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

Avviare il server Laravel:

```bash
php artisan serve
```

In un secondo terminale avviare Vite:

```bash
npm run dev
```

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

## Stato del progetto

Il progetto è funzionante in ambiente locale ed è stato sviluppato a scopo formativo come progetto finale del percorso Hackademy/Aulab.

## Miglioramenti futuri

- Aggiungere screenshot dell'applicazione.
- Migliorare la UI delle dashboard.
- Aggiungere test automatici.
- Aggiungere seeders dimostrativi per utenti e ruoli.
- Documentare le credenziali demo in ambiente locale.

## Autore

**Andrea Bartiromo**  
GitHub: [andrea-bartiromo](https://github.com/andrea-bartiromo)
