{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>KBM</title>
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  @yield('styles')
</head>

<body class="toggle-sidebar">
  <!-- Header -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <i class="bi bi-list toggle-sidebar-btn me-4"></i>
      <a href="{{ url('/') }}" class="logo d-flex align-items-center">
        <img src="{{ asset('img/logo_kbm.jpg') }}" style="height: 40px;" alt="" class="me-4">
        <span class="d-none d-lg-block">KBM</span>
      </a>
    </div>
    <nav class="header-nav ms-auto pe-4">
      @php $user = Auth::user(); @endphp
      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <span class="d-none d-md-block dropdown-toggle ps-2">{{ $user->nom_utilisateur ?? 'Utilisateur' }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <h6>{{ $user->nom_utilisateur }}</h6>
          <span>{{ $user->role_utilisateur->role ?? 'Rôle inconnu' }}</span>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Déconnexion</span>
          </a>
        </li>
      </ul>
    </nav>
  </header>
  <!-- End Header -->

  @php
      $role = Auth::user()->role_utilisateur->role ?? null;
  @endphp

  <aside id="sidebar" class="sidebar"
    onmouseenter="openSidebar()" 
    onmouseleave="closeSidebar()">
      @if ($role && View::exists('layouts.partials.menu.' . $role))
          @include('layouts.partials.menu.' . $role)
      @else
          <p class="text-danger text-center p-3">Menu non disponible</p>
      @endif
  </aside>

  <main id="main" class="main">
    @yield('content')
  </main>

  <footer id="footer" class="footer">
    <div class="copyright">&copy; 2025 Kianja Barea Mahamasina</div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- JS -->
  <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  @yield('scripts')
</body>
</html>
