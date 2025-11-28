<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard Admin | RSHP')</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root {
      --green: #1b602f;
      --pink: #f784c5;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fafb;
      color: #333;
    }

    .navbar {
      background-color: var(--green);
      padding: 10px 0;
    }

    .navbar-brand {
      font-weight: 700;
      color: #fff !important;
    }

    .navbar-brand:hover {
      color: #f3f3f3 !important;
    }

    .btn-logout {
      color: #fff;
      font-weight: 500;
      text-decoration: none;
    }

    .btn-logout:hover {
      text-decoration: underline;
    }

    .container {
      margin-top: 30px;
    }

    footer {
      background-color: var(--green);
      color: white;
      padding: 20px 0;
      margin-top: 50px;
      text-align: center;
    }
  </style>

  @stack('styles')
</head>
<body>
  <!-- NAVBAR ADMIN -->
  <nav class="navbar navbar-expand-lg">
    <div class="container d-flex justify-content-between align-items-center">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>

      @auth
        <a href="#" class="btn-logout" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      @endauth
    </div>
  </nav>

  <!-- MAIN CONTENT -->
  <main class="container py-4">
    @yield('content')
  </main>

  <footer>
    <small>© {{ date('Y') }} RSHP Admin Panel</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>