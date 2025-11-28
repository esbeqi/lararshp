@extends('layouts.lte.main')
@section('title','Daftar Detail Rekam Medis')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Daftar Detail Rekam Medis</h1>
      <p class="text-muted">Gabungan: Rekam Medis + Pet/Pemilik + Kode Tindakan + Kategori</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
      @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

      <div class="card mb-3">
        <div class="card-body">
          <form method="GET" action="{{ route('perawat.rekam-medis.details.index') }}" class="row g-2 align-items-end">
            <div class="col-auto">
              <label>Filter Pet (nama)</label>
              <input type="text" name="pet" value="{{ request('pet') }}" class="form-control" placeholder="Nama pet">
            </div>
            <div class="col-auto">
              <button class="btn btn-primary">Filter</button>
            </div>
            <div class="col text-end">
              <a href="{{ route('perawat.rekam-medis.details.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Tabel Detail</h3>
          <div>
            <a href="{{ route('perawat.rekam-medis.details.index') }}" class="btn btn-sm btn-light">Refresh</a>
            <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-sm btn-success">Buat Rekam Medis Baru</a>
          </div>
        </div>

        <div class="card-body table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>No. Urut</th>
                <th>Pet</th>
                <th>Pemilik</th>
                <th>Dokter</th>
                <th>Kode</th>
                <th>Tindakan</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
                <th>Keterangan</th>
                <th width="160px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($details as $d)
              <tr>
                <td>{{ $loop->iteration + ($details->currentPage()-1) * $details->perPage() }}</td>
                <td>{{ $d->no_urut }}</td>
                <td>{{ $d->nama_pet }}</td>
                <td>{{ $d->nama_pemilik }}</td>
                <td>{{ $d->nama_dokter ?? '-' }}</td>
                <td>{{ $d->kode }}</td>
                <td>{{ $d->deskripsi_tindakan_terapi }}</td>
                <td>{{ $d->nama_kategori }}</td>
                <td>{{ $d->nama_kategori_klinis }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>
                  <a href="{{ route('perawat.rekam-medis.detail', $d->idrekam_medis) }}" class="btn btn-sm btn-info">Lihat Header</a>
                  <a href="{{ route('perawat.rekam-medis.edit-detail', $d->iddetail_rekam_medis) }}" class="btn btn-sm btn-warning">Edit</a>

                  <form action="{{ route('perawat.rekam-medis.delete-tindakan', $d->iddetail_rekam_medis) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus tindakan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="11" class="text-center text-muted">Belum ada data tindakan</td></tr>
              @endforelse
            </tbody>
          </table>

          <div class="mt-3">
            {{ $details->links() }}
          </div>
        </div>
      </div>

      {{-- Optional: small standalone create form is already inside this blade in previous suggestion.
           If you prefer, keep it or remove it. --}}
    </div>
  </section>
</div>
@endsection
