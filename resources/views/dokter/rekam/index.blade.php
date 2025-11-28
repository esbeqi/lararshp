@extends('layouts.lte.main')

@section('title','Rekam Medis')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Rekam Medis - {{ $antrian->nama_pet ?? '—' }}</h1>
      <p class="text-muted">Pemilik: {{ $antrian->nama_pemilik ?? '-' }}</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
      @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
      @if($errors->any())<div class="alert alert-danger"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>@endif

      <div class="row">
        {{-- Form tambah tindakan --}}
        <div class="col-lg-5">
          <div class="card">
            <div class="card-header"><h3 class="card-title mb-0">Tambah Tindakan</h3></div>
            <div class="card-body">
              <form action="{{ route('perawat.rekam-medis.store', $antrian->idreservasi_dokter) }}" method="POST">
                @csrf

                <div class="mb-3">
                  <label class="form-label">Kode / Tindakan</label>
                  <select name="idkode_tindakan" class="form-control" required>
                    <option value="">-- Pilih Tindakan --</option>
                    @foreach($kodeTindakan as $k)
                      @php
                        // ambil id (fallback)
                        $k_id   = $k->idkode_tindakan ?? ($k->id ?? null);
                        // ambil kode (fallback)
                        $k_code = $k->kode_tindakan ?? ($k->kode ?? null);
                        // ambil nama (fallback)
                        $k_name = $k->nama_tindakan ?? ($k->nama ?? ($k->nama_terapi ?? null));
                        // jika semua null, gunakan json sebagai label agar tidak kosong
                        $label  = trim((($k_code ? "[$k_code] " : '') . ($k_name ?? json_encode($k))));
                      @endphp

                      @if($k_id)
                        <option value="{{ $k_id }}" {{ (string) old('idkode_tindakan') === (string) $k_id ? 'selected' : '' }}>
                          {{ $label }}
                        </option>
                      @else
                        {{-- jika tidak ada id, tampilkan disabled option --}}
                        <option disabled>{{ $label }} (no id)</option>
                      @endif
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Keterangan / Catatan</label>
                  <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan') }}</textarea>
                </div>

                <button class="btn btn-success">Simpan Tindakan</button>
                <a href="{{ route('perawat.pasien.index') }}" class="btn btn-secondary">Kembali</a>
              </form>
            </div>
          </div>
        </div>

        {{-- Daftar tindakan --}}
        <div class="col-lg-7">
          <div class="card">
            <div class="card-header"><h3 class="card-title mb-0">Daftar Tindakan</h3></div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="table-light">
                    <tr>
                      <th style="width:150px">Waktu</th>
                      <th style="width:120px">Kode</th>
                      <th>Tindakan</th>
                      <th>Keterangan</th>
                      <th style="width:120px">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($detail as $d)
                      @php
                        // fallback untuk kode & nama pada hasil join yang dinamis
                        $d_code = $d->kode_tindakan ?? ($d->kode ?? null);
                        $d_name = $d->nama_tindakan ?? ($d->nama ?? ($d->nama_terapi ?? null));
                        // fallback untuk waktu
                        $d_time = isset($d->created_at) ? \Carbon\Carbon::parse($d->created_at)->format('Y-m-d H:i') : (isset($d->waktu) ? $d->waktu : '-');
                      @endphp

                      <tr>
                        <td>{{ $d_time }}</td>
                        <td>{{ $d_code ?? '-' }}</td>
                        <td>{{ $d_name ?? '-' }}</td>
                        <td>{{ $d->keterangan ?? '-' }}</td>
                        <td>
                          <form action="{{ url('/perawat/rekam-medis/destroy/'.$d->iddetail_rekam_medis) }}" method="POST" onsubmit="return confirm('Hapus tindakan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr><td colspan="5" class="text-center text-muted py-4">Belum ada tindakan</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section>
</div>
@endsection
