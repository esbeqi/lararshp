@extends('layouts.lte.main')

@section('title', 'Daftar Jenis Hewan')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Jenis Hewan</h1>
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
                    <h3 class="card-title">Tabel Data Jenis Hewan</h3>
                    <a href="{{ route('admin.jenis-hewan.create') }}" class="btn btn-success">Tambah</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Jenis Hewan</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisHewan as $index => $hewan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> {{-- <-- pakai loop->iteration --}}
                                    <td>{{ $hewan->nama_jenis_hewan }}</td>
                                    <td>
                                        <a href="{{ route('admin.jenis-hewan.edit', $hewan->idjenis_hewan) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.jenis-hewan.destroy', $hewan->idjenis_hewan) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data jenis hewan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- jika mau pagination nanti, ubah controller ke paginate() dan tampilkan links() --}}
            </div>
        </div>
    </section>
</div>
@endsection