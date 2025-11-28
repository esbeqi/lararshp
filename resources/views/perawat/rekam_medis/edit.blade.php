@extends('layouts.lte.main')
@section('title','Edit Rekam Medis')

@section('content')
<div class="content-wrapper">

  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Rekam Medis #{{ $rekam->idrekam_medis }}</h1>
      <p>Pet: {{ $antrian->nama_pet ?? '-' }} — Pemilik: {{ $antrian->nama_pemilik ?? '-' }}</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      @if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>@endif

      <div class="card">
        <div class="card-body">
          <form method="POST" action="{{ route('perawat.rekam-medis.update', $rekam->idrekam_medis) }}">
            @csrf

            <div class="mb-3">
              <label>Anamnesa</label>
              <textarea name="anamnesa" class="form-control">{{ old('anamnesa', $rekam->anamnesa) }}</textarea>
            </div>

            <div class="mb-3">
              <label>Temuan Klinis</label>
              <textarea name="temuan_klinis" class="form-control">{{ old('temuan_klinis', $rekam->temuan_klinis) }}</textarea>
            </div>

            <div class="mb-3">
              <label>Diagnosa</label>
              <textarea name="diagnosa" class="form-control">{{ old('diagnosa', $rekam->diagnosa) }}</textarea>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('perawat.rekam-medis.detail', $rekam->idrekam_medis) }}" class="btn btn-secondary">Kembali</a>

          </form>
        </div>
      </div>

    </div>
  </section>

</div>
@endsection
