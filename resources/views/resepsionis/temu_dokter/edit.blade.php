@extends('layouts.lte.main')

@section('title','Edit Antrian Temu Dokter')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Edit Antrian</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

            {{-- FORM FILTER PEMILIK --}}
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('resepsionis.temu-dokter.edit', $data->idreservasi_dokter) }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Pilih Pemilik</label>
                                <select name="idpemilik" class="form-control" required>
                                    @foreach($pemilik as $pm)
                                        <option value="{{ $pm->idpemilik }}"
                                            {{ $pemilik_id == $pm->idpemilik ? 'selected' : '' }}>
                                            {{ $pm->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Filter Hewan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- FORM EDIT --}}
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('resepsionis.temu-dokter.update', $data->idreservasi_dokter) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- PET TERFILTER --}}
                        <div class="mb-3">
                            <label>Hewan (Pet) <span class="text-danger">*</span></label>
                            <select name="idpet" class="form-control" required>
                                @foreach($pet as $p)
                                    <option value="{{ $p->idpet }}"
                                        {{ $data->idpet == $p->idpet ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DOKTER --}}
                        <div class="mb-3">
                            <label>Dokter <span class="text-danger">*</span></label>
                            <select name="idrole_user" class="form-control" required>
                                @foreach($dokter as $d)
                                    <option value="{{ $d->idrole_user }}"
                                        {{ $data->idrole_user == $d->idrole_user ? 'selected' : '' }}>
                                        {{ $d->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- STATUS --}}
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="M" {{ $data->status == 'M' ? 'selected' : '' }}>Menunggu</option>
                                <option value="S" {{ $data->status == 'S' ? 'selected' : '' }}>Selesai</option>
                                <option value="B" {{ $data->status == 'B' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>

                        <button class="btn btn-success">Simpan Perubahan</button>
                        <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
@endsection
