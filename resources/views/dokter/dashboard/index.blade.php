@extends('layouts.lte.main')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Dokter</h3>
                <p class="text-muted">Selamat datang, drh. {{ auth()->user()->nama }}</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard Dokter</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <!-- Doctor Widgets -->
        <div class="row">

            <!-- Antrian Hari Ini -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $countAntrianToday }}</h3>
                        <p>Antrian Hari Ini</p>
                    </div>
                    <img src="{{ asset('assets/icons/vet-queue.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="{{ route('dokter.pasien.index') }}" class="small-box-footer">
                        Lihat Antrian <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>

            <!-- Total Pasien -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $totalPasien }}</h3>
                        <p>Total Pasien Ditangani</p>
                    </div>
                    <img src="{{ asset('assets/icons/pets.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="{{ route('dokter.pasien.index') }}" class="small-box-footer">
                        Lihat Pasien <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>

            <!-- Rekam Medis Dokter -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $totalRekam }}</h3>
                        <p>Rekam Medis Dibuat</p>
                    </div>
                    <img src="{{ asset('assets/icons/medical-file.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="{{ route('dokter.rekam.index') }}" class="small-box-footer text-dark">
                        Lihat Rekam <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>

            <!-- Total Rekam Keseluruhan -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{ $totalRekamGlobal }}</h3>
                        <p>Total Rekam Sistem</p>
                    </div>
                    <img src="{{ asset('assets/icons/clinic-folder.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="{{ route('dokter.rekam.index') }}" class="small-box-footer">
                        Selengkapnya <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Jadwal Terdekat -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Terdekat</h3>
                    </div>
                    <div class="card-body">
                        @if($upcoming->isEmpty())
                            <p class="text-muted">Tidak ada jadwal hari ini.</p>
                        @else
                            <ul class="list-group">
                                @foreach($upcoming as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->pet_nama }}</strong><br>
                                        <small class="text-muted">
                                            Pemilik: {{ $item->pemilik_nama }} • WA: {{ $item->no_wa }}
                                        </small>
                                    </div>
                                    <span class="badge bg-primary">No {{ $item->no_urut }}</span>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm text-bg-light">
                    <div class="card-body">
                        <h5 class="mb-3">Tips Klinik Hari Ini</h5>
                        <ul>
                            <li>Periksa riwayat vaksinasi saat melakukan pemeriksaan umum.</li>
                            <li>Catat perubahan perilaku hewan yang diceritakan pemilik.</li>
                            <li>Selalu cek suhu, nadi, pernafasan — data vital penting.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
