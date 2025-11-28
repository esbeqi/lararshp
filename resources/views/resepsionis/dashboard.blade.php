@extends('layouts.lte.main')

@section('title', 'Dashboard Resepsionis')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h2 class="mb-0">Dashboard Resepsionis</h2>
        <p class="text-muted">Ringkasan cepat aktivitas harian.</p>
      </div>
      <div class="col-sm-6 text-end">
        <ol class="breadcrumb float-sm-end">
          {{-- jika tidak punya route('home'), gunakan url('/') --}}
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    <div class="row g-3 mb-4">
      <div class="col-lg-3 col-md-6">
        <div class="small-box text-bg-primary position-relative" style="min-height:110px;">
          <div class="inner p-3">
            <h3 class="mb-1">{{ $totalPemilik ?? 0 }}</h3>
            <p class="mb-0">Total Pemilik</p>
          </div>
          {{-- safe default: use text if icons missing --}}
          <div class="small-box-icon" style="position:absolute;right:12px;top:12px;opacity:.12;font-size:64px">
            🧑‍🤝‍🧑
          </div>
          <a href="{{ route('resepsionis.pemilik.index') }}" class="small-box-footer d-block text-center py-2">Lihat Data</a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="small-box text-bg-success position-relative" style="min-height:110px;">
          <div class="inner p-3">
            <h3 class="mb-1">{{ $totalPet ?? 0 }}</h3>
            <p class="mb-0">Total Hewan (Pet)</p>
          </div>
          <div class="small-box-icon" style="position:absolute;right:12px;top:12px;opacity:.12;font-size:64px">
            🐾
          </div>
          <a href="{{ route('resepsionis.pet.index') }}" class="small-box-footer d-block text-center py-2">Lihat Data</a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="small-box text-bg-warning position-relative" style="min-height:110px;">
          <div class="inner p-3">
            <h3 class="mb-1">{{ $totalDokter ?? 0 }}</h3>
            <p class="mb-0">Dokter Aktif</p>
          </div>
          <div class="small-box-icon" style="position:absolute;right:12px;top:12px;opacity:.12;font-size:64px">
            🩺
          </div>
          <a href="{{ route('resepsionis.temu-dokter.index') }}" class="small-box-footer d-block text-center py-2">Info Dokter</a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="small-box text-bg-danger position-relative" style="min-height:110px;">
          <div class="inner p-3">
            <h3 class="mb-1">{{ $totalAntrian ?? 0 }}</h3>
            <p class="mb-0">Antrian Hari Ini</p>
          </div>
          <div class="small-box-icon" style="position:absolute;right:12px;top:12px;opacity:.12;font-size:64px">
            📋
          </div>
          <a href="{{ route('resepsionis.temu-dokter.index') }}" class="small-box-footer d-block text-center py-2">Kelola Antrian</a>
        </div>
      </div>
    </div>

    {{-- Tabel antrian sederhana --}}
    <div class="card">
      <div class="card-header"><h3 class="card-title mb-0">Antrian Hari Ini</h3></div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:90px">No Urut</th>
                <th>Hewan</th>
                <th>Pemilik</th>
                <th>Dokter</th>
                <th style="width:120px">Status</th>
                <th style="width:140px">Waktu</th>
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
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">Belum ada antrian hari ini</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
