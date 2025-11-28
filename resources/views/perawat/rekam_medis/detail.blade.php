@extends('layouts.lte.main')
@section('title','Detail Rekam Medis')

@section('content')
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <h1>Rekam Medis - {{ $antrian->nama_pet }}</h1>
      <p>Pemilik: {{ $antrian->nama_pemilik }}</p>
      <p>Dokter Pemeriksa: {{ $antrian->nama_dokter ?? '-' }}</p>
      <p>No. Urut: {{ $antrian->no_urut }}</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      {{-- HEADER RM --}}
      <div class="card mb-4">
        <div class="card-header"><h3 class="card-title">Header Rekam Medis</h3></div>
        <div class="card-body">
          <form method="POST" action="{{ route('perawat.rekam-medis.update', $antrian->idrekam_medis) }}">
            @csrf

            <div class="mb-3">
              <label>Anamnesa</label>
              <textarea name="anamnesa" class="form-control">{{ old('anamnesa', $antrian->anamnesa) }}</textarea>
            </div>

            <div class="mb-3">
              <label>Temuan Klinis</label>
              <textarea name="temuan_klinis" class="form-control">{{ old('temuan_klinis', $antrian->temuan_klinis) }}</textarea>
            </div>

            <div class="mb-3">
              <label>Diagnosa</label>
              <textarea name="diagnosa" class="form-control">{{ old('diagnosa', $antrian->diagnosa) }}</textarea>
            </div>

            <button class="btn btn-primary">Update Header</button>
            <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">Kembali</a>
          </form>
        </div>
      </div>

      {{-- DETAIL TINDAKAN --}}
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Detail Tindakan</h3>
            <div>
              <a href="{{ route('perawat.rekam-medis.details.index') }}" class="btn btn-sm btn-light">Tabel Semua Detail</a>
            </div>
        </div>

        <div class="card-body">

          {{-- Form tambah tindakan --}}
          <form method="POST" action="{{ route('perawat.rekam-medis.store-tindakan', $antrian->idrekam_medis) }}">
            @csrf

            <div class="mb-3">
              <label>Kode Tindakan</label>
              <select name="idkode_tindakan_terapi" class="form-control" required>
                <option value="">-- Pilih Kode --</option>
                @foreach($kodeTindakan as $k)
                <option value="{{ $k->idkode_tindakan_terapi }}">
                  {{ $k->kode }} - {{ $k->deskripsi_tindakan_terapi }}
                </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label>Keterangan</label>
              <textarea name="keterangan" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Tambah Tindakan</button>
          </form>

          <hr>

          <table class="table table-bordered table-hover mt-3">
            <thead class="table-light">
              <tr>
                <th>Kode</th>
                <th>Tindakan</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
                <th>Keterangan</th>
                <th width="120px">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($detail as $d)
              <tr>
                <td>{{ $d->kode }}</td>
                <td>{{ $d->deskripsi_tindakan_terapi }}</td>
                <td>{{ $d->nama_kategori }}</td>
                <td>{{ $d->nama_kategori_klinis }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>
                  <a href="{{ route('perawat.rekam-medis.edit-detail', $d->iddetail_rekam_medis) }}"
                     class="btn btn-warning btn-sm">Edit</a>

                  <form action="{{ route('perawat.rekam-medis.delete-tindakan', $d->iddetail_rekam_medis) }}"
                        method="POST"
                        style="display:inline-block"
                        onsubmit="return confirm('Hapus tindakan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr><td colspan="6" class="text-center text-muted">Belum ada tindakan</td></tr>
              @endforelse
            </tbody>
          </table>

        </div>
      </div>

    </div>
  </section>

</div>
@endsection
