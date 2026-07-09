@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Revisore</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($articles->isEmpty())
        <p class="text-muted">Nessun articolo in attesa di revisione.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Autore</th>
                    <th>Categoria</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('articles.show', $article) }}" class="btn btn-info btn-sm">Vedi</a>
                            <form action="{{ route('revisor.acceptArticle', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Accetta</button>
                            </form>
                            <form action="{{ route('revisor.rejectArticle', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Rifiuta</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
