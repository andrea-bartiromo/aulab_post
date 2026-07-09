@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Richieste di Lavoro</h1>

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

    @if($applications->isEmpty())
        <p class="text-muted">Nessuna candidatura in attesa.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Messaggio</th>
                    <th>Curriculum</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr>
                        <td>{{ $application->user->name }}</td>
                        <td>{{ $application->user->email }}</td>
                        <td>{{ Str::limit($application->message, 50) }}</td>
                        <td><a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank">Visualizza CV</a></td>
                        <td>
                            <form action="{{ route('owner.acceptJob', $application->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Accetta</button>
                            </form>
                            <form action="{{ route('owner.rejectJob', $application->id) }}" method="POST" class="d-inline">
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
