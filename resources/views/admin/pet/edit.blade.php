@extends('layouts.lte.main')

@section('title', 'Edit Pet')

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
                <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pet</label>
                            <input type="text"
                                   name="nama"
                                   id="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $pet->nama) }}"
                                   required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih --</option>
                                <option value="Jantan" {{ old('jenis_kelamin', $pet->jenis_kelamin)=='Jantan'?'selected':'' }}>Jantan</option>
                                <option value="Betina" {{ old('jenis_kelamin', $pet->jenis_kelamin)=='Betina'?'selected':'' }}>Betina</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date"
                                       name="tanggal_lahir"
                                       id="tanggal_lahir"
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                       value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="warna_tanda" class="form-label">Warna/Tanda</label>
                                <input type="text"
                                       name="warna_tanda"
                                       id="warna_tanda"
                                       class="form-control @error('warna_tanda') is-invalid @enderror"
                                       value="{{ old('warna_tanda', $pet->warna_tanda) }}">
                                @error('warna_tanda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="idpemilik" class="form-label">Pemilik</label>
                            <select name="idpemilik"
                                    id="idpemilik"
                                    class="form-control @error('idpemilik') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Pemilik --</option>
                                @foreach ($pemilik as $p)
                                    <option value="{{ $p->idpemilik }}"
                                        {{ old('idpemilik', $pet->idpemilik)==$p->idpemilik?'selected':'' }}>
                                        {{ $p->nama_pemilik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idpemilik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idras_hewan" class="form-label">Ras Hewan</label>
                            <select name="idras_hewan"
                                    id="idras_hewan"
                                    class="form-control @error('idras_hewan') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Ras --</option>
                                @foreach ($rasHewan as $r)
                                    <option value="{{ $r->idras_hewan }}"
                                        {{ old('idras_hewan', $pet->idras_hewan)==$r->idras_hewan?'selected':'' }}>
                                        {{ $r->nama_ras }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idras_hewan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection