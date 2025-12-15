@php
    $role = DB::table('role_user')
        ->join('role', 'role_user.idrole', '=', 'role.idrole')
        ->where('role_user.iduser', auth()->id())
        ->value('role.nama_role');
@endphp

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    {{-- ================= BRAND ================= --}}
    <div class="sidebar-brand">
        <a href="{{ url('/') }}" class="brand-link">
            <img src="{{ asset('assets/img/AdminLTELogo.png') }}"
                 class="brand-image opacity-75 shadow" alt="Logo">
            <span class="brand-text fw-light">RSHP</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" role="navigation" data-accordion="false">

                {{-- ================================================= --}}
                {{-- ================= ADMIN ========================= --}}
                {{-- ================================================= --}}
                @if($role === 'Administrator')

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

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

                {{-- ================================================= --}}
                {{-- ================= DOKTER ======================== --}}
                {{-- ================================================= --}}
                @elseif($role === 'Dokter')

                    <li class="nav-item">
                        <a href="{{ route('dokter.dashboard') }}"
                           class="nav-link {{ request()->routeIs('dokter.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dokter.pasien.index') }}"
                           class="nav-link {{ request()->routeIs('dokter.pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Daftar Pasien</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dokter.rekam.index') }}"
                           class="nav-link {{ request()->routeIs('dokter.rekam.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-journal-medical"></i>
                            <p>Rekam Medis</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dokter.profile.show') }}"
                           class="nav-link {{ request()->routeIs('dokter.profile.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-badge"></i>
                            <p>Profil Saya</p>
                        </a>
                    </li>

                {{-- ================================================= --}}
                {{-- ================= PERAWAT ======================= --}}
                {{-- ================================================= --}}
                @elseif($role === 'Perawat')

                    <li class="nav-item">
                        <a href="{{ route('perawat.dashboard') }}"
                           class="nav-link {{ request()->routeIs('perawat.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('perawat.pasien.index') }}"
                           class="nav-link {{ request()->routeIs('perawat.pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-people"></i>
                            <p>Pasien Hari Ini</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('perawat.rekam-medis.index') }}"
                           class="nav-link {{ request()->routeIs('perawat.rekam-medis.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-file-medical"></i>
                            <p>Rekam Medis</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('perawat.profil.show') }}"
                           class="nav-link {{ request()->routeIs('perawat.profil.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-circle"></i>
                            <p>Profil Saya</p>
                        </a>
                    </li>

                {{-- ================================================= --}}
                {{-- ================= RESEPSIONIS =================== --}}
                {{-- ================================================= --}}
                @elseif($role === 'Resepsionis')

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
                            <i class="nav-icon fas fa-paw"></i>
                            <p>Data Hewan (Pet)</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('resepsionis.temu-dokter.index') }}"
                           class="nav-link {{ request()->routeIs('resepsionis.temu-dokter.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-calendar-check"></i>
                            <p>Temu Dokter</p>
                        </a>
                    </li>

                {{-- ================================================= --}}
                {{-- ================= PEMILIK ======================= --}}
                {{-- ================================================= --}}
                @elseif($role === 'Pemilik')

                    <li class="nav-item">
                        <a href="{{ route('pemilik.dashboard') }}"
                           class="nav-link {{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pemilik.profil.show') }}"
                           class="nav-link {{ request()->routeIs('pemilik.profil.*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person-circle"></i>
                            <p>Profil Saya</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pemilik.pet.index') }}"
                           class="nav-link {{ request()->routeIs('pemilik.pet.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-dog"></i>
                            <p>Daftar Hewan Peliharaan</p>
                        </a>
                    </li>

                    @php
                        $pemilik = DB::table('pemilik')->where('iduser', auth()->id())->first();
                        $firstPet = $pemilik
                            ? DB::table('pet')->where('idpemilik', $pemilik->idpemilik)->first()
                            : null;
                    @endphp

                    <li class="nav-item">
                        <a href="{{ $firstPet ? route('pemilik.pet.rekam.index',$firstPet->idpet) : route('pemilik.pet.index') }}"
                           class="nav-link {{ request()->is('pemilik/pet/*/rekam-medis*') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-journal-medical"></i>
                            <p>Riwayat Rekam Medis</p>
                        </a>
                    </li>

                @endif

            </ul>
        </nav>
    </div>
</aside>
