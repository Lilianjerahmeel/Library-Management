<?php

namespace App\Http\Controllers;

use App\Models\Auteur;
use Illuminate\Http\Request;

class AuteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auteurs = Auteur::orderBy('id')->paginate(10);
        return view('admin.auteurs.index', compact('auteurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.auteurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:auteurs,nom',
        ]);

        Auteur::create(['nom' => $request->nom]);

        return redirect()->route('admin.auteurs.index')
                        ->with('success', 'Auteur ajouté avec succès !');

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
    public function edit(Auteur $auteur)
    {
        return view('admin.auteurs.edit', compact('auteur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auteur $auteur)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:auteurs,nom,' . $auteur->id,
        ]);

        $auteur->update(['nom' => $request->nom]);

        return redirect()->route('admin.auteurs.index')
                        ->with('success', 'Auteur modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auteur $auteur)
    {
        if ($auteur->livres()->count() > 0) {
            return redirect()->route('admin.auteurs.index')
                            ->with('error', 'Impossible de supprimer : cet auteur a des livres associés.');
        }

        $auteur->delete();

        return redirect()->route('admin.auteurs.index')
                        ->with('success', 'Auteur supprimé avec succès !');
    }
}
