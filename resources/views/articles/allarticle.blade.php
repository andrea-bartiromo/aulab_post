@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Tutti gli Articoli</h1>

    @if($articles->isEmpty())
        <div class="text-center">
            <p class="text-muted">Nessun articolo disponibile al momento.</p>
        </div>
    @else
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Controllo se l'articolo ha un'immagine -->
                        @if($article->cover_image && file_exists(public_path('storage/' . $article->cover_image)))
                            <img src="{{ asset('storage/' . $article->cover_image) }}" class="card-img-top" alt="{{ $article->title }}">
                        @else
                            <img src="{{ asset('images/default-image.jpg') }}" class="card-img-top" alt="Immagine non disponibile">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($article->subtitle, 60) }}</p>

                            <!-- Categoria -->
                            @if (!is_null($article->category))
                                <p><strong>Categoria:</strong> 
                                    <a href="{{ route('article.byCategory', ['category' => $article->category->id]) }}" class="text-primary">
                                        {{ $article->category->name }}
                                    </a>
                                </p>
                            @endif

                            <!-- Autore -->
                            @if (!is_null($article->user))
                                <p><strong>Autore:</strong> 
                                    <a href="{{ route('article.byUser', ['user' => $article->user->id]) }}" class="text-primary">
                                        {{ $article->user->name }}
                                    </a>
                                </p>
                            @endif

                            <p><small>Pubblicato il {{ $article->created_at->format('d/m/Y') }}</small></p>

                            <a href="{{ route('articles.show', $article) }}" class="btn btn-primary w-100">Leggi di più</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginazione -->
        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
