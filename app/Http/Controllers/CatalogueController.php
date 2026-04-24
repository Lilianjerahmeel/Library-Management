<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\Auteur;
use App\Models\Categorie;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        //on prepare une requete qui charge les livres avec leurs auteurs et leurs categories
        $query = Livre::with(['auteur','categorie']);
        
        if($request->filled('search')){
            $search = $request->search;

            // on utilise une fonction pour ajouter des parenthèses à la requete
            //on utilise use par ce une fn ne peut pas acceder à une variable exterieure
            $query->where(function ($q) use ($search){  
                $q->where('titre','like','%'.$search.'%')
                ->orWhere('ISBN','like','%'.$search.'%');
            });
        }

        //on filtre les livres par l'auteur choisi
        if($request->filled('auteur_id')){
            $query->where('auteur_id',$request->auteur_id);
        }
        
        //on filtre les livres par la categorie choisi
        if($request->filled('categorie_id')){
            $query->where('categorie_id',$request->categorie_id);
        }

        $livres = $query->orderBy('titre')->paginate(10);
        $auteurs = Auteur::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();

        return view('catalogue', compact('livres','auteurs','categories'));
        
    }
}
