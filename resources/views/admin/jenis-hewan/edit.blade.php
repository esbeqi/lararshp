@extends('layouts.lte.main')

@section('title', 'Edit Jenis Hewan')

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
                <form action="{{ route('admin.jenis-hewan.update', $hewan->idjenis_hewan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nama_jenis_hewan" class="form-label">Nama Jenis Hewan</label>
                            <input type="text" name="nama_jenis_hewan" id="nama_jenis_hewan"
                                   class="form-control @error('nama_jenis_hewan') is-invalid @enderror"
                                   value="{{ old('nama_jenis_hewan', $hewan->nama_jenis_hewan) }}" required>
                            @error('nama_jenis_hewan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection