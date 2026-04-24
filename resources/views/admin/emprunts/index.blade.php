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
                                    {{-- Approuver --}}
                                    <form action="{{ route('admin.emprunts.approuver', $emprunt) }}" 
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Approuver cet emprunt ?')">
                                            <i class="fas fa-check"></i> Approuver
                                        </button>
                                    </form>
                                    {{-- Refuser --}}
                                    <form action="{{ route('admin.emprunts.refuser', $emprunt) }}" 
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Refuser cet emprunt ?')">
                                            <i class="fas fa-times"></i> Refuser
                                        </button>
                                    </form>

                                @elseif($emprunt->statut == 'approuve' && !$emprunt->date_retour)
                                    {{-- Marquer rendu --}}
                                    <form action="{{ route('admin.emprunts.update', $emprunt) }}" 
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-warning btn-sm"
                                                onclick="return confirm('Marquer comme retourné ?')">
                                            <i class="fas fa-undo"></i> Marquer rendu
                                        </button>
                                    </form>

                                @endif

                                {{-- Supprimer --}}
                                <form action="{{ route('admin.emprunts.destroy', $emprunt) }}" 
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary btn-sm"
                                            onclick="return confirm('Supprimer ?')">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
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