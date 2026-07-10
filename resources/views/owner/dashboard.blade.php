@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Proprietario</h1>
    
    <div class="row">
        <!-- Sezione per la gestione delle candidature -->
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> Gestione Candidature</h5>
                    <p>Visualizza e gestisci le richieste di lavoro ricevute.</p>
                    <a href="{{ route('owner.jobApplications') }}" class="btn btn-primary">
                        <i class="fas fa-eye"></i> Visualizza Candidature
                    </a>
                </div>
            </div>
        </div>

        <!-- Sezione per mostrare le ultime richieste di lavoro -->
        <div class="col-md-12 mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-file-alt"></i> Ultime Richieste di Lavoro</h5>

                    @if($jobRequests->isEmpty())
                        <p class="text-muted">Nessuna candidatura disponibile.</p>
                    @else
                        <table class="table table-hover">
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
                                @foreach ($jobRequests as $application)
                                    <tr>
                                        <td>{{ $application->user->name }}</td>
                                        <td>{{ $application->user->email }}</td>
                                        <td>{{ Str::limit($application->message, 50) }}</td>
                                        <td>
                                            <a href="{{ route('jobApplications.cv.download', $application) }}" target="_blank">
                                                <i class="fas fa-file-pdf text-danger"></i> CV
                                            </a>
                                        </td>
                                        <td>
                                            <form action="{{ route('owner.acceptJob', $application->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Accetta
                                                </button>
                                            </form>
                                            <form action="{{ route('owner.rejectJob', $application->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Rifiuta
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center mt-3">
                            <a href="{{ route('owner.jobApplications') }}" class="btn btn-secondary">
                                <i class="fas fa-list"></i> Vedi tutte le richieste
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
