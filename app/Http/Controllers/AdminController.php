<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Recupera tutti gli utenti tranne l'admin principale
        $users = User::where('is_admin', false)->get();
        return view('admin.dashboard', compact('users'));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($request->role == 'admin') {
            $user->update(['is_admin' => true]);
        } elseif ($request->role == 'revisor') {
            $user->update(['is_revisor' => true]);
        } elseif ($request->role == 'writer') {
            $user->update(['is_writer' => true]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Ruolo assegnato con successo!');
    }

    public function removeRole(Request $request, User $user)
    {
        if ($request->role == 'admin') {
            $user->update(['is_admin' => false]);
        } elseif ($request->role == 'revisor') {
            $user->update(['is_revisor' => false]);
        } elseif ($request->role == 'writer') {
            $user->update(['is_writer' => false]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Ruolo rimosso con successo!');
    }

    public function deleteUser(User $user)
    {
        if ($user->is_admin || $user->is_owner || auth()->id() === $user->id) {
            return redirect()->route('admin.dashboard')->with('error', 'Non puoi eliminare questo utente.');
        }

        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Utente eliminato con successo.');
    }
}
