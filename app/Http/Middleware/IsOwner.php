<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsOwner
{
    /**
     * Gestisce l'accesso alla Dashboard del Proprietario.
     */
    public function handle(Request $request, Closure $next)
    {
        // Controlla se l'utente è autenticato e ha il ruolo di proprietario o admin
        if (Auth::check() && (Auth::user()->is_owner || Auth::user()->is_admin)) {
            return $next($request);
        }

        // Se non ha i permessi, lo reindirizza alla home con un messaggio di errore
        return redirect('/')->with('error', 'Accesso negato: non hai i permessi per visualizzare questa pagina.');
    }
}
