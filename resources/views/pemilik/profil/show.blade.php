@extends('layouts.lte.main')
@section('title','Profil Pemilik')

@section('content')
<div class="content-wrapper">

    {{-- Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <h1>Profil Pemilik</h1>
            <p class="text-muted">Informasi akun & data pemilik</p>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- Flash message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">

                {{-- ===========================
                     LEFT: Ringkasan Profil
                ============================ --}}
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Ringkasan Profil</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width:200px">ID Pemilik</th>
                                        <td>{{ $profile->idpemilik }}</td>
                                    </tr>

                                    <tr>
                                        <th>Nama</th>
                                        <td>{{ $profile->nama }}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $profile->email }}</td>
                                    </tr>

                                    <tr>
                                        <th>No. WA</th>
                                        <td>{{ $profile->no_wa }}</td>
                                    </tr>

                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $profile->alamat }}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ===========================
                     RIGHT: Form Edit Profil
                ============================ --}}
                <div class="col-lg-6">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profil</h3>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('pemilik.profil.update') }}">
                                @csrf

                                {{-- Nama user --}}
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" 
                                           class="form-control @error('nama') is-invalid @enderror"
                                           value="{{ old('nama', $profile->nama) }}" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" 
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $profile->email) }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Nomor WA --}}
                                <div class="mb-3">
                                    <label class="form-label">No. WA</label>
                                    <input type="text" name="no_wa" 
                                           class="form-control @error('no_wa') is-invalid @enderror"
                                           value="{{ old('no_wa', $profile->no_wa) }}">
                                    @error('no_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Alamat --}}
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" rows="3"
                                              class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $profile->alamat) }}</textarea>
                                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <button class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('pemilik.dashboard') }}" class="btn btn-secondary">Batal</a>

                            </form>
                        </div>
                    </div>
                </div>

            </div> {{-- row --}}
        </div>
    </section>
</div>
@endsection
