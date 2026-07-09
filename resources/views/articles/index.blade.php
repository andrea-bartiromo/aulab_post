@foreach ($articles as $article)
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $article->title }}</h5>
            <p class="card-text">{{ $article->subtitle }}</p>

            <!-- Solo il writer può modificare o eliminare il proprio articolo -->
            @if(Auth::check() && Auth::id() === $article->user_id)
                <a href="{{ route('articles.edit', $article) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Modifica
                </a>
                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo articolo?');">
                        <i class="fas fa-trash-alt"></i> Elimina
                    </button>
                </form>
            @endif
        </div>
    </div>
@endforeach
