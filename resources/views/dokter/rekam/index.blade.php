@extends('layouts.lte.main')

@section('title', 'Daftar Rekam Medis')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Daftar Rekam Medis</h1></div></section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@elseif(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tabel Rekam Medis</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Pet</th>
                                <th>Pemilik</th>
                                <th>Tanggal</th>
                                <th>Anamnesa</th>
                                <th style="width:120px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $isPaginator = isset($rekam) && method_exists($rekam, 'currentPage') && method_exists($rekam, 'perPage');
                                $start = $isPaginator ? ($rekam->currentPage()-1)*$rekam->perPage() : 0;
                            @endphp

                            @forelse($rekam ?? [] as $item)
                                <tr>
                                    <td>{{ $loop->iteration + $start }}</td>
                                    <td>{{ $item->pet_nama ?? '-' }}</td>
                                    <td>{{ $item->pemilik_nama ?? '-' }}</td>
                                    <td>{{ isset($item->created_at) ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($item->anamnesa ?? '-', 60) }}</td>
                                    <td>
                                        <a href="{{ route('dokter.rekam.show', $item->idrekam_medis) }}" class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Belum ada rekam medis</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if($isPaginator)
                        <div class="mt-3">{{ $rekam->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
