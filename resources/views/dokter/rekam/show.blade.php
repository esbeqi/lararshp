@extends('layouts.lte.main')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Detail Rekam Medis - {{ $rekam->pet_nama ?? '-' }}</h1>
      <p>Pemilik: {{ $rekam->pemilik_nama ?? '-' }}</p>
      <p>Dokter Pemeriksa: {{ $rekam->nama_dokter ?? '-' }}</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      {{-- HEADER --}}
      <div class="card mb-4">
        <div class="card-header"><h3 class="card-title">Header Rekam Medis</h3></div>
        <div class="card-body">
          <table class="table table-borderless">
            <tr><th style="width:200px">No. Urut</th><td>{{ $rekam->no_urut ?? '-' }}</td></tr>
            <tr><th>Tanggal</th><td>{{ isset($rekam->created_at) ? \Carbon\Carbon::parse($rekam->created_at)->format('Y-m-d H:i') : '-' }}</td></tr>
            <tr><th>Anamnesa</th><td>{{ $rekam->anamnesa ?? '-' }}</td></tr>
            <tr><th>Temuan Klinis</th><td>{{ $rekam->temuan_klinis ?? '-' }}</td></tr>
            <tr><th>Diagnosa</th><td>{{ $rekam->diagnosa ?? '-' }}</td></tr>
          </table>
        </div>
      </div>

      {{-- DETAIL TINDAKAN (read-only) --}}
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Tindakan</h3>
        </div>
        <div class="card-body">
          @if($detail->isEmpty())
            <p class="text-muted">Belum ada tindakan tercatat.</p>
          @else
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th style="width:60px">#</th>
                  <th>Kode</th>
                  <th>Tindakan</th>
                  <th>Kategori</th>
                  <th>Kategori Klinis</th>
                  <th>Keterangan</th>
                  <th style="width:160px">Waktu</th>
                </tr>
              </thead>
              <tbody>
                @foreach($detail as $i => $d)
                <tr>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ $d->kode ?? '-' }}</td>
                  <td>{{ $d->tindakan ?? ($d->deskripsi_tindakan_terapi ?? '-') }}</td>
                  <td>{{ $d->nama_kategori ?? '-' }}</td>
                  <td>{{ $d->nama_kategori_klinis ?? '-' }}</td>
                  <td>{{ $d->keterangan ?? '-' }}</td>
                  <td>{{ isset($d->created_at) ? \Carbon\Carbon::parse($d->created_at)->format('Y-m-d H:i') : '-' }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          @endif
        </div>
      </div>

      <a href="{{ route('dokter.rekam.index') }}" class="btn btn-secondary">Kembali</a>

    </div>
  </section>
</div>
@endsection
