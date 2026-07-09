@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Articoli scritti da: {{ $user->name }}</h1>

    <div class="row">
        @foreach ($articles as $article)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ Str::limit($article->subtitle, 100) }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="btn btn-info">Leggi di più</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
