@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Gestion des Livres</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Liste des Livres</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.livres.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Ajouter un livre
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>ISBN</th>
                            <th>Auteur</th>
                            <th>Catégorie</th>
                            <th>Photo</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($livres as $livre)
                        <tr>
                            <td>{{ $livre->id }}</td>
                            <td>{{ $livre->titre }}</td>
                            <td>{{ $livre->ISBN }}</td>
                            <td>{{ $livre->auteur->nom ?? '-' }}</td>
                            <td>{{ $livre->categorie->nom ?? '-' }}</td>
                            <td>
                                @if ($livre->photo)
                                    <img src="{{asset('storage/' . $livre->photo) }}" width="60">
                                    
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $livre->quantite > 0 ? 'success' : 'danger' }}">
                                    {{ $livre->quantite }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.livres.edit', $livre) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>

                                <form action="{{ route('admin.livres.destroy', $livre) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Etes-vous sûr de supprimer ce livre ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Aucun livre enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $livres->links() }}
            </div>
        </div>

    </div>
</div>

@endsection