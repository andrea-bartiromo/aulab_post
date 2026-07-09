@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Ruoli</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->is_admin) <span class="badge bg-primary">Admin</span> @endif
                        @if ($user->is_revisor) <span class="badge bg-warning">Revisore</span> @endif
                        @if ($user->is_writer) <span class="badge bg-success">Scrittore</span> @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.assignRole', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="role">
                                <option value="admin">Admin</option>
                                <option value="revisor">Revisore</option>
                                <option value="writer">Scrittore</option>
                            </select>
                            <button type="submit" class="btn btn-success btn-sm">Assegna Ruolo</button>
                        </form>

                        <form action="{{ route('admin.removeRole', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <select name="role">
                                <option value="admin">Admin</option>
                                <option value="revisor">Revisore</option>
                                <option value="writer">Scrittore</option>
                            </select>
                            <button type="submit" class="btn btn-danger btn-sm">Rimuovi Ruolo</button>
                        </form>

                        <form action="{{ route('admin.deleteUser', $user) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Elimina Utente</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
