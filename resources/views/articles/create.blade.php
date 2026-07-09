@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inserisci un Nuovo Articolo</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label">Sottotitolo</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Corpo del Testo</label>
            <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Immagine di Copertina</label>
            <input type="file" name="cover_image" id="cover_image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoria</label>
            <select name="category_id" id="category_id" class="form-select">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Pubblica Articolo</button>
    </form>
</div>
@endsection
