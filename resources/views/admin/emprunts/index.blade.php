@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Gestion des Emprunts</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

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

        {{-- Barre de recherche --}}
        <form method="GET" action="{{ route('admin.emprunts.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-5">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Rechercher par utilisateur ou livre..."
                            value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="statut" class="form-control">
                        <option value="">Tous les statuts </option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>
                            En attente
                        </option>
                        <option value="approuve" {{ request('statut') == 'approuve' ? 'selected' : '' }}>
                            Approuvé
                        </option>
                        <option value="refuse" {{ request('statut') == 'refuse' ? 'selected' : '' }}>
                            Refusé
                        </option>
                    </select>
                </div>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Liste des emprunts en cours</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>N° Emprunt</th>
                            <th>Utilisateur</th>
                            <th>Livre</th>
                            <th>Date emprunt</th>
                            <th>Date retour</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprunts as $emprunt)
                        <tr>
                            <td>{{ $emprunt->id }}</td>
                            <td>{{ $emprunt->user->name }}</td>
                            <td>{{ $emprunt->livre->titre }}</td>
                            <td>{{ $emprunt->date_emprunt }}</td>
                            <td>{{ $emprunt->date_retour ?? '—' }}</td>
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
                            <td>
                                @if($emprunt->statut == 'en_attente')
                                    <div class="d-flex flex-column" style="gap: 5px;">
                                        <form action="{{ route('admin.emprunts.approuver', $emprunt) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-block"
                                                    onclick="return confirm('Approuver cet emprunt ?')">
                                                <i class="fas fa-check"></i> Approuver
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.emprunts.refuser', $emprunt) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-block"
                                                    onclick="return confirm('Refuser cet emprunt ?')">
                                                <i class="fas fa-times"></i> Refuser
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.emprunts.destroy', $emprunt) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm btn-block"
                                                    onclick="return confirm('Supprimer ?')">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>

                                @elseif($emprunt->statut == 'approuve' && !$emprunt->date_retour)
                                    <div class="d-flex flex-column" style="gap: 5px;">
                                        <form action="{{ route('admin.emprunts.update', $emprunt) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-warning btn-sm btn-block" style="white-space: nowrap;"
                                                    onclick="return confirm('Marquer comme retourné ?')">
                                                <i class="fas fa-undo"></i> Marquer rendu
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.emprunts.destroy', $emprunt) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm btn-block"
                                                    onclick="return confirm('Supprimer ?')">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>

                                @elseif($emprunt->statut == 'refuse')
                                    <div class="d-flex flex-column" style="gap: 5px;">
                                        <span class="badge badge-danger p-2">Refusé</span>
                                        <form action="{{ route('admin.emprunts.destroy', $emprunt) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm btn-block"
                                                    onclick="return confirm('Supprimer ?')">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>

                                @else
                                    <div class="d-flex flex-column" style="gap: 5px;">
                                        <form action="{{ route('admin.emprunts.destroy', $emprunt) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary btn-sm btn-block"
                                                    onclick="return confirm('Voulez vous supprimer cette emprunt ?')">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun emprunt enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $emprunts->links() }}
            </div>
        </div>

    </div>
</div>

@endsection