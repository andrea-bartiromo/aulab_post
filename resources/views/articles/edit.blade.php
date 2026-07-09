@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Modifica Articolo</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label">Sottotitolo</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $article->subtitle) }}" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Contenuto</label>
            <textarea name="body" id="body" class="form-control" rows="6" required>{{ old('body', $article->body) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Immagine di Copertina</label>
            <input type="file" name="cover_image" id="cover_image" class="form-control">
            @if($article->cover_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $article->cover_image) }}" class="img-thumbnail" width="200">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Seleziona una categoria</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Salva Modifiche
        </button>
        
        <a href="{{ route('articles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Annulla
        </a>
    </form>
</div>
@endsection
