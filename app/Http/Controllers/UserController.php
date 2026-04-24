<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Emprunt;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::withCount(['emprunts as emprunts_approuves_count' => function($query){
                    $query->where('statut','approuve');
                }])
                ->orderby('created_at','desc')
                ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Role modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Vérifie si le livre n'est pas emprunté
        if ($user->emprunts()->whereNull('date_retour')->count() > 0) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Impossible de supprimer : cet utilisateur a encore des emprunts en cours.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Utilisateur supprimé avec succès !');
    }
}
