<!-- resources/views/articles/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tutti gli Articoli</h1>

        <!-- Sezione per le categorie -->
        @if(isset($categories) && $categories->isNotEmpty())
            <ul>
                @foreach($categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        @else
            <p>Nessuna categoria disponibile.</p>
        @endif

        <!-- Sezione per gli articoli -->
        @if($articles->isNotEmpty())
            <ul>
                @foreach($articles as $article)
                    <li>
                        <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                        <p>{{ $article->subtitle }}</p>
                    </li>
                @endforeach
            </ul>

            {{ $articles->links() }} <!-- Paginazione -->
        @else
            <p>Non ci sono articoli disponibili.</p>
        @endif
    </div>
@endsection
