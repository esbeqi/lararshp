@extends('layouts.lte.main')
@section('title','Edit Detail Tindakan')

@section('content')
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Tindakan</h1>
      <p>#{{ $data->iddetail_rekam_medis }} — Rekam: {{ $data->idrekam_medis }}</p>
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
        <div class="card-body">

          <form method="POST" action="{{ route('perawat.rekam-medis.update-detail', $data->iddetail_rekam_medis) }}">
            @csrf

            <div class="mb-3">
              <label for="idkode_tindakan_terapi">Kode Tindakan</label>
              <select id="idkode_tindakan_terapi" name="idkode_tindakan_terapi" class="form-control" required>
                <option value="">-- Pilih Kode --</option>
                @foreach($kodeTindakan as $k)
                  <option value="{{ $k->idkode_tindakan_terapi }}"
                    {{ (int) old('idkode_tindakan_terapi', $data->idkode_tindakan_terapi) === (int) $k->idkode_tindakan_terapi ? 'selected' : '' }}>
                    {{ $k->kode }} - {{ $k->deskripsi_tindakan_terapi }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="keterangan">Keterangan</label>
              <textarea id="keterangan" name="keterangan" class="form-control" rows="4">{{ old('keterangan', $data->detail) }}</textarea>
            </div>

            <div class="d-flex gap-2">
              <button class="btn btn-primary">Simpan Perubahan</button>
              <a href="{{ route('perawat.rekam-medis.detail', $data->idrekam_medis) }}" class="btn btn-secondary">Kembali ke Detail</a>
            </div>
          </form>

        </div>
      </div>

    </div>
  </section>

</div>
@endsection
