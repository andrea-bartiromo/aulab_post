<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewJobApplication;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    /**
     * Mostra il form di candidatura
     */
    public function showForm()
    {
        return view('workwithus');
    }

    /**
     * Gestisce l'invio della candidatura
     */
    public function submitApplication(Request $request)
    {
        // Validazione dei dati del modulo
        $validatedData = $request->validate([
            'message' => 'required|string|min:10|max:1000',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048', // Solo PDF, DOC, DOCX fino a 2MB
        ]);

        // Gestione del caricamento del file CV
        if ($request->hasFile('cv') && $request->file('cv')->isValid()) {
            $cvPath = $request->file('cv')->store('cvs', 'local');

            // Salva la candidatura nel database
            $jobApplication = JobApplication::create([
                'user_id' => Auth::id(),
                'message' => $validatedData['message'],
                'cv_path' => $cvPath,
                'status' => 'pending',
            ]);

            // Notifica l'admin
            $admin = User::where('is_admin', true)->first();
            if ($admin) {
                $admin->notify(new NewJobApplication($jobApplication));
            }

            // Reindirizza l'utente alla home page con un messaggio di successo
            return redirect()->route('home')->with('success', 'Candidatura inviata con successo! Ti contatteremo presto.');
        }

        // Se il file non è valido, reindirizza l'utente indietro con un messaggio di errore
        return back()->withErrors(['cv' => 'Errore durante il caricamento del file.']);
    }

    /**
     * Mostra la lista delle candidature per l'admin
     */
    public function index()
    {
        $applications = JobApplication::with('user')->latest()->get();
        return view('admin.jobApplications', compact('applications'));
    }

    /**
     * Accetta una candidatura e promuove l'utente a revisore
     */
    public function accept($id)
    {
        $application = JobApplication::findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()->route('admin.jobApplications')->with('error', 'Questa candidatura è già stata gestita.');
        }

        $application->update(['status' => 'accepted']);

        // Promuove l'utente a Revisore
        $user = $application->user;
        if ($user) {
            $user->update(['is_revisor' => true]);
        }

        return redirect()->route('admin.jobApplications')->with('success', 'Candidatura accettata! Utente promosso a Revisore.');
    }

    /**
     * Rifiuta una candidatura
     */
    public function reject($id)
    {
        $application = JobApplication::findOrFail($id);

        if ($application->status !== 'pending') {
            return redirect()->route('admin.jobApplications')->with('error', 'Questa candidatura è già stata gestita.');
        }

        $application->update(['status' => 'rejected']);

        return redirect()->route('admin.jobApplications')->with('error', 'Candidatura rifiutata.');
    }

    /**
     * Scarica il CV di una candidatura (solo Admin e Owner).
     */
    public function downloadCv(JobApplication $application)
    {
        $user = Auth::user();

        if (!$user->is_admin && !$user->is_owner) {
            abort(403);
        }

        if (!$application->cv_path || !Storage::disk('local')->exists($application->cv_path)) {
            abort(404);
        }

        return Storage::disk('local')->download(
            $application->cv_path,
            basename($application->cv_path)
        );
    }
}
