<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'RSHP')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --green: #1b602f;
      --pink: #f784c5;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fafafa;
      color: #333;
    }

    /* === Navbar === */
    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--green) !important;
    }

    .navbar-nav .nav-link {
      color: #333 !important;
      font-weight: 500;
      transition: 0.3s;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--pink) !important;
    }

    .btn-primary-main {
      background-color: var(--green);
      color: #fff;
      border-radius: 8px;
      font-weight: 600;
      padding: 8px 18px;
      border: none;
    }

    .btn-primary-main:hover {
      background-color: #134b24;
    }

    .btn-secondary-main {
      background-color: var(--pink);
      color: #fff;
      border-radius: 8px;
      font-weight: 600;
      padding: 8px 18px;
      border: none;
    }

    .btn-secondary-main:hover {
      background-color: #e26eb2;
    }

    footer {
      background-color: var(--green);
      color: white;
      padding: 40px 0;
      margin-top: 60px;
    }

    footer a {
      color: #ffe6f5;
      text-decoration: none;
      transition: 0.3s;
    }

    footer a:hover {
      color: white;
    }

    footer h6 {
      color: #fff;
      font-weight: 600;
      margin-bottom: 15px;
    }

    footer small {
      color: #c3f0d1;
    }
  </style>

  @stack('styles')
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">RSHP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/layanan') }}" class="nav-link {{ request()->is('layanan') ? 'active' : '' }}">Layanan</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/struktur') }}" class="nav-link {{ request()->is('struktur') ? 'active' : '' }}">Struktur</a>
          </li>
          <li class="nav-item">
            <a href="{{ url('/kontak') }}" class="nav-link {{ request()->is('kontak') ? 'active' : '' }}">Kontak</a>
          </li>

          @guest
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link {{ request()->is('login') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link {{ request()->is('register') ? 'active' : '' }}">
                <i class="bi bi-person-plus me-1"></i> Register
              </a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                 data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                 <i class="bi bi-person-circle me-1"></i>
                 {{ session('user_name') ?? Auth::user()->name }}
              </a>

              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                  <a class="dropdown-item" href="#"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                     <i class="fas fa-sign-out-alt me-1"></i> Logout
                  </a>
                </li>
              </ul>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="py-4">
    @yield('content')
  </main>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h6>RSHP</h6>
          <p>Rumah Sakit Hewan Pendidikan memberikan pelayanan terbaik bagi hewan kesayangan Anda.</p>
        </div>
        <div class="col-md-4 mb-3">
          <h6>Menu</h6>
          <ul class="list-unstyled">
            <li><a href="{{ url('/layanan') }}">Layanan</a></li>
            <li><a href="{{ url('/struktur') }}">Struktur</a></li>
            <li><a href="{{ url('/kontak') }}">Kontak</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h6>Kontak</h6>
          <p>Email: info@rshp.com</p>
          <p>Telepon: (031) 123-4567</p>
        </div>
      </div>
      <div class="text-center mt-3">
        <small>© {{ date('Y') }} RSHP. All rights reserved.</small>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>