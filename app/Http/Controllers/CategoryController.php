<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $articles = $category->articles()->paginate(10); // Pagina gli articoli, 10 per pagina

        return view('categories.show', compact('category', 'articles'));
    }
}
