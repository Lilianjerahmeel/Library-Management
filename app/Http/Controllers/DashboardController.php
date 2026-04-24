<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livre;
use App\Models\User;
use App\Models\Emprunt;
use App\Models\Auteur;
use App\Models\Categorie;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLivres      = Livre::count();
        $totalUtilisateurs = User::count();
        $totalAuteurs     = Auteur::count();
        $totalCategories  = Categorie::count();
        $empruntsActifs   = Emprunt::whereNull('date_retour')->count();
        $derniersEmprunts = Emprunt::with(['user', 'livre'])
                                   ->orderBy('created_at', 'desc')
                                   ->take(10)
                                   ->get();

        return view('admin.dashboard', compact(
            'totalLivres',
            'totalUtilisateurs',
            'totalAuteurs',
            'totalCategories',
            'empruntsActifs',
            'derniersEmprunts'
        ));
    }
}
