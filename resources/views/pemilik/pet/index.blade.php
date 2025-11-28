@extends('layouts.lte.main')
@section('title','Daftar Pet Saya')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Daftar Pet</h1>
      <p class="text-muted">Semua hewan yang terdaftar atas nama Anda</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Data Pet</h3>
        </div>

        <div class="card-body">
          @if($pets->isEmpty())
            <div class="text-center text-muted">Belum ada pet terdaftar.</div>
          @else
            <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jenis Hewan</th>
                    <th>Ras</th>
                    <th>Tanggal Lahir</th>
                    <th width="160px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($pets as $p)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $p->nama ?? '-' }}</td>
                      <td>{{ $p->nama_jenis_hewan ?? ($p->jenis_hewan ?? '-') }}</td>
                      <td>{{ $p->nama_ras_hewan ?? ($p->nama_ras ?? '-') }}</td>
                      <td>{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                      <td>
                        <a href="{{ route('pemilik.pet.show', $p->idpet) }}" class="btn btn-sm btn-info">Detail</a>
                        <a href="{{ route('pemilik.pet.rekam.index', $p->idpet) }}" class="btn btn-sm btn-primary">Rekam</a>
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
