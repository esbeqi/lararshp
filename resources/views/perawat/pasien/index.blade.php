@extends('layouts.lte.main')

@section('title','Pasien Hari Ini')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Pasien Hari Ini</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form class="mb-3" method="GET" action="{{ route('perawat.pasien.index') }}">
        <div class="row g-2">
          <div class="col-md-3">
            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
          </div>
        </div>
      </form>

      <div class="card">
        <div class="card-header"><h3 class="card-title mb-0">Daftar Antrian</h3></div>
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
                  <th style="width:120px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pasien as $p)
                  <tr>
                    <td><strong>{{ $p->no_urut }}</strong></td>
                    <td>{{ $p->nama_pet }}</td>
                    <td>{{ $p->nama_pemilik }}</td>
                    <td>{{ $p->nama_dokter ?? '-' }}</td>
                    <td>
                      @if($p->status == 'S')<span class="badge bg-success">Selesai</span>
                      @elseif($p->status == 'B')<span class="badge bg-danger">Batal</span>
                      @else<span class="badge bg-warning text-dark">Menunggu</span>@endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($p->waktu_daftar)->format('H:i') }}</td>
                    <td>
                      <a href="{{ route('perawat.rekam-medis.index', $p->idreservasi_dokter) }}" class="btn btn-sm btn-primary">Buka Rekam</a>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada antrian</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-footer">
          {{ $pasien->links() }}
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
