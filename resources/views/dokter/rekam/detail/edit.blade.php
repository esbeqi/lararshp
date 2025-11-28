@extends('layouts.lte.main')

@section('title', 'Edit Detail Tindakan')

@section('content')
<div class="content-wrapper">
    <section class="content-header"><div class="container-fluid"><h1>Edit Detail Tindakan</h1></div></section>
    <section class="content">
        <div class="container-fluid">
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dokter.detail.update', [$idrekam, $detail->iddetail_rekam_medis]) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Kode Tindakan</label>
                            <select name="idkode_tindakan_terapi" class="form-control" required>
                                @foreach($kodes as $k)
                                    <option value="{{ $k->idkode_tindakan_terapi }}" {{ $k->idkode_tindakan_terapi == $detail->idkode_tindakan_terapi ? 'selected' : '' }}>
                                        {{ $k->kode }} — {{ \Illuminate\Support\Str::limit($k->deskripsi_tindakan_terapi,60) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail</label>
                            <textarea name="detail" class="form-control" rows="4">{{ $detail->detail }}</textarea>
                        </div>

                        <button class="btn btn-primary">Update</button>
                        <a href="{{ route('dokter.rekam.show', $idrekam) }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
