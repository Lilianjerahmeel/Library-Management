<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Emprunt;
use App\Models\Livre;
use App\Models\User;

class EmpruntController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emprunts = Emprunt::with(['user', 'livre'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.emprunts.index', compact('emprunts'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $users = User::where('role','user')->get();
        $livres = Livre::orderBy('titre')->get();
        return view('admin.emprunts.create', compact('users', 'livres'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'livre_id' => 'required|exists:livres,id',
        ]);

        $livre = Livre::findOrFail($request->livre_id);

        // Vérifier le stock
        if ($livre->quantite <= 0) {
            return back()->with('error', 'Ce livre n\'est plus disponible.');
        }

        // Vérifier double emprunt
        $dejaEmprunte = Emprunt::where('user_id', Auth::id())
                            ->where('livre_id', $request->livre_id)
                            ->whereIn('statut', ['en_attente', 'approuve'])
                            ->whereNull('date_retour')
                            ->exists();

        if ($dejaEmprunte) {
            return back()->with('error', 'Vous avez déjà une demande en cours pour ce livre.');
        }

        // Créer la demande avec statut en_attente
        Emprunt::create([
            'user_id'      => Auth::id(),
            'livre_id'     => $request->livre_id,
            'date_emprunt' => null,
            'statut'    => 'en_attente',
        ]);

        return redirect()->route('catalogue')
                        ->with('success', 'Demande d\'emprunt envoyée !');
    }


    public function approuver(Emprunt $emprunt)
    {
        if ($emprunt->statut !== 'en_attente') {
            return redirect()->route('admin.emprunts.index')
                            ->with('error', 'Cette demande a déjà été traitée.');
        }

        // Vérifier le stock encore une fois
        if ($emprunt->livre->quantite <= 0) {
            return redirect()->route('admin.emprunts.index')
                            ->with('error', 'Stock épuisé, impossible d\'approuver.');
        }
        
        DB::transaction(function() use ($emprunt){
            $emprunt->update([
                'statut' => 'approuve',
                'date_emprunt' => now()
            ]);
            $emprunt->livre->decrement('quantite');
        });
        

        return redirect()->route('admin.emprunts.index')
                        ->with('success', 'Emprunt approuvé !');
    }

    public function refuser(Emprunt $emprunt)
    {
        if ($emprunt->statut !== 'en_attente') {
            return redirect()->route('admin.emprunts.index')
                            ->with('error', 'Cette demande a déjà été traitée.');
        }

        $emprunt->update(['statut' => 'refuse']);

        return redirect()->route('admin.emprunts.index')
                        ->with('success', 'Emprunt refusé.');
    }

    public function mesEmprunts()
    {
        $emprunts = Emprunt::with('livre')
                        ->where('user_id', Auth::id())
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('user.emprunts', compact('emprunts'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Emprunt $emprunt)
    {
        // Vérifier que le livre n'est pas déjà retourné
        if ($emprunt->statut ==='approuve' && $emprunt->date_retour) {
            return redirect()->route('admin.emprunts.index')
                            ->with('error', 'Ce livre a déjà été retourné.');
        }

        // Enregistrer la date de retour
        $emprunt->update([
            'date_retour' => now(),
        ]);

        // Augmenter le stock du livre de 1
        $emprunt->livre->increment('quantite');

        return redirect()->route('admin.emprunts.index')
                        ->with('success', 'Le livre a retourné avec succès ! Stock mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Emprunt $emprunt)
    {
        // Si le livre n'est pas encore retourné, remettre le stock
        if ($emprunt->statut ==='approuve' && !$emprunt->date_retour) {
            $emprunt->livre->increment('quantite');
        }

        $emprunt->delete();

        return redirect()->route('admin.emprunts.index')
                        ->with('success', 'Emprunt supprimé avec succès.');
    }
}
