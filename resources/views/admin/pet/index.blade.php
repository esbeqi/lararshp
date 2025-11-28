@extends('layouts.lte.main')

@section('title', 'Daftar Pet')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Daftar Pet</h1>
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
                    <h3 class="card-title">Tabel Data Pet</h3>
                    <a href="{{ route('admin.pet.create') }}" class="btn btn-success">Tambah</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Pemilik</th>
                                <th>Ras Hewan</th>
                                <th>Tanggal Lahir</th>
                                <th>Warna/Tanda</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pets as $pet)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pet->nama }}</td>
                                    <td>{{ $pet->jenis_kelamin }}</td>
                                    <td>{{ $pet->nama_pemilik ?? '-' }}</td>
                                    <td>{{ $pet->nama_ras ?? '-' }}</td>
                                    <td>{{ $pet->tanggal_lahir ?? '-' }}</td>
                                    <td>{{ $pet->warna_tanda ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.pet.edit', $pet->idpet) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.pet.destroy', $pet->idpet) }}"
                                              method="POST"
                                              style="display:inline-block"
                                              onsubmit="return confirm('Hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Belum ada data pet</td>
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