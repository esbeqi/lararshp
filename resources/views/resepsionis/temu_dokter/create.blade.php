@extends('layouts.lte.main')

@section('title','Buat Antrian Temu Dokter')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Buat Antrian Temu Dokter</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            {{-- FORM FILTER PEMILIK --}}
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('resepsionis.temu-dokter.create') }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Pilih Pemilik</label>
                                <select name="idpemilik" class="form-control" required>
                                    <option value="">-- Pilih Pemilik --</option>
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

            {{-- FORM UTAMA --}}
            @if($pemilik_id)
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('resepsionis.temu-dokter.store') }}" method="POST">
                        @csrf

                        {{-- Pet hasil filter --}}
                        <div class="mb-3">
                            <label>Hewan (Pet) <span class="text-danger">*</span></label>
                            <select name="idpet" class="form-control" required>
                                @foreach($pet as $p)
                                    <option value="{{ $p->idpet }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Dokter --}}
                        <div class="mb-3">
                            <label>Dokter <span class="text-danger">*</span></label>
                            <select name="idrole_user" class="form-control" required>
                                @foreach($dokter as $d)
                                    <option value="{{ $d->idrole_user }}">{{ $d->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-success">Buat Antrian</button>
                        <a class="btn btn-secondary" href="{{ route('resepsionis.temu-dokter.index') }}">Kembali</a>
                    </form>
                </div>
            </div>
            @else
                <p class="text-muted">Pilih pemilik lalu klik <strong>Filter Hewan</strong> untuk melanjutkan.</p>
            @endif

        </div>
    </section>
</div>
@endsection
