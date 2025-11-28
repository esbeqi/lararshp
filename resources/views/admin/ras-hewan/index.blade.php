@extends('layouts.lte.main')

@section('title', 'Daftar Ras Hewan')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Ras Hewan</h1>
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
                    <h3 class="card-title">Tabel Data Ras Hewan</h3>
                    <a href="{{ route('admin.ras-hewan.create') }}" class="btn btn-success">Tambah</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Ras</th>
                                <th>Jenis Hewan</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rasHewan as $ras)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ras->nama_ras }}</td>
                                    <td>{{ $ras->nama_jenis_hewan ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.ras-hewan.edit', $ras->idras_hewan) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.ras-hewan.destroy', $ras->idras_hewan) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data ras hewan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- pagination: ubah controller ke paginate() jika diperlukan --}}
            </div>

        </div>
    </section>
</div>
@endsection