<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Titolo dell'articolo
            $table->text('subtitle'); // Sottotitolo dell'articolo
            $table->longText('body'); // Contenuto dell'articolo
            $table->string('cover_image')->nullable(); // Immagine di copertina (opzionale)
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Relazione con categorie
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relazione con utenti
            $table->boolean('is_accepted')->nullable(); // Stato di accettazione
            $table->timestamps(); // Date di creazione e aggiornamento
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
