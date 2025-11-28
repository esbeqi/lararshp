<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}" 
                 alt="AdminLTE Logo" 
                 class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light">RSHP Admin</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master Data Header -->
                <li class="nav-header">MASTER DATA</li>

                <!-- Master Data Group -->
                <li class="nav-item
                    {{
                        request()->routeIs('admin.user.*') ||
                        request()->routeIs('admin.role-user.*') ||
                        request()->routeIs('admin.jenis-hewan.*') ||
                        request()->routeIs('admin.ras-hewan.*') ||
                        request()->routeIs('admin.pemilik.*') ||
                        request()->routeIs('admin.pet.*') ||
                        request()->routeIs('admin.kategori.*') ||
                        request()->routeIs('admin.kategori-klinis.*') ||
                        request()->routeIs('admin.kode-tindakan-terapi.*')
                        ? 'menu-open'
                        : ''
                    }}">

                    <a href="#" 
                       class="nav-link
                        {{
                            request()->routeIs('admin.user.*') ||
                            request()->routeIs('admin.role-user.*') ||
                            request()->routeIs('admin.jenis-hewan.*') ||
                            request()->routeIs('admin.ras-hewan.*') ||
                            request()->routeIs('admin.pemilik.*') ||
                            request()->routeIs('admin.pet.*') ||
                            request()->routeIs('admin.kategori.*') ||
                            request()->routeIs('admin.kategori-klinis.*') ||
                            request()->routeIs('admin.kode-tindakan-terapi.*')
                            ? 'active'
                            : ''
                        }}">
                        <i class="nav-icon bi bi-grid"></i>
                        <p>
                            Master Data
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <!-- 1. Data User -->
                        <a href="{{ route('admin.user.index') }}"
                           class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Data User</p>
                        </a>

                        <!-- 2. Manajemen Role -->
                        <a href="{{ route('admin.role-user.index') }}"
                           class="nav-link {{ request()->routeIs('admin.role-user.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Manajemen Role</p>
                        </a>

                        <!-- 3. Jenis Hewan -->
                        <a href="{{ route('admin.jenis-hewan.index') }}"
                           class="nav-link {{ request()->routeIs('admin.jenis-hewan.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Jenis Hewan</p>
                        </a>

                        <!-- 4. Ras Hewan -->
                        <a href="{{ route('admin.ras-hewan.index') }}"
                           class="nav-link {{ request()->routeIs('admin.ras-hewan.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Ras Hewan</p>
                        </a>

                        <!-- 5. Data Pemilik -->
                        <a href="{{ route('admin.pemilik.index') }}"
                           class="nav-link {{ request()->routeIs('admin.pemilik.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Data Pemilik</p>
                        </a>

                        <!-- 6. Data Pet -->
                        <a href="{{ route('admin.pet.index') }}"
                           class="nav-link {{ request()->routeIs('admin.pet.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Data Pet</p>
                        </a>

                        <!-- 7. Data Kategori -->
                        <a href="{{ route('admin.kategori.index') }}"
                           class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Data Kategori</p>
                        </a>

                        <!-- 8. Data Kategori Klinis -->
                        <a href="{{ route('admin.kategori-klinis.index') }}"
                           class="nav-link {{ request()->routeIs('admin.kategori-klinis.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Data Kategori Klinis</p>
                        </a>

                        <!-- 9. Data Kode Tindakan Terapi (NEW) -->
                        <a href="{{ route('admin.kode-tindakan-terapi.index') }}"
                           class="nav-link {{ request()->routeIs('admin.kode-tindakan-terapi.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>Data Kode Tindakan Terapi</p>
                        </a>

                    </ul>
                </li>

                <!-- Rekam Medis -->
                <li class="nav-header">REKAM MEDIS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-journal-medical"></i>
                        <p>#</p>
                    </a>
                </li>

                <!-- Documentation -->
                <li class="nav-header">DOCUMENTATION</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Manual Book</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-question-circle"></i>
                        <p>FAQ</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>