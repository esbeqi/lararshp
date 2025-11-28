<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('dokter.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/vet-icon.png') }}" 
                 alt="Dokter Logo"
                 class="brand-image opacity-75 shadow" />

            <span class="brand-text fw-light">Panel Dokter</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Sidebar Dokter"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dokter.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Pasien -->
                <li class="nav-item">
                    <a href="{{ route('dokter.pasien.index') }}" 
                       class="nav-link {{ request()->routeIs('dokter.pasien.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Daftar Pasien</p>
                    </a>
                </li>

                <!-- Rekam Medis -->
                <li class="nav-item">
                    <a href="{{ route('dokter.rekam.index') }}" 
                       class="nav-link {{ request()->routeIs('dokter.rekam.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-medical"></i>
                        <p>Rekam Medis</p>
                    </a>
                </li>

                <!-- Profile -->
                <li class="nav-item">
                    <a href="{{ route('dokter.profile.show') }}" 
                       class="nav-link {{ request()->routeIs('dokter.profile.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>

                <!-- Manual/FAQ -->
                <li class="nav-header">BANTUAN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Manual Book</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
