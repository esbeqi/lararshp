<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}"
                 alt="Admin Logo"
                 class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">RSHP Admin</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                role="navigation"
                data-accordion="false">

                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- MASTER DATA -->
                <li class="nav-header">MASTER DATA</li>

                <li class="nav-item">
                    <a href="{{ route('admin.user.index') }}"
                       class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Data User</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.role-user.index') }}"
                       class="nav-link {{ request()->routeIs('admin.role-user.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>Manajemen Role</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.jenis-hewan.index') }}"
                       class="nav-link {{ request()->routeIs('admin.jenis-hewan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-dog"></i>
                        <p>Jenis Hewan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.ras-hewan.index') }}"
                       class="nav-link {{ request()->routeIs('admin.ras-hewan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cat"></i>
                        <p>Ras Hewan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.pemilik.index') }}"
                       class="nav-link {{ request()->routeIs('admin.pemilik.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pemilik</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.pet.index') }}"
                       class="nav-link {{ request()->routeIs('admin.pet.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-paw"></i>
                        <p>Data Pet</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.kategori.index') }}"
                       class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Data Kategori</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.kategori-klinis.index') }}"
                       class="nav-link {{ request()->routeIs('admin.kategori-klinis.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-notes-medical"></i>
                        <p>Data Kategori Klinis</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.kode-tindakan-terapi.index') }}"
                       class="nav-link {{ request()->routeIs('admin.kode-tindakan-terapi.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-syringe"></i>
                        <p>Data Kode Tindakan</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
