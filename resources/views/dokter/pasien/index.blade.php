@extends('layouts.lte.main')

@section('title', 'Daftar Pasien (Antrian)')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Daftar Antrian Pasien</h1></div></section>
    <section class="content">
        <div class="container-fluid">
            @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @elseif(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tabel Antrian</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Hewan</th>
                                <th>Nama Pemilik</th>
                                <th>No WA</th>
                                <th>No Urut</th>
                                <th>Waktu Daftar</th>
                                <th style="width:140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($temu as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($temu->currentPage()-1)*$temu->perPage() }}</td>
                                    <td>{{ $item->pet_nama }}</td>
                                    <td>{{ $item->pemilik_nama ?? '-' }}</td>
                                    <td>{{ $item->no_wa ?? '-' }}</td>
                                    <td>{{ $item->no_urut ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->waktu_daftar)->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('dokter.pasien.show', $item->idpet) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted">Belum ada antrian</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">{{ $temu->links() }}</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
