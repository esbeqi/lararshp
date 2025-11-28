<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('pemilik.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}"
                 alt="Logo"
                 class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">RSHP Pemilik</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main Navigation"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('pemilik.dashboard') }}"
                       class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Profil Saya --}}
                <li class="nav-item">
                    <a href="{{ route('pemilik.profil.show') }}"
                       class="nav-link {{ request()->routeIs('pemilik.profil.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-circle"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                {{-- Pet --}}
                <li class="nav-item">
                    <a href="{{ route('pemilik.pet.index') }}"
                       class="nav-link {{ request()->routeIs('pemilik.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-paw"></i>
                        <p>Daftar Hewan Peliharaan</p>
                    </a>
                </li>

                {{-- Riwayat Rekam Medis --}}
                <li class="nav-item">
                    <a href="{{ route('pemilik.rekam.index') }}"
                       class="nav-link {{ request()->routeIs('pemilik.rekam.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-medical"></i>
                        <p>Riwayat Rekam Medis</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
