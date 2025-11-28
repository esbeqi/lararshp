@extends('layouts.lte.main')

@section('title', 'Edit Ras Hewan')

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
                <form action="{{ route('admin.ras-hewan.update', $ras->idras_hewan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="mb-3">
                            <label for="idjenis_hewan" class="form-label">Jenis Hewan</label>
                            <select name="idjenis_hewan" id="idjenis_hewan" class="form-control @error('idjenis_hewan') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Hewan --</option>
                                @foreach ($jenisHewan as $j)
                                    <option value="{{ $j->idjenis_hewan }}" {{ old('idjenis_hewan', $ras->idjenis_hewan) == $j->idjenis_hewan ? 'selected' : '' }}>
                                        {{ $j->nama_jenis_hewan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idjenis_hewan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_ras" class="form-label">Nama Ras</label>
                            <input type="text" name="nama_ras" id="nama_ras"
                                   class="form-control @error('nama_ras') is-invalid @enderror"
                                   value="{{ old('nama_ras', $ras->nama_ras) }}" required>
                            @error('nama_ras') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.ras-hewan.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection
