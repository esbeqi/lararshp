@extends('layouts.lte.main')

@section('title', 'Daftar Jenis Hewan')

@section('content')
<div class="content-wrapper">

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Jenis Hewan</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- ================= DATA AKTIF ================= --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Jenis Hewan (Aktif)</h3>
                    <a href="{{ route('admin.jenis-hewan.create') }}" class="btn btn-success btn-sm">
                        + Tambah
                    </a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Jenis Hewan</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisHewan as $hewan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $hewan->nama_jenis_hewan }}</td>
                                    <td>
                                        <a href="{{ route('admin.jenis-hewan.edit', $hewan->idjenis_hewan) }}"
                                           class="btn btn-sm btn-primary">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.jenis-hewan.destroy', $hewan->idjenis_hewan) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Belum ada data jenis hewan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ================= DATA TERHAPUS ================= --}}
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="card-title text-muted">Data Terhapus</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama Jenis Hewan</th>
                                <th style="width:220px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenisHewanDeleted as $hewan)
                                <tr class="text-muted">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $hewan->nama_jenis_hewan }}</td>
                                    <td>
                                        <form action="{{ route('admin.jenis-hewan.restore', $hewan->idjenis_hewan) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Restore data ini?');">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-warning">
                                                Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Tidak ada data terhapus
                                    </td>
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
