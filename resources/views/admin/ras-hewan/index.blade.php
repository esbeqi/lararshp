@extends('layouts.lte.main')

@section('title', 'Daftar Ras Hewan')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid d-flex justify-content-between">
            <h1>{{ $isTrash ? 'Trash Ras Hewan' : 'Daftar Ras Hewan' }}</h1>

            <div>
                @if(!$isTrash)
                    <a href="{{ route('admin.ras-hewan.create') }}" class="btn btn-success">Tambah</a>
                    <a href="{{ route('admin.ras-hewan.index', ['trash'=>1]) }}" class="btn btn-warning">Trash</a>
                @else
                    <a href="{{ route('admin.ras-hewan.index') }}" class="btn btn-secondary">Kembali</a>
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
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Ras</th>
                            <th>Jenis Hewan</th>
                            <th width="200">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($rasHewan as $ras)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ras->nama_ras }}</td>
                                <td>{{ $ras->nama_jenis_hewan ?? '-' }}</td>
                                <td>
                                    @if(!$isTrash)
                                        <a href="{{ route('admin.ras-hewan.edit', $ras->idras_hewan) }}"
                                           class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.ras-hewan.destroy', $ras->idras_hewan) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.ras-hewan.restore', $ras->idras_hewan) }}"
                                              method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-warning">Restore</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Data kosong</td>
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
