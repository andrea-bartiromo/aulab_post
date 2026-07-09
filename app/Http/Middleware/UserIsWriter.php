<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsWriter
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_writer) {
            return $next($request);
        }
        return redirect('/')->with('error', 'Accesso negato! Solo i Writers possono accedere.');
    }
}
