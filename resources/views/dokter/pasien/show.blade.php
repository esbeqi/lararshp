@extends('layouts.lte.main')

@section('title', 'Detail Pasien')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Detail Pasien</h1></div></section>
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@elseif(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Info Hewan & Pemilik</h3></div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Nama Hewan</dt><dd class="col-sm-9">{{ $pet->nama }}</dd>
                        <dt class="col-sm-3">Tanggal Lahir</dt><dd class="col-sm-9">{{ $pet->tanggal_lahir ?? '-' }}</dd>
                        <dt class="col-sm-3">Warna / Tanda</dt><dd class="col-sm-9">{{ $pet->warna_tanda ?? '-' }}</dd>
                        <dt class="col-sm-3">Jenis Kelamin</dt><dd class="col-sm-9">{{ $pet->jenis_kelamin ?? '-' }}</dd>
                        <dt class="col-sm-3">Pemilik</dt><dd class="col-sm-9">{{ $pet->pemilik_nama ?? '-' }}</dd>
                        <dt class="col-sm-3">No WA</dt><dd class="col-sm-9">{{ $pet->no_wa ?? '-' }}</dd>
                        <dt class="col-sm-3">Alamat</dt><dd class="col-sm-9">{{ $pet->alamat ?? '-' }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3 class="card-title">Rekam Medis</h3></div>
                <div class="card-body">
                    @if($rekam->isEmpty())
                        <p class="text-muted">Belum ada rekam medis untuk hewan ini.</p>
                    @else
                        <ul class="list-group">
                            @foreach($rekam as $r)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>#{{ $r->idrekam_medis }}</strong> — {{ $r->created_at }}<br>
                                        <small class="text-muted">No Urut: {{ $r->no_urut ?? '-' }}</small>
                                    </div>
                                    <div>
                                        <a href="{{ route('dokter.rekam.show', $r->idrekam_medis) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
