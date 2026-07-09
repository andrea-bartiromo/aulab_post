<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsOwner
{
    /**
     * Gestisce la richiesta in entrata.
     */
    public function handle(Request $request, Closure $next)
    {
        // Controlla se l'utente è autenticato e ha il ruolo di proprietario
        if (!Auth::check() || Auth::user()->is_owner != 1) {
            return redirect()->route('home')->with('error', 'Accesso negato: Solo il proprietario può accedere a questa sezione.');
        }

        return $next($request);
    }
}
