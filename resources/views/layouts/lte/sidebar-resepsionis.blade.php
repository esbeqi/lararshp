<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">
        <a href="{{ route('resepsionis.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}"
                 class="brand-image opacity-75 shadow" alt="Logo"/>
            <span class="brand-text fw-light">Panel Resepsionis</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column">

                <li class="nav-item">
                    <a href="{{ route('resepsionis.dashboard') }}"
                       class="nav-link {{ request()->routeIs('resepsionis.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">DATA PASIEN</li>

                <li class="nav-item">
                    <a href="{{ route('resepsionis.pemilik.index') }}"
                       class="nav-link {{ request()->routeIs('resepsionis.pemilik.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person"></i>
                        <p>Data Pemilik</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('resepsionis.pet.index') }}"
                       class="nav-link {{ request()->routeIs('resepsionis.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-git"></i>
                        <p>Data Hewan (Pet)</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('resepsionis.temu-dokter.index') }}"
                       class="nav-link {{ request()->routeIs('resepsionis.temu-dokter.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-calendar-check"></i>
                        <p>Temu Dokter (Antrian)</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
