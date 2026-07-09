<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\User;

class OwnerDashboardController extends Controller
{
    /**
     * Mostra la Dashboard del Proprietario con le ultime richieste di lavoro.
     */
    public function index()
    {
        // Recupera le ultime 5 richieste di lavoro in stato "pending"
        $jobRequests = JobApplication::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Contiamo quante richieste di lavoro sono ancora in sospeso
        $pendingCount = JobApplication::where('status', 'pending')->count();

        return view('owner.dashboard', compact('jobRequests', 'pendingCount'));
    }

    /**
     * Mostra tutte le richieste di lavoro ricevute.
     */
    public function showApplications()
    {
        $applications = JobApplication::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('owner.job-applications', compact('applications'));
    }

    /**
     * Accetta una richiesta di lavoro e promuove l'utente a Revisore.
     */
    public function acceptApplication($id)
    {
        $application = JobApplication::findOrFail($id);

        // Controllo se la candidatura è già stata gestita
        if ($application->status !== 'pending') {
            return redirect()->route('owner.dashboard')->with('error', 'Questa candidatura è già stata gestita.');
        }

        $application->update(['status' => 'accepted']);

        // Controllo se l'utente esiste prima di promuoverlo a Revisore
        if ($application->user) {
            $application->user->update(['is_revisor' => true]);
        }

        return redirect()->route('owner.dashboard')->with('success', 'Candidatura accettata! Utente promosso a Revisore.');
    }

    /**
     * Rifiuta una richiesta di lavoro.
     */
    public function rejectApplication($id)
    {
        $application = JobApplication::findOrFail($id);

        // Controllo se la candidatura è già stata gestita
        if ($application->status !== 'pending') {
            return redirect()->route('owner.dashboard')->with('error', 'Questa candidatura è già stata gestita.');
        }

        $application->update(['status' => 'rejected']);

        return redirect()->route('owner.dashboard')->with('error', 'Candidatura rifiutata.');
    }
}
