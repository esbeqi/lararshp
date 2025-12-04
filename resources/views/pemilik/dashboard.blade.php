@extends('layouts.lte.main')
@section('title','Dashboard Pemilik')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Dashboard Pemilik</h1>
      <p class="text-muted">Selamat datang, {{ auth()->user()->nama ?? 'Pemilik' }}</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="row mb-3">
        <div class="col-lg-4 col-md-6 mb-2">
          <div class="small-box text-bg-primary p-3">
            <div class="inner">
              <h3>{{ $stats->total_pet ?? 0 }}</h3>
              <p>Total Pet</p>
            </div>
            <div class="small-box-footer">
              <a href="{{ route('pemilik.pet.index') }}" class="link-light">Lihat Pet →</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-2">
          <div class="small-box text-bg-success p-3">
            <div class="inner">
              <h3>{{ $stats->total_rekam ?? 0 }}</h3>
              <p>Rekam Medis</p>
            </div>
            <div class="small-box-footer">
              <a href="{{ route('pemilik.pet.index') }}" class="link-light">Lihat Rekam →</a>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-2">
          <div class="small-box text-bg-warning p-3">
            <div class="inner">
              <h3>{{ $stats->upcoming_temu ?? 0 }}</h3>
              <p>Janji Hari Ini</p>
            </div>
            <div class="small-box-footer">
              <a href="{{ route('pemilik.pet.index') }}" class="link-dark">Lihat Janji →</a>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Daftar Pet Saya</h3>
        </div>

        <div class="card-body">
          @if($pets->isEmpty())
            <div class="text-center text-muted">Belum ada data pet.</div>
          @else
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jenis</th>
                    <th>Tgl. Lahir</th>
                    <th width="180px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pets as $p)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $p->nama ?? '-' }}</td>
                      <td>{{ $p->nama_jenis_hewan ?? ($p->jenis_hewan ?? '-') }}</td>
                      <td>{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                      <td>
                        <a href="{{ route('pemilik.pet.show', $p->idpet) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pemilik.pet.rekam.index', $p->idpet) }}" class="btn btn-sm btn-primary">Rekam Medis</a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
