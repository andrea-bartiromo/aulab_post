<!-- resources/views/categories/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Articoli nella categoria: {{ $category->name }}</h1>

    @if($articles->count())
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
        <p>Non ci sono articoli in questa categoria.</p>
    @endif
@endsection
