@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Gestion des Auteurs</h1>
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
                <h3 class="card-title">Liste des auteurs</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.auteurs.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Ajouter un auteur
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auteurs as $auteur)
                        <tr>
                            <td>{{ $auteur->id }}</td>
                            <td>{{ $auteur->nom }}</td>
                            <td>
                                <a href="{{ route('admin.auteurs.edit', $auteur) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <form action="{{ route('admin.auteurs.destroy', $auteur) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cet auteur ?')">
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
                            <td colspan="3" class="text-center">Aucun auteur enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $auteurs->links() }}
            </div>
        </div>

    </div>
</div>

@endsection