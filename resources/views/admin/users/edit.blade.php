@extends('layouts.admin')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Modifier le rôle</h1>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="card card-warning" style="max-width: 600px;">
            <div class="card-header">
                <h3 class="card-title">Modifier : {{ $user->name }}</h3>
            </div>
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="role">Rôle <span class="text-danger">*</span></label>
                        <select name="role" id="role" 
                                class="form-control @error('role') is-invalid @enderror">
                            <option value="user" 
                                {{ $user->role == 'user' ? 'selected' : '' }}>
                                Utilisateur
                            </option>
                            <option value="admin" 
                                {{ $user->role == 'admin' ? 'selected' : '' }}>
                                Administrateur
                            </option>
                        </select>
                        @error('role')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection