<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Mostra la homepage con gli ultimi articoli pubblicati.
     */
    public function homepage()
    {
        $articles = Article::where('is_accepted', true)
                    ->orderBy('created_at', 'desc') // Ordina dal più recente al più vecchio
                    ->take(5) // Prende solo gli ultimi 5 articoli
                    ->get();
    
        $categories = Category::all(); // Recupera tutte le categorie
    
        return view('welcome', compact('articles', 'categories'));
    }
    
    /**
     * Mostra gli articoli filtrati per categoria.
     */
    public function category(Category $category)
    {
        $articles = $category->articles()->where('is_accepted', true)->latest()->paginate(6); // Solo articoli accettati
        return view('articles.index', compact('articles', 'category'));
    }
}
