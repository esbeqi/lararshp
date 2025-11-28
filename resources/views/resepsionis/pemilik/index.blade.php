@extends('layouts.lte.main')

@section('title', 'Data Pemilik')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Data Pemilik</h1></div></section>

    <section class="content">
        <div class="container-fluid">
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> 
            @elseif(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tabel Pemilik</h3>
                    <div>
                        <form method="GET" action="{{ route('resepsionis.pemilik.index') }}" class="d-inline-block me-2">
                            <div class="input-group">
                                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Cari nama / email / WA">
                                <button class="btn btn-outline-secondary">Cari</button>
                            </div>
                        </form>
                        <a href="{{ route('resepsionis.pemilik.create') }}" class="btn btn-success">Tambah Pemilik</a>
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No WA</th>
                                <th>Alamat</th>
                                <th style="width:160px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pemilik as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($pemilik->currentPage()-1)*$pemilik->perPage() }}</td>
                                    <td>{{ $item->nama_user ?? '-' }}</td>
                                    <td>{{ $item->email_user ?? '-' }}</td>
                                    <td>{{ $item->no_wa ?? '-' }}</td>
                                    <td>{{ $item->alamat ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('resepsionis.pemilik.edit', $item->idpemilik) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('resepsionis.pemilik.destroy', $item->idpemilik) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus pemilik ini?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Belum ada data pemilik</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">{{ $pemilik->links() }}</div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
