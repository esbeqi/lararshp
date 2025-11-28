@extends('layouts.lte.main')

@section('title', 'Tambah Kategori Klinis')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <form action="{{ route('admin.kategori-klinis.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nama_kategori_klinis" class="form-label">Nama Kategori Klinis</label>
                            <input type="text" name="nama_kategori_klinis" id="nama_kategori_klinis"
                                   class="form-control @error('nama_kategori_klinis') is-invalid @enderror"
                                   value="{{ old('nama_kategori_klinis') }}" required>
                            @error('nama_kategori_klinis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.kategori-klinis.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection
