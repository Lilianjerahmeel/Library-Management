@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Gestion des Utilisateurs</h1>
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
                <h3 class="card-title">Liste des Utilisateurs</h3>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>N°</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Ville</th>
                            <th>Rôle</th>
                            <th>Nb Emprunts</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->telephone}}</td>
                            <td>{{ $user->ville}}</td>
                            <td>{{ $user->role}}</td>
                            <td>{{ $user->emprunts_approuves_count}}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier rôle
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Etes-vous sûr de supprimer cet utilisateurs ?')">
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
                            <td colspan="7" class="text-center">Aucun utilisateur enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</div>

@endsection