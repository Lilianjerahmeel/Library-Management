@extends('layouts.public')

@section('content')

<div class="container py-4">

    <h2 class="mb-4"><i class="fas fa-user-circle"></i> Mon Profil</h2>

    <div class="row">

        {{-- Colonne gauche — Infos profil --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Informations personnelles</h5>
                </div>
                <div class="card-body">

                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success">
                            <i class="fas fa-check"></i> Profil mis à jour avec succès !
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Nom</label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telephone"><i class="fas fa-phone"></i> Telephone</label>
                            <input type="text" name="telephone" id="telephone"
                                   class="form-control @error('telephone') is-invalid @enderror"
                                   value="{{ old('telephone', Auth::user()->telephone) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ville"><i class="fas fa-map-marker-alt"></i> Ville</label>
                            <input type="text" name="ville" id="ville"
                                   class="form-control @error('ville') is-invalid @enderror"
                                   value="{{ old('ville', Auth::user()->ville) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Colonne droite — Mot de passe --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0"><i class="fas fa-lock"></i> Changer le mot de passe</h5>
                </div>
                <div class="card-body">

                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success">
                            <i class="fas fa-check"></i> Mot de passe mis à jour !
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password">
                                <i class="fas fa-key"></i> Mot de passe actuel
                            </label>
                            <input type="password" name="current_password" id="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">
                                <i class="fas fa-lock"></i> Nouveau mot de passe
                            </label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="fas fa-lock"></i> Confirmer le mot de passe
                            </label>
                            <input type="password" name="password_confirmation" 
                                   id="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-warning text-white">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Bouton retour --}}
    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour au dashboard
    </a>

</div>

@endsection