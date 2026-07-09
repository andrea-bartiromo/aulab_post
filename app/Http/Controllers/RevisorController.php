<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisorController extends Controller
{
    /**
     * Mostra la dashboard con gli articoli in attesa di revisione
     */
    public function index()
    {
        $articles = Article::whereNull('is_accepted')->latest()->get();
        return view('revisor.dashboard', compact('articles'));
    }

    /**
     * Mostra il dettaglio di un articolo
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Accetta un articolo e lo pubblica
     */
    public function accept($id)
    {
        $article = Article::findOrFail($id);

        // Controllo per evitare che un utente non revisore acceda
        if (!Auth::user()->is_revisor) {
            return redirect()->route('home')->with('error', 'Accesso non autorizzato.');
        }

        $article->update(['is_accepted' => true]);
        return redirect()->route('revisor.dashboard')->with('success', 'Articolo accettato con successo.');
    }

    /**
     * Rifiuta un articolo e lo segna come non accettato
     */
    public function reject($id)
    {
        $article = Article::findOrFail($id);

        // Controllo per evitare che un utente non revisore acceda
        if (!Auth::user()->is_revisor) {
            return redirect()->route('home')->with('error', 'Accesso non autorizzato.');
        }

        $article->update(['is_accepted' => false]);
        return redirect()->route('revisor.dashboard')->with('error', 'Articolo rifiutato.');
    }
}
