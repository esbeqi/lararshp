@extends('layouts.lte.main')
@section('title','Detail Rekam Medis')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Detail Rekam Medis</h1>
      <p class="text-muted">#{{ $header->idrekam_medis ?? '-' }} — Pet: {{ $header->nama_pet ?? '-' }}</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="card mb-3">
        <div class="card-header"><h3 class="card-title">Header Rekam Medis</h3></div>
        <div class="card-body">
          <table class="table table-bordered" style="max-width:900px">
            <tbody>
              <tr><th style="width:220px">No. Urut</th><td>{{ $header->no_urut ?? '-' }}</td></tr>
              <tr><th>Pet</th><td>{{ $header->nama_pet ?? '-' }}</td></tr>
              <tr><th>Dokter Pemeriksa</th><td>{{ $header->nama_dokter ?? '-' }}</td></tr>
              <tr><th>Anamnesa</th><td>{{ $header->anamnesa ?? '-' }}</td></tr>
              <tr><th>Temuan Klinis</th><td>{{ $header->temuan_klinis ?? '-' }}</td></tr>
              <tr><th>Diagnosa</th><td>{{ $header->diagnosa ?? '-' }}</td></tr>
              <tr><th>Tanggal</th><td>{{ !empty($header->created_at) ? \Carbon\Carbon::parse($header->created_at)->format('d/m/Y H:i') : '-' }}</td></tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><h3 class="card-title">Detail Tindakan</h3></div>
        <div class="card-body">
          @if(empty($detail) || $detail->isEmpty())
            <div class="text-center text-muted">Belum ada tindakan tercatat.</div>
          @else
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Tindakan</th>
                    <th>Kategori</th>
                    <th>Kategori Klinis</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($detail as $d)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $d->kode ?? '-' }}</td>
                      <td>{{ $d->deskripsi_tindakan_terapi ?? '-' }}</td>
                      <td>{{ $d->nama_kategori ?? '-' }}</td>
                      <td>{{ $d->nama_kategori_klinis ?? '-' }}</td>
                      <td>{{ $d->keterangan ?? '-' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif

          <a href="{{ route('pemilik.pet.rekam.index', $header->idpet ?? null) }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
