@extends('layouts.lte.main')

@section('title', 'Tambah Role User')

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
                <form action="{{ route('admin.role-user.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="iduser" class="form-label">User</label>
                            <select name="iduser" id="iduser" class="form-control @error('iduser') is-invalid @enderror" required>
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->iduser }}" {{ old('iduser') == $u->iduser ? 'selected' : '' }}>
                                        {{ $u->nama }} ({{ $u->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('iduser') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="idrole" class="form-label">Role</label>
                            <select name="idrole" id="idrole" class="form-control @error('idrole') is-invalid @enderror" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->idrole }}" {{ old('idrole') == $r->idrole ? 'selected' : '' }}>
                                        {{ $r->nama_role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idrole') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status')=='1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Optional additional fields if role pemilik --}}
                        <div class="mb-3">
                            <label class="form-label">(Opsional) Data Pemilik — hanya diisi bila role = Pemilik</label>
                            <input type="text" name="nama_pemilik" class="form-control mb-2" placeholder="Nama Pemilik (opsional)" value="{{ old('nama_pemilik') }}">
                            <input type="text" name="no_wa" class="form-control mb-2" placeholder="No. WA (opsional)" value="{{ old('no_wa') }}">
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat (opsional)" value="{{ old('alamat') }}">
                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('admin.role-user.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </section>
</div>
@endsection