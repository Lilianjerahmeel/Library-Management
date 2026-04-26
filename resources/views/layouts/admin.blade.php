<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion Bibliothèque</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">

      @auth
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
              <i class="fas fa-user-circle"></i>
              <strong>{{ Auth::user()->name }}</strong>
          </a>

          <div class="dropdown-menu dropdown-menu-right">
              <span class="dropdown-item-text">
                  <strong>{{ Auth::user()->email }}</strong>
              </span>

              <div class="dropdown-divider"></div>

              <a href="{{ route('profile.edit') }}" class="dropdown-item">
                  <i class="fas fa-user"></i> Profil
              </a>

              <div class="dropdown-divider"></div>

              <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                      <i class="fas fa-sign-out-alt"></i> Déconnexion
                  </button>
              </form>
          </div>
      </li>
      @endauth

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    {{-- Logo --}}
    <a href="{{ route('admin.dashboard') }}" class="brand-link mb-5">
        <img src="{{asset('adminlte/dist/img/book.jpg')}}" alt="Book Logo" 
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Library Management</span>
    </a>

    <div>

        {{-- Search --}}
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" 
                       placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" 
                data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Catalogue --}}
                <li class="nav-item">
                    <a href="{{ route('catalogue') }}" 
                       class="nav-link {{ request()->is('catalogue') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Catalogues</p>
                    </a>
                </li>

                {{-- mes-emprunts --}}
                <li class="nav-item">
                    <a href="{{ route('user.emprunts') }}" 
                       class="nav-link {{ request()->is('user.emprunts') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-reader"></i>
                        <p>Mes emprunts</p>
                    </a>
                </li>                

                {{-- Utilisateurs --}}
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" 
                       class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Utilisateurs</p>
                    </a>
                </li>
                {{-- Auteurs --}}
                <li class="nav-item">
                    <a href="{{ route('admin.auteurs.index') }}" 
                       class="nav-link {{ request()->is('admin/auteurs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>Auteurs</p>
                    </a>
                </li>
                {{-- Catégorie --}}
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Catégories</p>
                    </a>
                </li>
                {{-- Livre --}}
                <li class="nav-item">
                    <a href="{{ route('admin.livres.index') }}" 
                       class="nav-link {{ request()->is('admin/livres*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Livres</p>
                    </a>
                </li>
                {{-- Emprunt --}}
                <li class="nav-item">
                  <a href="{{ route('admin.emprunts.index') }}" 
                    class="nav-link {{ request()->is('admin/emprunts*') ? 'active' : '' }}">
                      <i class="nav-icon fas fa-book-reader"></i>
                      <p>Emprunts</p>
                  </a>
              </li>
            </ul>
        </nav>

    </div>
</aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </section>
  </div>
  <!-- /.content-wrapper 
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>-->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('adminlte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('adminlte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('adminlte/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('adminlte/dist/js/pages/dashboard.js')}}"></script>
</body>
</html>