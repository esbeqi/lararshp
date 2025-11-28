@extends('layouts.lte.main')

@section('title', 'Daftar Pemilik')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Pemilik</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tabel Data Pemilik</h3>
                    <a href="{{ route('admin.pemilik.create') }}" class="btn btn-success">Tambah</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama User</th>
                                <th>No. WhatsApp</th>
                                <th>Alamat</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemilik as $pem)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pem->nama_user }}</td>
                                    <td>{{ $pem->no_wa }}</td>
                                    <td>{{ $pem->alamat }}</td>
                                    <td>
                                        <a href="{{ route('admin.pemilik.edit', $pem->idpemilik) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.pemilik.destroy', $pem->idpemilik) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data pemilik</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection