@extends('layouts.lte.main')

@section('title', 'Edit Kode Tindakan Terapi')

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
                <form action="{{ route('admin.kode-tindakan-terapi.update', $tindakan->idkode_tindakan_terapi) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode</label>
                            <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror"
                                   value="{{ old('kode', $tindakan->kode) }}" required>
                            @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_tindakan_terapi" class="form-label">Deskripsi Tindakan Terapi</label>
                            <input type="text" name="deskripsi_tindakan_terapi" id="deskripsi_tindakan_terapi"
                                   class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror"
                                   value="{{ old('deskripsi_tindakan_terapi', $tindakan->deskripsi_tindakan_terapi) }}" required>
                            @error('deskripsi_tindakan_terapi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idkategori" class="form-label">Kategori</label>
                            <select name="idkategori" id="idkategori" class="form-select @error('idkategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->idkategori }}" {{ old('idkategori', $tindakan->idkategori) == $kat->idkategori ? 'selected' : '' }}>
                                        {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idkategori_klinis" class="form-label">Kategori Klinis</label>
                            <select name="idkategori_klinis" id="idkategori_klinis" class="form-select @error('idkategori_klinis') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori Klinis --</option>
                                @foreach ($kategoriKlinis as $katKlinis)
                                    <option value="{{ $katKlinis->idkategori_klinis }}" {{ old('idkategori_klinis', $tindakan->idkategori_klinis) == $katKlinis->idkategori_klinis ? 'selected' : '' }}>
                                        {{ $katKlinis->nama_kategori_klinis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idkategori_klinis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.kode-tindakan-terapi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>

                </form>
            </div>

        </div>
    </section>
</div>
@endsection