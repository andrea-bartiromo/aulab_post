@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lavora con noi</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('job.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="message" class="form-label">Perché vuoi lavorare con noi?</label>
            <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
            @error('message')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cv" class="form-label">Carica il tuo CV (PDF, DOC, DOCX - max 2MB)</label>
            <input type="file" name="cv" id="cv" class="form-control" required>
            @error('cv')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Invia Candidatura</button>
    </form>
</div>
@endsection
