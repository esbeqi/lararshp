@extends('layouts.lte.main')
@section('title','Tambah Rekam Medis')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Tambah Rekam Medis</h1>
        </div>
    </section>

    <section class="content">
    <div class="container-fluid">

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card mt-3">
            <div class="card-body">

                <form method="POST" action="{{ route('perawat.rekam-medis.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label>Antrian (Pet - Pemilik - Dokter)</label>
                        <select name="idreservasi_dokter" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach($available as $a)
                                <option value="{{ $a->idreservasi_dokter }}">
                                    No.{{ $a->no_urut }} - {{ $a->nama_pet }} ({{ $a->nama_pemilik }}) - Dokter {{ $a->nama_dokter }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Dokter Pemeriksa (opsional)</label>
                        <input type="text" class="form-control" name="dokter_pemeriksa" placeholder="id dokter (boleh kosong)" />
                        <small class="text-muted">Jika ingin assign dokter, masukkan id user dokter. Bisa dikosongkan.</small>
                    </div>

                    <button class="btn btn-success">Buat Rekam Medis</button>
                </form>

            </div>
        </div>

    </div>
    </section>
</div>
@endsection
