<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        
        {{-- Logo --}}
        <a href="{{ route('catalogue') }}" class="navbar-brand d-flex align-items-center">
            <img src="{{ asset('adminlte/dist/img/book.jpg') }}" 
                alt="Logo" 
                width="35" 
                height="35"
                class="rounded-circle mr-2">
            <span class="font-weight-bold">Library</span>
        </a>

        {{-- Bouton hamburger mobile --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
                data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Contenu navbar --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">

                @auth
                    {{-- Nom utilisateur --}}
                    <li class="nav-item">
                        <span class="nav-link text-white">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </span>
                    </li>

                    {{-- Dashboard selon rôle --}}
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm mr-2">
                                <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-info btn-sm mr-2">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('catalogue') }}" class="btn btn-secondary btn-sm mr-2">
                                <i class="fas fa-book"></i> Catalogue
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.emprunts') }}" class="btn btn-secondary btn-sm mr-2">
                                <i class="fas fa-book-reader"></i> Mes emprunts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-sm mr-2">
                                <i class="fas fa-user-cog"></i> Profil
                            </a>
                        </li>
                    @endif

                    {{-- Déconnexion --}}
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Déconnexion
                            </button>
                        </form>
                    </li>

                @else
                    {{-- Non connecté --}}
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm mr-2">
                            <i class="fas fa-sign-in-alt"></i> Connexion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-user-plus"></i> Inscription
                        </a>
                    </li>
                @endauth

            </ul>
        </div>

    </nav>

    {{-- Contenu --}}
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>