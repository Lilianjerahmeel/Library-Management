@extends('layouts.public')

@section('content')

<div class="container py-4">

    {{-- Bienvenue --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-user"></i> Bienvenue, {{ $user->name }} !</h2>
        <span class="text-muted">{{ now()->format('d/m/Y') }}</span>
    </div>

    {{-- Cards statistiques --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-2x mb-2"></i>
                    <h3>{{ $totalEmprunts }}</h3>
                    <p class="mb-0">Total Emprunts</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info h-100">
                <div class="card-body text-center">
                    <i class="fas fa-book-reader fa-2x mb-2"></i>
                    <h3>{{ $empruntsEnCours }}</h3>
                    <p class="mb-0">Emprunts en cours</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h3>{{ $enAttente }}</h3>
                    <p class="mb-0">En attente</p>
                </div>
            </div>
        </div>
    </div>


    {{-- Derniers emprunts --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-history"></i> Mes derniers emprunts</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Livre</th>
                        <th>Date demande</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($derniersEmprunts as $emprunt)
                    <tr>
                        <td>{{ $emprunt->livre->titre }}</td>
                        <td>{{ $emprunt->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($emprunt->statut == 'en_attente')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> En attente
                                </span>
                            @elseif($emprunt->statut == 'approuve' && !$emprunt->date_retour)
                                <span class="badge badge-success">
                                    <i class="fas fa-check"></i> Approuvé
                                </span>
                            @elseif($emprunt->statut == 'approuve' && $emprunt->date_retour)
                                <span class="badge badge-info">
                                    <i class="fas fa-undo"></i> Retourné
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-times"></i> Refusé
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-3">
                            Aucun emprunt pour l'instant.
                            <a href="{{ route('catalogue') }}">Emprunter un livre</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($totalEmprunts > 3)
        <div class="card-footer text-center">
            <a href="{{ route('user.emprunts') }}">Voir tous mes emprunts →</a>
        </div>
        @endif
    </div>

</div>

@endsection