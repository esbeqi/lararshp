@extends('layouts.lte.main')

@section('title','Tambah Hewan')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Tambah Hewan</h1></div></section>
    <section class="content">
        <div class="container-fluid">

            @if($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
            @endif

            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('resepsionis.pet.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Pemilik</label>
                            <select name="idpemilik" class="form-control" required>
                                <option value="">-- Pilih Pemilik --</option>
                                @foreach($pemilik as $pm)
                                    <option value="{{ $pm->idpemilik }}"
                                        {{ old('idpemilik', $pemilik_id) == $pm->idpemilik ? 'selected' : '' }}>
                                        {{ $pm->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Hewan</label>
                            <input type="text" class="form-control" name="nama" required
                                value="{{ old('nama') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Hewan</label>
                                <select name="idjenis_hewan" class="form-control" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    @foreach($jenis as $j)
                                        <option value="{{ $j->idjenis_hewan }}"
                                            {{ old('idjenis_hewan') == $j->idjenis_hewan ? 'selected' : '' }}>
                                            {{ $j->nama_jenis_hewan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ras</label>
                                <select name="idras_hewan" class="form-control" required>
                                    <option value="">-- Pilih Ras --</option>
                                    @foreach($rasGrouped as $jenisName => $rasList)
                                        <optgroup label="{{ $jenisName }}">
                                            @foreach($rasList as $r)
                                                <option value="{{ $r->idras_hewan }}"
                                                    {{ old('idras_hewan') == $r->idras_hewan ? 'selected' : '' }}>
                                                    {{ $r->nama_ras }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Pria</option>
                                <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Wanita</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Warna / Tanda</label>
                            <input type="text" name="warna_tanda" class="form-control"
                                   value="{{ old('warna_tanda') }}">
                        </div>

                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">Batal</a>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
