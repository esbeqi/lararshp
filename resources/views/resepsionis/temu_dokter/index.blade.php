@extends('layouts.lte.main')

@section('title','Antrian Temu Dokter')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Antrian Temu Dokter</h1></div></section>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <form class="d-flex" method="GET">
                        <input type="date" name="tanggal" class="form-control me-2"
                               value="{{ $tanggal }}">
                        <button class="btn btn-outline-primary">Filter</button>
                    </form>
                    <a href="{{ route('resepsionis.temu-dokter.create') }}" class="btn btn-success">Buat Antrian</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No Urut</th>
                                <th>Pet</th>
                                <th>Pemilik</th>
                                <th>Dokter</th>
                                <th>Status</th>
                                <th style="width:140px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($antrian as $a)
                                <tr>
                                    <td>{{ $a->no_urut }}</td>
                                    <td>{{ $a->nama_pet }}</td>
                                    <td>{{ $a->nama_pemilik }}</td>
                                    <td>{{ $a->nama_dokter }}</td>
                                    <td>
                                        @if($a->status=='S')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($a->status=='B')
                                            <span class="badge bg-danger">Batal</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('resepsionis.temu-dokter.edit',$a->idreservasi_dokter) }}"
                                           class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('resepsionis.temu-dokter.destroy',$a->idreservasi_dokter) }}"
                                              method="POST" style="display:inline-block"
                                              onsubmit="return confirm('Hapus antrian?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Tidak ada antrian</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3">{{ $antrian->links() }}</div>
                </div>

            </div>

        </div>
    </section>
</div>
@endsection
