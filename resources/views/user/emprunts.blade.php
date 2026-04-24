
@extends('layouts.public')

@section('content')

<div class="container py-4">

    <h2 class="mb-4"><i class="fas fa-book-reader"></i> Mes Emprunts</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>N° Emprunts</th>
                        <th>Livre</th>
                        <th>Auteur</th>
                        <th>Catégarie</th>
                        <th>Date demande</th>
                        <th>Date retour</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($emprunts as $emprunt)
                    <tr>
                        <td>{{ $emprunt->id }}</td>
                        <td>{{ $emprunt->livre->titre }}</td>
                        <td>{{ $emprunt->livre->auteur->nom }}</td>
                        <td>{{ $emprunt->livre->categorie->nom }}</td>
                        <td>{{ $emprunt->created_at->format('d/m/Y') }}</td>
                        <td>{{ $emprunt->date_retour ?? '—' }}</td>
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
                        <td colspan="5" class="text-center py-3">
                            Vous n'avez aucun emprunt.
                            <a href="{{ route('catalogue') }}">Voir le catalogue</a>
                        </td>
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

@endsection