@extends('layouts.lte.main')

@section('title','Edit Hewan')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Edit Hewan</h1></div></section>

    <section class="content">
        <div class="container-fluid">
            @if($errors->any())
                <div class="alert alert-danger"><ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div>
            @endif

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('resepsionis.pet.update', $pet->idpet) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Pemilik</label>
                            <select name="idpemilik" class="form-control" required>
                                @foreach($pemilik as $pm)
                                    <option value="{{ $pm->idpemilik }}"
                                        {{ $pet->idpemilik == $pm->idpemilik ? 'selected' : '' }}>
                                        {{ $pm->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Hewan</label>
                            <input type="text" class="form-control" name="nama" required
                                value="{{ old('nama', $pet->nama) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Hewan</label>
                                <select name="idjenis_hewan" class="form-control" required>
                                    @foreach($jenis as $j)
                                        <option value="{{ $j->idjenis_hewan }}"
                                            {{ $j->idjenis_hewan == (DB::table('ras_hewan')->where('idras_hewan',$pet->idras_hewan)->value('idjenis_hewan')) ? 'selected' : '' }}>
                                            {{ $j->nama_jenis_hewan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ras</label>
                                <select name="idras_hewan" class="form-control" required>
                                    @foreach($ras as $r)
                                        <option value="{{ $r->idras_hewan }}"
                                            {{ $pet->idras_hewan == $r->idras_hewan ? 'selected' : '' }}>
                                            {{ $r->nama_ras }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="L" {{ $pet->jenis_kelamin == 'L' ? 'selected':'' }}>Pria</option>
                                <option value="P" {{ $pet->jenis_kelamin == 'P' ? 'selected':'' }}>Wanita</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Warna / Tanda</label>
                            <input type="text" name="warna_tanda" class="form-control"
                                value="{{ old('warna_tanda', $pet->warna_tanda) }}">
                        </div>

                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">Batal</a>

                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
