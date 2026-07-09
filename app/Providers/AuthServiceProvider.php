<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * La mappa delle policy per l'applicazione.
     */
    protected $policies = [
        Article::class => ArticlePolicy::class, // Associazione tra modello e policy
    ];

    /**
     * Registra qualsiasi servizio di autenticazione / autorizzazione.
     */
    public function boot()
    {
        $this->registerPolicies();

        //  Definizione di un Gate per il proprietario (owner)
        Gate::define('is_owner', function (?User $user) {
            return $user && $user->is_owner == 1;
        });

        //  Definizione di un Gate per l'admin
        Gate::define('is_admin', function (?User $user) {
            return $user && $user->is_admin == 1;
        });

        //  Definizione di un Gate per il writer
        Gate::define('is_writer', function (?User $user) {
            return $user && $user->is_writer == 1;
        });

        // Definizione di un Gate per il revisore
        Gate::define('is_revisor', function (?User $user) {
            return $user && $user->is_revisor == 1;
        });

        //  Permesso per modificare un articolo (solo se l'utente è il proprietario dell'articolo)
        Gate::define('update-article', function (?User $user, Article $article) {
            return $user && $user->id === $article->user_id;
        });

        //  Permesso per eliminare un articolo (solo se l'utente è il proprietario dell'articolo)
        Gate::define('delete-article', function (?User $user, Article $article) {
            return $user && $user->id === $article->user_id;
        });
    }
}
