@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Nouvel Emprunt</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ session('error') }}
            </div>
        @endif

        <div class="card card-primary" style="max-width: 600px;">
            <div class="card-header">
                <h3 class="card-title">Enregistrer un emprunt</h3>
            </div>
            <form action="{{ route('admin.emprunts.store') }}" method="POST">
                @csrf
                <div class="card-body">

                    <div class="form-group">
                        <label for="user_id">Utilisateur <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" 
                                class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Sélectionner un utilisateur</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>

                                    {{ $user->name }} — {{ $user->email }}

                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="livre_id">Livre <span class="text-danger">*</span></label>
                        <select name="livre_id" id="livre_id" 
                                class="form-control @error('livre_id') is-invalid @enderror">
                            <option value="">Sélectionner un livre</option>
                            @foreach($livres as $livre)
                                <option value="{{ $livre->id }}"
                                    {{ old('livre_id') == $livre->id ? 'selected' : '' }}>
                                    
                                    {{ $livre->titre }} — Stock : {{ $livre->quantite }}

                                </option>
                            @endforeach
                        </select>
                        @error('livre_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Confirmer l'emprunt
                    </button>
                    <a href="{{ route('admin.emprunts.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection