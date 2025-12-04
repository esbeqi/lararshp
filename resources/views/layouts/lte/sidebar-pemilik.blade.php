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
                        {{-- SVG paw --}}
                        <span class="nav-icon" style="width:1.2rem;display:inline-block;vertical-align:middle">
                          <svg width="18" height="18" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M4.5 2.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11.5 2.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                            <path d="M2.5 6.5a1.75 1.75 0 1 0 0 3.5 1.75 1.75 0 0 0 0-3.5zM13.5 6.5a1.75 1.75 0 1 0 0 3.5 1.75 1.75 0 0 0 0-3.5z"/>
                            <path d="M8 8.5c-2.2 0-4 1.6-4 3.5S5.8 15.5 8 15.5s4-1.6 4-3.5S10.2 8.5 8 8.5z"/>
                          </svg>
                        </span>
                        <p>Daftar Hewan Peliharaan</p>
                    </a>
                </li>

                {{-- Riwayat Rekam Medis --}}
                @php
                    // ambil first pet milik user untuk direct link (safe: ringan)
                    $pemilikRow = \Illuminate\Support\Facades\DB::table('pemilik')
                        ->where('iduser', auth()->id())
                        ->first();
                    $firstPet = null;
                    if ($pemilikRow) {
                        $firstPet = \Illuminate\Support\Facades\DB::table('pet')
                            ->where('idpemilik', $pemilikRow->idpemilik)
                            ->select('idpet')
                            ->orderBy('nama')
                            ->first();
                    }

                    // jika ada firstPet -> link langsung ke rekam pet itu
                    // jika tidak ada -> arah ke daftar pet (supaya user tahu harus tambah pet dulu)
                    $rekamUrl = $firstPet
                        ? route('pemilik.pet.rekam.index', $firstPet->idpet)
                        : route('pemilik.pet.index');
                @endphp

                <li class="nav-item">
                    <a href="{{ $rekamUrl }}"
                       class="nav-link {{ request()->is('pemilik/pet/*/rekam-medis*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-medical"></i>
                        <p>Riwayat Rekam Medis</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>

</aside>
