@extends('layouts.lte.main')

@section('title', 'Daftar Kategori Klinis')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Kategori Klinis</h1>
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
                    <h3 class="card-title">Tabel Data Kategori Klinis</h3>
                    <a href="{{ route('admin.kategori-klinis.create') }}" class="btn btn-success">Tambah</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Kategori Klinis</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategoriKlinis as $hewan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $hewan->nama_kategori_klinis }}</td>
                                    <td>
                                        <a href="{{ route('admin.kategori-klinis.edit', $hewan->idkategori_klinis) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.kategori-klinis.destroy', $hewan->idkategori_klinis) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data kategori klinis</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- pagination jika perlu --}}
            </div>

        </div>
    </section>
</div>
@endsection