@extends('layouts.lte.main')
@section('title', 'Daftar Rekam Medis')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Rekam Medis</h1>
            <a href="{{ route('perawat.rekam-medis.create') }}" class="btn btn-success mt-3">Tambah Rekam Medis</a>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card mt-3">
                <div class="card-body">

                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>No. Urut</th>
                                <th>Pet</th>
                                <th>Pemilik</th>
                                <th>Dokter Pemeriksa</th>
                                <th>Tanggal</th>
                                <th width="180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekam as $r)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $r->no_urut }}</td>
                                    <td>{{ $r->nama_pet }}</td>
                                    <td>{{ $r->nama_pemilik }}</td>
                                    <td>{{ $r->nama_dokter ?? '-' }}</td>
                                    <td>
                                        @if($r->created_at) 
                                            {{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('perawat.rekam-medis.detail', $r->idrekam_medis) }}" class="btn btn-info btn-sm">Detail</a>

                                        <a href="{{ route('perawat.rekam-medis.edit', $r->idrekam_medis) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('perawat.rekam-medis.destroy', $r->idrekam_medis) }}"
                                              method="POST"
                                              style="display:inline-block"
                                              onsubmit="return confirm('Hapus rekam medis ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">Belum ada rekam medis</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
