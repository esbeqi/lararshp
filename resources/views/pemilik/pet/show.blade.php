@extends('layouts.lte.main')
@section('title','Detail Pet')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Detail Pet: {{ $pet->nama }}</h1>
      <p class="text-muted">Detail lengkap hewan Anda</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="row">
        <div class="col-lg-6">
          <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Informasi Umum</h3></div>
            <div class="card-body">
              <table class="table table-bordered" style="max-width:540px">
                <tbody>
                  <tr><th width="200">Nama</th><td>{{ $pet->nama ?? '-' }}</td></tr>
                  <tr><th>Jenis Hewan</th><td>{{ $pet->nama_jenis_hewan ?? ($pet->jenis_hewan ?? '-') }}</td></tr>
                  <tr><th>Ras</th><td>{{ $pet->nama_ras_hewan ?? ($pet->nama_ras ?? '-') }}</td></tr>
                  <tr><th>Tanggal Lahir</th><td>{{ $pet->tanggal_lahir ? \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d/m/Y') : '-' }}</td></tr>
                  <tr><th>Jenis Kelamin</th><td>{{ $pet->jenis_kelamin ?? '-' }}</td></tr>
                  <tr><th>Warna</th><td>{{ $pet->warna ?? '-' }}</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <a href="{{ route('pemilik.pet.rekam.index', $pet->idpet) }}" class="btn btn-primary mb-3">Lihat Rekam Medis</a>
          <a href="{{ route('pemilik.pet.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Pet</a>
        </div>

        <div class="col-lg-6">
          <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Informasi Pemilik</h3></div>
            <div class="card-body">
              <p>Nama Pemilik: {{ $pet->pemilik_nama ?? $pet->pemilik_nama ?? '-' }}</p>
              <p>No. HP: {{ $pet->pemilik_no_hp ?? '-' }}</p>
              <p>Email: {{ $pet->pemilik_email ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
