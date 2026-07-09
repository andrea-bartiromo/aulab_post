<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Mostra tutti gli articoli pubblicati.
     */
    public function index()
    {
        $articles = Article::where('is_accepted', true)->latest()->paginate(6);
        $categories = Category::all();

        return view('articles.allarticle', compact('articles', 'categories'));
    }

    /**
     * Mostra la pagina di creazione di un nuovo articolo.
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Salva un nuovo articolo nel database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'body' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->subtitle = $request->subtitle;
        $article->body = $request->body;
        $article->category_id = $request->category_id;
        $article->user_id = Auth::id();

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('cover_images', 'public');
            $article->cover_image = $path;
        }

        $article->save();

        return redirect()->route('articles.index')->with('success', 'Articolo pubblicato con successo!');
    }

    /**
     * Mostra un articolo specifico.
     */
    public function show(Article $article)
    {
        if (!$article->is_accepted) {
            abort(403, 'Articolo non disponibile.');
        }
        return view('articles.show', compact('article'));
    }

    /**
     * Mostra il form per modificare un articolo (Solo per il writer specifico).
     */
    public function edit(Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            return redirect()->route('articles.index')->with('error', 'Non sei autorizzato a modificare questo articolo.');
        }

        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    /**
     * Aggiorna un articolo esistente (Solo per il writer specifico).
     */
    public function update(Request $request, Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            return redirect()->route('articles.index')->with('error', 'Non sei autorizzato a modificare questo articolo.');
        }

        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'subtitle' => 'required|string|max:255',
        //     'body' => 'required|string',
        //     'cover_image' => 'nullable|image|max:2048',
        //     'category_id' => 'required|exists:categories,id',
        // ]);

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::delete('public/' . $article->cover_image);
            }
            $article->cover_image = $request->file('cover_image')->store('cover_images', 'public');
        }

        $article->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $request->body,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('articles.index')->with('success', 'Articolo aggiornato con successo.');
    }

    /**
     * Elimina un articolo (Solo per il writer specifico).
     */
    public function destroy(Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            return redirect()->route('articles.index')->with('error', 'Non sei autorizzato a eliminare questo articolo.');
        }

        if ($article->cover_image) {
            Storage::delete('public/' . $article->cover_image);
        }

        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Articolo eliminato.');
    }

    /**
     * Mostra gli articoli per categoria.
     */
    public function byCategory($id)
    {
        $category = Category::findOrFail($id);
        $articles = $category->articles()
            ->where('is_accepted', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('article.by-category', compact('articles', 'category'));
    }

    /**
     * Mostra gli articoli per utente.
     */
    public function byUser($id)
    {
        $user = User::findOrFail($id);
        $articles = $user->articles()
            ->where('is_accepted', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('articles.by-user', compact('articles', 'user'));
    }

    /**
     * Mostra tutti gli articoli disponibili.
     */
    public function allArticles()
    {
        $articles = Article::where('is_accepted', true)->orderBy('created_at', 'desc')->paginate(10);
        return view('articles.allarticle', compact('articles'));
    }
}
