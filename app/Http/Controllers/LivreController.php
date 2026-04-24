<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livres = Livre::with(['auteur', 'categorie'])->orderBy('titre')->paginate(10);

        return view('admin.livres.index', compact('livres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auteurs = Auteur::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.livres.create', compact('auteurs', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255|unique:livres,ISBN',
            'quantite' => 'required|integer|min:0',
            'auteur_id' => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if($request->hasFile('photo')){
            $path = $request->file('photo')->store('livres','public');
        }

        Livre::create([
            'titre' => $request->titre,
            'ISBN' => $request->ISBN,
            'quantite' => $request->quantite,
            'auteur_id' => $request->auteur_id,
            'categorie_id' => $request->categorie_id,
            'photo' => $path,
        ]);

        return redirect()->route('admin.livres.index')
                         ->with('success', 'Livre ajouté avec succès !');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livre $livre)
    {
        $auteurs = Auteur::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('admin.livres.edit', compact('livre', 'auteurs', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livre $livre)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'ISBN' => 'required|string|max:255|unique:livres,ISBN,' . $livre->id,
            'quantite' => 'required|integer|min:0',
            'auteur_id' => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if($request->hasFile('photo')){
            $path = $request->file('photo')->store('livres','public');
        }

        $livre->update([
            'titre' => $request->titre,
            'ISBN' => $request->ISBN,
            'quantite' => $request->quantite,
            'auteur_id' => $request->auteur_id,
            'categorie_id' => $request->categorie_id,
            'photo' => $path,
        ]);

        return redirect()->route('admin.livres.index')
                         ->with('success', 'Livre modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livre $livre)
    {
        // Vérifie si le livre n'est pas emprunté
        if ($livre->emprunts()->count() > 0) {
            return redirect()->route('admin.livres.index')
                             ->with('error', 'Impossible de supprimer : ce livre est emprunté.');
        }

        $livre->delete();

        return redirect()->route('admin.livres.index')
                         ->with('success', 'Livre supprimé avec succès !');
    }
}