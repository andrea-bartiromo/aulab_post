<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsRevisor
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_revisor) {
            return $next($request);
        }
        return redirect('/')->with('error', 'Accesso negato! Solo i Revisori possono accedere.');
    }
}
