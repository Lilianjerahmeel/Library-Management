<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::orderBy('id')->paginate(10);
        return view('admin.Categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
        public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
        ]);

        Categorie::create(['nom' => $request->nom]);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Catégorie ajouté avec succès !');

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
    public function edit(Categorie $categorie)
    {
        return view('admin.categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
        ]);

        $categorie->update(['nom' => $request->nom]);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Catégorie modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        if ($categorie->livres()->count() > 0) {
            return redirect()->route('admin.categories.index')
                            ->with('error', 'Impossible de supprimer : cette catégorie a des livres associés.');
        }

        $categorie->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Catégorie supprimé avec succès !');
    }
}
