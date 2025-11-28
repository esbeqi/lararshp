<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!-- Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('perawat.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">RSHP Perawat</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('perawat.dashboard') }}"
                       class="nav-link {{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Pasien Hari Ini -->
                <li class="nav-item">
                    <a href="{{ route('perawat.pasien.index') }}"
                       class="nav-link {{ request()->routeIs('perawat.pasien.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Pasien Hari Ini</p>
                    </a>
                </li>

                <!-- Rekam Medis -->
                <li class="nav-item">
                    <a href="{{ route('perawat.rekam-medis.index') }}"
                       class="nav-link {{ request()->routeIs('perawat.rekam-medis.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-medical"></i>
                        <p>Rekam Medis</p>
                    </a>
                </li>

                <!-- Profil -->
                <li class="nav-item">
                    <a href="{{ route('perawat.profil.show') }}"
                       class="nav-link {{ request()->routeIs('perawat.profil.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
