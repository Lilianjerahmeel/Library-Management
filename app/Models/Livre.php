<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auteur;
use App\Models\Categorie;
use App\Models\Emprunt;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'ISBN',
        'quantite',
        'auteur_id',
        'categorie_id',
        'photo'
    ];
    
    public function auteur(){
        return $this->belongsTo(Auteur::class);
    }

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }

    public function emprunts(){
        return $this->hasMany(Emprunt::class);
    }
}
