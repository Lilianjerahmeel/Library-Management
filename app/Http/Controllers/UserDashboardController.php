<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Emprunt;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 3 derniers emprunts
        $derniersEmprunts = Emprunt::with('livre')
                                   ->where('user_id', $user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->take(3)
                                   ->get();

        // Compteurs
        $totalEmprunts    = Emprunt::where('user_id', $user->id)->count();
        $empruntsEnCours  = Emprunt::where('user_id', $user->id)
                                   ->where('statut', 'approuve')
                                   ->whereNull('date_retour')
                                   ->count();
        $enAttente        = Emprunt::where('user_id', $user->id)
                                   ->where('statut', 'en_attente')
                                   ->count();

        return view('user.dashboard', compact(
            'user',
            'derniersEmprunts',
            'totalEmprunts',
            'empruntsEnCours',
            'enAttente'
        ));
    }
}
