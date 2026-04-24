@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Modifier la catégorie</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-warning" style="max-width: 600px;">
            <div class="card-header">
                <h3 class="card-title">Modifier : {{ $categorie->nom }}</h3>
            </div>
            <form action="{{ route('admin.categories.update', $categorie) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nom">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text"
                               name="nom"
                               id="nom"
                               class="form-control @error('nom') is-invalid @enderror"
                               value="{{ old('nom', $categorie->nom) }}"
                               placeholder="Ex: Programmation">
                        @error('nom')
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