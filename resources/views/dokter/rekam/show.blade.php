@extends('layouts.lte.main')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Detail Rekam Medis</h1></div></section>
    <section class="content">
        <div class="container-fluid">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@elseif(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Info Rekam</h3></div>
                <div class="card-body">
                    <p><strong>Pet:</strong> {{ $rekam->pet_nama ?? '-' }} | <strong>No Urut:</strong> {{ $rekam->no_urut ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $rekam->created_at }}</p>
                    <p><strong>Anamnesa:</strong> {{ $rekam->anamnesa }}</p>
                    <p><strong>Temuan Klinis:</strong> {{ $rekam->temuan_klinis }}</p>
                    <p><strong>Diagnosa:</strong> {{ $rekam->diagnosa }}</p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detail Tindakan</h3>
                </div>
                <div class="card-body">
                    @if($detail->isEmpty())
                        <p class="text-muted">Belum ada tindakan dicatat.</p>
                    @else
                        <table class="table table-bordered">
                            <thead><tr><th>#</th><th>Kode</th><th>Deskripsi</th><th>Catatan</th><th style="width:140px">Aksi</th></tr></thead>
                            <tbody>
                                @foreach($detail as $d)
                                    <tr>
                                        <td>{{ $d->iddetail_rekam_medis }}</td>
                                        <td>{{ $d->kode }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($d->deskripsi_tindakan_terapi,60) }}</td>
                                        <td>{{ $d->detail }}</td>
                                        <td>
                                            <a href="{{ route('dokter.detail.edit', [$rekam->idrekam_medis, $d->iddetail_rekam_medis]) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('dokter.detail.destroy', [$rekam->idrekam_medis, $d->iddetail_rekam_medis]) }}" method="POST" style="display:inline-block;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus tindakan ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <hr>
                    <h5>Tambah Tindakan</h5>
                    <form action="{{ route('dokter.detail.store', $rekam->idrekam_medis) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Kode Tindakan</label>
                            <select name="idkode_tindakan_terapi" class="form-control" required>
                                @foreach($kodes as $k)
                                    <option value="{{ $k->idkode_tindakan_terapi }}">{{ $k->kode }} — {{ \Illuminate\Support\Str::limit($k->deskripsi_tindakan_terapi,60) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan / Detail</label>
                            <textarea name="detail" class="form-control" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary">Simpan</button>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
