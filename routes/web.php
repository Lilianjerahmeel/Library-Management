<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuteurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\EmpruntController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;


// Route pour le catalogue d'accueil
Route::get('/',[CatalogueController::class, 'index'])->name('catalogue');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route epublic
Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');   //dashboard utilisateur

    Route::post('/emprunts', [EmpruntController::class, 'store'])
         ->name('catalogue.emprunter');
         
    Route::get('/mes-emprunts', [EmpruntController::class, 'mesEmprunts']) //pour que l'utilisateur vois ses emprunts
         ->name('user.emprunts');
});

//proteger la route admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('auteurs', AuteurController::class);
    Route::resource('categories',CategorieController::class)->parameters([
        'categories' => 'categorie' //on renomme le nom de la resource
    ]);
    Route::resource('livres', LivreController::class);
    Route::resource('emprunts', EmpruntController::class);

    Route::post('emprunts/{emprunt}/approuver', [EmpruntController::class, 'approuver'])
     ->name('emprunts.approuver');

    Route::post('emprunts/{emprunt}/refuser', [EmpruntController::class, 'refuser'])
     ->name('emprunts.refuser');

    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
