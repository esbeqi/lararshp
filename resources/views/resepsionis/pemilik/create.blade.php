@extends('layouts.lte.main')

@section('title', 'Tambah Pemilik')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Tambah Pemilik</h1></div></section>

    <section class="content">
        <div class="container-fluid">
            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('resepsionis.pemilik.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Pemilik</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email (login)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            <small class="text-muted">Email akan digunakan untuk login. Password default: <code>password</code></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No WA</label>
                            <input type="text" name="no_wa" class="form-control" value="{{ old('no_wa') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                        </div>

                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-secondary">Batal</a>

                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
