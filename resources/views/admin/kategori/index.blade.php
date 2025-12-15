@extends('layouts.lte.main')

@section('title', 'Daftar Kategori')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1>{{ $isTrash ? 'Trash Kategori' : 'Daftar Kategori' }}</h1>

            <div>
                @if(!$isTrash)
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-success">Tambah</a>
                    <a href="{{ route('admin.kategori.index', ['trash'=>1]) }}" class="btn btn-warning">Trash</a>
                @else
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
                @endif
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="60">#</th>
                                <th>Nama Kategori</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($kategori as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kategori }}</td>
                                <td>
                                    @if(!$isTrash)
                                        <a href="{{ route('admin.kategori.edit', $item->idkategori) }}"
                                           class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.kategori.destroy', $item->idkategori) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.kategori.restore', $item->idkategori) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-warning">Restore</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Data kosong</td>
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
