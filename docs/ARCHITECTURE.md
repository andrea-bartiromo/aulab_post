# Architettura tecnica - Aulab Post

Aulab Post è una web application sviluppata con Laravel secondo il pattern MVC.

## Stack principale

- PHP 8.2+
- Laravel 11
- Laravel Fortify
- MySQL
- Blade
- Vite
- Tailwind CSS

## Schema generale

```text
Browser
  |
  v
Laravel Routes
  |
  v
Controllers
  |
  v
Models / Policies / Middleware
  |
  v
Database MySQL
```

## Livelli applicativi

### Routes

Il file `routes/web.php` definisce le rotte principali dell'applicazione, separando:

- rotte pubbliche;
- rotte guest per login e registrazione;
- rotte protette da autenticazione;
- rotte riservate ai ruoli Admin, Revisor, Writer e Owner.

### Controllers

I controller gestiscono la logica applicativa principale:

- `PublicController` per homepage e pagine pubbliche;
- `ArticleController` per gestione e visualizzazione articoli;
- `AdminController` per dashboard e gestione ruoli;
- `RevisorController` per moderazione articoli;
- `OwnerDashboardController` per area owner;
- `JobApplicationController` per candidature.

### Middleware

L'accesso alle aree riservate è gestito tramite middleware dedicati:

- `UserIsAdmin`
- `UserIsRevisor`
- `UserIsWriter`
- `UserIsOwner`

Questa separazione consente di controllare in modo esplicito quali utenti possono accedere alle diverse aree dell'applicazione.

### Models

I model principali rappresentano le entità del dominio:

- `User`
- `Article`
- `Category`
- `JobApplication`

### Views

Le viste sono realizzate con Blade e organizzate in base alle aree funzionali:

- viste pubbliche;
- viste articoli;
- dashboard admin;
- dashboard revisore;
- dashboard owner;
- autenticazione.

## Flusso articoli

```text
Writer crea articolo
  |
  v
Articolo in attesa di revisione
  |
  v
Revisor accetta/rifiuta
  |
  v
Articolo pubblicato o respinto
```

## Flusso candidature

```text
Utente invia candidatura
  |
  v
Candidatura salvata nel database
  |
  v
Admin/Owner visualizza candidatura
  |
  v
Candidatura accettata o rifiutata
```

## Punti di forza tecnici

- Separazione dei ruoli tramite middleware.
- Uso del pattern MVC.
- Gestione CRUD degli articoli.
- Dashboard differenziate per responsabilità.
- Struttura adatta a futuri ampliamenti.

## Possibili miglioramenti architetturali

- Raggruppare i controller in sottocartelle per area funzionale.
- Aggiungere test automatici per middleware e rotte protette.
- Creare seeders demo per riprodurre velocemente un ambiente di test.
- Migliorare la gestione delle autorizzazioni tramite policy dedicate.
