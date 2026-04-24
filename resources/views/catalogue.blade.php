@extends('layouts.public')

@section('content')

<div class="container py-4">

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <h2 class="mb-4">Catalogue des Livres</h2>

    {{-- Barre de recherche et filtres --}}
    <form method="GET" action="{{ route('catalogue') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="Rechercher par titre ou ISBN..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="auteur_id" class="form-control">
                    <option value="">Tous les auteurs</option>
                    @foreach($auteurs as $auteur)
                        <option value="{{ $auteur->id }}"
                            {{ request('auteur_id') == $auteur->id ? 'selected' : '' }}>
                            {{ $auteur->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="categorie_id" class="form-control">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $categorie)
                        <option value="{{ $categorie->id }}"
                            {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Filtrer
                </button>
            </div>
        </div>
    </form>

    {{-- Grille des livres --}}
    <div class="row">
        @forelse($livres as $livre)
        <div class="col-md-3 mb-4">
            <div class="card h-100">

                {{-- Photo --}}
                @if($livre->photo)
                    <img src="{{ asset('storage/' . $livre->photo) }}"
                         class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-secondary d-flex align-items-center 
                                justify-content-center" style="height: 200px;">
                        <i class="fas fa-book fa-3x text-white"></i>
                    </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $livre->titre }}</h5>
                    <p class="card-text text-muted mb-1">
                        <i class="fas fa-user"></i> {{ $livre->auteur->nom }}
                    </p>
                    <p class="card-text mb-2">
                        <span class="badge badge-info">{{ $livre->categorie->nom }}</span>
                    </p>

                    {{-- Badge disponibilité --}}
                    @if($livre->quantite > 0)
                        <span class="badge badge-success mb-2">
                            <i class="fas fa-check"></i> Disponible
                        </span>
                    @else
                        <span class="badge badge-danger mb-2">
                            <i class="fas fa-times"></i> Indisponible
                        </span>
                    @endif

                    {{-- Bouton emprunter --}}
                    <div class="mt-auto">
                        @auth
                            @if($livre->quantite > 0)
                                <form action="{{ route('catalogue.emprunter') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                    <button type="submit" class="btn btn-secondary btn-sm w-100">
                                        <i class="fas fa-book-reader"></i> Emprunter
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                    <i class="fas fa-times"></i> Indisponible
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-sign-in-alt"></i> Connectez-vous pour emprunter
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Aucun livre trouvé.</div>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $livres->appends(request()->query())->links() }}
    </div>

</div>

@endsection