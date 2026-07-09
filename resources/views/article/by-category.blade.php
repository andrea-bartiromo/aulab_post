@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Articoli della categoria: {{ $category->name }}</h1>

    <div class="row">
        @if($articles->isEmpty())
            <div class="col-md-12 text-center">
                <p class="text-muted">Nessun articolo disponibile per questa categoria.</p>
            </div>
        @else
            @foreach ($articles as $article)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        @if($article->cover_image)
                            <img src="{{ asset('storage/' . $article->cover_image) }}" class="card-img-top" alt="{{ $article->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($article->subtitle, 60) }}</p>
                            <p><small>Pubblicato il {{ $article->created_at->format('d/m/Y') }}</small></p>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-primary w-100">Leggi di più</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
