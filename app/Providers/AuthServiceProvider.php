<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\User;
use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * La mappa delle policy per l'applicazione.
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Registra qualsiasi servizio di autenticazione / autorizzazione.
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_owner', function (?User $user) {
            return $user && $user->is_owner == 1;
        });

        Gate::define('is_admin', function (?User $user) {
            return $user && $user->is_admin == 1;
        });

        Gate::define('is_writer', function (?User $user) {
            return $user && $user->is_writer == 1;
        });

        Gate::define('is_revisor', function (?User $user) {
            return $user && $user->is_revisor == 1;
        });
    }
}
