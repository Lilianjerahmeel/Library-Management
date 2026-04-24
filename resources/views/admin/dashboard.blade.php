@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Dashboard</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        {{-- Cards statistiques --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalLivres }}</h3>
                        <p>Total Livres</p>
                    </div>
                    <div class="icon"><i class="fas fa-book"></i></div>
                    <a href="{{ route('admin.livres.index') }}" class="small-box-footer">
                        Voir <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalAuteurs }}</h3>
                        <p>Auteurs</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-edit"></i></div>
                    <a href="{{ route('admin.auteurs.index') }}" class="small-box-footer">
                        Voir <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $totalCategories }}</h3>
                        <p>Catégories</p>
                    </div>
                    <div class="icon"><i class="fas fa-book"></i></div>
                    <a href="{{ route('admin.categories.index') }}" class="small-box-footer">
                        Voir <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalUtilisateurs }}</h3>
                        <p>Utilisateurs</p>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                        Voir <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $empruntsActifs }}</h3>
                        <p>Emprunts actifs</p>
                    </div>
                    <div class="icon"><i class="fas fa-book-reader"></i></div>
                    <a href="{{ route('admin.emprunts.index') }}" class="small-box-footer">
                        Voir <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

        </div>

        {{-- Derniers emprunts --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-2"></i>
                    10 derniers emprunts
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>N° Emprunt</th>
                            <th>Utilisateur</th>
                            <th>Livre</th>
                            <th>Date emprunt</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($derniersEmprunts as $emprunt)
                        <tr>
                            <td>{{ $emprunt->id }}</td>
                            <td>{{ $emprunt->user->name }}</td>
                            <td>{{ $emprunt->livre->titre }}</td>
                            <td>{{ $emprunt->date_emprunt }}</td>
                            <td>
                                @if($emprunt->statut == 'en_attente')
                                    <span class="badge badge-warning">En attente</span>
                                @elseif($emprunt->statut == 'approuve')
                                    @if($emprunt->date_retour)
                                        <span class="badge badge-success">Retourné</span>
                                    @else
                                        <span class="badge badge-info">Approuvé</span>
                                    @endif
                                @else
                                    <span class="badge badge-danger">Refusé</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun emprunt enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection