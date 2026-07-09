@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                
                <!-- Sezione immagine di copertina -->
                @if($article->cover_image)
                    <img src="{{ asset('storage/' . $article->cover_image) }}" class="card-img-top" alt="{{ $article->title }}">
                @endif
                
                <div class="card-body">
                    <h1 class="card-title">{{ $article->title }}</h1>
                    <h5 class="text-muted">{{ $article->subtitle }}</h5>
                    <p><strong>Categoria:</strong> {{ $article->category->name ?? 'Senza categoria' }}</p>
                    <p><strong>Autore:</strong> {{ $article->user->name }}</p>
                    <p class="text-muted"><small>Pubblicato il {{ $article->created_at->format('d/m/Y') }}</small></p>
                    
                    <hr>
                    
                    <!-- Contenuto dell'articolo -->
                    <p class="article-content">{{ $article->body }}</p>
                    
                    <hr>

                    <!-- Sezione per Writer: Modifica e Cancella -->
                    @auth
                        @if(Auth::id() === $article->user_id)
                            <div class="d-flex justify-content-between mb-3">
                                <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Modifica
                                </a>
                                
                                <form action="{{ route('articles.destroy', $article) }}" method="POST" 
                                      onsubmit="return confirm('Sei sicuro di voler eliminare questo articolo? Questa azione è irreversibile!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Elimina
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <!-- Sezione Revisore: Accetta o Rifiuta -->
                    @auth
                        @if(Auth::user()->is_revisor && is_null($article->is_accepted))
                            <div class="d-flex justify-content-between">
                                <form action="{{ route('revisor.accept', $article->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Accetta Articolo
                                    </button>
                                </form>

                                <form action="{{ route('revisor.reject', $article->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Rifiuta Articolo
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Pulsante per tornare alla Dashboard Revisore -->
            @auth
                @if(Auth::user()->is_revisor)
                    <div class="text-center mt-4">
                        <a href="{{ route('revisor.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Torna alla Dashboard
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection
