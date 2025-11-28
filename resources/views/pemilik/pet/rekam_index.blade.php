@extends('layouts.lte.main')
@section('title','Rekam Medis Pet')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Rekam Medis - Pet #{{ $idpet }}</h1>
      <p class="text-muted">Daftar rekam medis untuk hewan ini</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Daftar Rekam Medis</h3>
          <div>
            <a href="{{ route('pemilik.pet.show', $idpet) }}" class="btn btn-sm btn-secondary">Kembali ke Pet</a>
          </div>
        </div>

        <div class="card-body">
          @if($rekam->isEmpty())
            <div class="text-center text-muted">Belum ada rekam medis untuk pet ini.</div>
          @else
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>No. Urut</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th width="140px">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($rekam as $r)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $r->no_urut ?? '-' }}</td>
                      <td>{{ $r->nama_dokter ?? '-' }}</td>
                      <td>{{ $r->created_at ? \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i') : '-' }}</td>
                      <td>
                        <a href="{{ route('pemilik.rekam.show', $r->idrekam_medis) }}" class="btn btn-sm btn-info">Lihat</a>
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
