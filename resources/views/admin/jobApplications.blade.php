@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Candidature per Lavora con Noi</h1>

    @if ($applications->isEmpty())
        <p class="text-muted">Nessuna candidatura ricevuta.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Messaggio</th>
                    <th>CV</th>
                    <th>Stato</th>
                    <th>Data</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr>
                        <td>{{ $application->user->name }}</td>
                        <td>{{ $application->user->email }}</td>
                        <td>{{ Str::limit($application->message, 100) }}</td>
                        <td>
                            <a href="{{ route('jobApplications.cv.download', $application) }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-file-download"></i> Scarica CV
                            </a>
                        </td>
                        <td>
                            @if($application->status == 'pending')
                                <span class="badge bg-warning">In attesa</span>
                            @elseif($application->status == 'accepted')
                                <span class="badge bg-success">Accettata</span>
                            @else
                                <span class="badge bg-danger">Rifiutata</span>
                            @endif
                        </td>
                        <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($application->status == 'pending')
                                <form action="{{ route('admin.acceptApplication', $application->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check"></i> Accetta
                                    </button>
                                </form>
                                <form action="{{ route('admin.rejectApplication', $application->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i> Rifiuta
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Candidatura già valutata</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
