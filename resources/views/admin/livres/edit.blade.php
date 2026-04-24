@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Modifier le livre</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-warning" style="max-width: 600px;">
            <div class="card-header">
                <h3 class="card-title">Modifier : {{ $livre->titre }}</h3>
            </div>
            <form action="{{ route('admin.livres.update', $livre) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="titre">Titre du livre <span class="text-danger">*</span></label>
                        <input type="text"
                               name="titre"
                               id="titre"
                               class="form-control @error('titre') is-invalid @enderror"
                               value="{{ old('titre', $livre->titre) }}"
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
                               value="{{ old('ISBN', $livre->ISBN) }}"
                        >
                        @error('ISBN')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="quantite">Quantité du livre  <span class="text-danger">*</span></label>
                        <input type="number"
                               name="quantite"
                               id="quantite"
                               class="form-control @error('quantite') is-invalid @enderror"
                               value="{{ old('quantite', $livre->quantite) }}"
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
                            @foreach ($auteurs as $auteur)
                                <option value="{{$auteur->id}}" 
                                {{ $livre->auteur_id == $auteur->id ? 'selected' : ''}}
                                {{ old('auteur_id') == $auteur->id ? 'selected' : '' }}>

                                    {{$auteur->nom}}

                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <select name="categorie_id" class="form-control">
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" 
                                {{ $livre->categorie_id == $categorie->id ? 'selected' : '' }}
                                {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>

                                    {{ $categorie->nom }}
                                    
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="photo">Photo du livre  <span class="text-danger">*</span></label>
                        <input type="file"
                               name="photo"
                               id="photo"
                               class="form-control @error('photo') is-invalid @enderror"
                               value="{{ old('photo', $livre->photo) }}"
                        >
                        @error('photo')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection