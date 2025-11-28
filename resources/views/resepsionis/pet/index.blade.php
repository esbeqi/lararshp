@extends('layouts.lte.main')

@section('title','Data Hewan')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Data Hewan</h1></div></section>
    <section class="content">
        <div class="container-fluid">

            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">Daftar Hewan</h3>
                    <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-success">Tambah Hewan</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Hewan</th>
                                <th>Pemilik</th>
                                <th>Jenis</th>
                                <th>Ras</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pet as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->nama_pemilik }}</td>
                                    <td>{{ $p->nama_jenis_hewan }}</td>
                                    <td>{{ $p->nama_ras }}</td>
                                    <td>
                                        <a href="{{ route('resepsionis.pet.edit', $p->idpet) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('resepsionis.pet.destroy', $p->idpet) }}"
                                              method="POST" style="display:inline-block"
                                              onsubmit="return confirm('Hapus hewan ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Belum ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 mx-3">
                    {{ $pet->links() }}
                </div>

            </div>

        </div>
    </section>
</div>
@endsection
