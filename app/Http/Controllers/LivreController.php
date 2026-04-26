<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    public function index()
    {
        $livres = Livre::with(['auteur', 'categorie'])->orderBy('titre')->paginate(10);
        return view('admin.livres.index', compact('livres'));
    }

    public function create()
    {
        $auteurs    = Auteur::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();
        return view('admin.livres.create', compact('auteurs', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'ISBN'         => 'required|string|max:255|unique:livres,ISBN',
            'quantite'     => 'required|integer|min:0',
            'auteur_id'    => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'photo'        => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('photo')->store('livres', 'public');

        Livre::create([
            'titre'        => $request->titre,
            'ISBN'         => $request->ISBN,
            'quantite'     => $request->quantite,
            'auteur_id'    => $request->auteur_id,
            'categorie_id' => $request->categorie_id,
            'photo'        => $path,
        ]);

        return redirect()->route('admin.livres.index')
                         ->with('success', 'Livre ajouté avec succès !');
    }

    public function edit(Livre $livre)
    {
        $auteurs    = Auteur::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();
        return view('admin.livres.edit', compact('livre', 'auteurs', 'categories'));
    }

    public function update(Request $request, Livre $livre)
    {
        $request->validate([
            'titre'        => 'required|string|max:255',
            'ISBN'         => 'required|string|max:255|unique:livres,ISBN,' . $livre->id,
            'quantite'     => 'required|integer|min:0',
            'auteur_id'    => 'required|exists:auteurs,id',
            'categorie_id' => 'required|exists:categories,id',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // optionnelle
        ]);

        $data = [
            'titre'        => $request->titre,
            'ISBN'         => $request->ISBN,
            'quantite'     => $request->quantite,
            'auteur_id'    => $request->auteur_id,
            'categorie_id' => $request->categorie_id,
        ];

        // Nouvelle photo uploadée
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo du serveur
            if ($livre->photo) {
                Storage::disk('public')->delete($livre->photo);
            }
            $data['photo'] = $request->file('photo')->store('livres', 'public');
        }

        $livre->update($data);

        return redirect()->route('admin.livres.index')
                         ->with('success', 'Livre modifié avec succès !');
    }

    public function destroy(Livre $livre)
    {
        if ($livre->emprunts()->whereIn('statut', ['en_attente', 'approuve'])
                              ->whereNull('date_retour')->count() > 0) {
            return redirect()->route('admin.livres.index')
                             ->with('error', 'Impossible de supprimer : ce livre a des emprunts actifs.');
        }

        // Supprimer la photo du serveur
        if ($livre->photo) {
            Storage::disk('public')->delete($livre->photo);
        }

        $livre->delete();

        return redirect()->route('admin.livres.index')
                         ->with('success', 'Livre supprimé avec succès !');
    }
}