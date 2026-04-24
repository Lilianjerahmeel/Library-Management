@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Ajouter un Livre</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-primary" style="max-width: 600px;">
            <div class="card-header">
                <h3 class="card-title">Nouveau Livre</h3>
            </div>
            <form action="{{ route('admin.livres.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="titre">Titre du livre <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="titre" 
                               id="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre') }}"
                        >
                        @error('titre')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ISBN">ISBN du livre <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="ISBN" 
                               id="ISBN"
                               class="form-control @error('ISBN') is-invalid @enderror"
                               value="{{ old('ISBN') }}"
                        >
                        @error('ISBN')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="quantite">Quantité du livre <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="quantite" 
                               id="quantite"
                               class="form-control @error('quantite') is-invalid @enderror"
                               value="{{ old('quantite') }}"
                        >
                        @error('quantite')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="auteur_id">Auteur <span class="text-danger">*</span></label>
                        <select name="auteur_id" class="form-control">
                            <option value="">Choisir un auteur</option>
                            @foreach ($auteurs as $auteur)
                                <option value="{{ $auteur->id }}">
                                    {{$auteur->nom}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="categorie_id">Catégorie <span class="text-danger">*</span></label>
                        <select name="categorie_id" class="form-control">
                            <option value=""> Choisir une catégorie </option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">
                                    {{ $categorie->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="photo">Photo du livre <span class="text-danger">*</span></label>
                        <input type="file" 
                               name="photo" 
                               id="photo"
                               class="form-control @error('photo') is-invalid @enderror"
                               value="{{ old('photo') }}"
                        >
                        @error('quantite')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ route('admin.livres.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection