@extends('layouts.lte.main')

@section('title','Dashboard Perawat')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-6">
                <h2 class="mb-0">Dashboard Perawat</h2>
                <p class="text-muted">Ringkasan tugas & antrian hari ini.</p>
            </div>
            <div class="col-sm-6 text-end">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Perawat</li>
                </ol>
            </div>
        </div>

    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        {{-- Ringkasan Card --}}
        <div class="row g-3 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="small-box text-bg-primary position-relative p-3">
                    <div class="inner">
                        <h3>{{ $totalPasienHariIni }}</h3>
                        <p>Pasien Hari Ini</p>
                    </div>
                    <div class="position-absolute" style="right:12px;top:12px;opacity:0.15;font-size:64px">🐾</div>
                    <a href="{{ route('perawat.pasien.index') }}" class="small-box-footer">Lihat Pasien</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="small-box text-bg-success position-relative p-3">
                    <div class="inner">
                        <h3>{{ $totalTindakanHariIni }}</h3>
                        <p>Tindakan Hari Ini</p>
                    </div>
                    <div class="position-absolute" style="right:12px;top:12px;opacity:0.15;font-size:64px">📝</div>
                    <a href="#" class="small-box-footer">Detail</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="small-box text-bg-warning position-relative p-3">
                    <div class="inner">
                        <h3>{{ $totalRekamMedis }}</h3>
                        <p>Total Rekam Medis</p>
                    </div>
                    <div class="position-absolute" style="right:12px;top:12px;opacity:0.15;font-size:64px">📚</div>
                    <a href="#" class="small-box-footer">Lihat Semua</a>
                </div>
            </div>

        </div>

        {{-- Tabel Antrian --}}
        <div class="card">
            <div class="card-header"><h3 class="card-title mb-0">Antrian Hari Ini</h3></div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No Urut</th>
                                <th>Hewan</th>
                                <th>Pemilik</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($antrianToday as $a)
                                <tr>
                                    <td><strong>{{ $a->no_urut }}</strong></td>
                                    <td>{{ $a->nama_pet }}</td>
                                    <td>{{ $a->nama_pemilik }}</td>
                                    <td>{{ $a->nama_dokter ?? '-' }}</td>

                                    <td>
                                        @if($a->status == 'S')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($a->status == 'B')
                                            <span class="badge bg-danger">Batal</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @endif
                                    </td>

                                    <td>{{ \Carbon\Carbon::parse($a->waktu_daftar)->format('H:i') }}</td>

                                    <td>
                                        <a href="{{ route('perawat.rekam-medis.index', $a->idreservasi_dokter) }}"
                                           class="btn btn-sm btn-primary">Rekam</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-3">Tidak ada antrian hari ini</td></tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
