@extends('layouts.lte.main')
@section('title','Profil Saya')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Profil Saya</h1>
      <p class="text-muted">Data perawat dan informasi akun</p>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      {{-- TABEL RINGKAS PROFIL --}}
      <div class="card mb-4">
        <div class="card-header"><h3 class="card-title">Detail Profil</h3></div>
        <div class="card-body">
          <table class="table table-bordered" style="max-width:720px;">
            <tbody>
              <tr>
                <th width="200">Nama</th>
                <td>{{ $profile->nama ?? '-' }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $profile->email ?? '-' }}</td>
              </tr>
              <tr>
                <th>Alamat</th>
                <td>{{ $profile->alamat ?? '-' }}</td>
              </tr>
              <tr>
                <th>No. HP</th>
                <td>{{ $profile->no_hp ?? '-' }}</td>
              </tr>
              <tr>
                <th>Jenis Kelamin</th>
                <td>
                  @if($profile->jenis_kelamin === 'L') Laki-laki (Pria)
                  @elseif($profile->jenis_kelamin === 'P') Perempuan (Wanita)
                  @else -
                  @endif
                </td>
              </tr>
              <tr>
                <th>Pendidikan</th>
                <td>{{ $profile->pendidikan ?? '-' }}</td>
              </tr>
              <tr>
                <th>ID User</th>
                <td>{{ $profile->id_user ?? '-' }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      {{-- FORM EDIT --}}
      <div class="card">
        <div class="card-header"><h3 class="card-title">Edit Profil</h3></div>
        <div class="card-body">
          <form method="POST" action="{{ route('perawat.profil.update') }}">
            @csrf

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $profile->nama) }}" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $profile->email) }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $profile->alamat) }}">
              </div>

              <div class="col-md-6 mb-3">
                <label>No. HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $profile->no_hp) }}">
              </div>

              <div class="col-md-6 mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                  <option value="">-- Pilih --</option>
                  <option value="L" {{ old('jenis_kelamin', $profile->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki (Pria)</option>
                  <option value="P" {{ old('jenis_kelamin', $profile->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan (Wanita)</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label>Pendidikan</label>
                <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $profile->pendidikan) }}">
              </div>
            </div>

            <div class="d-flex gap-2">
              <button class="btn btn-primary">Simpan Perubahan</button>
              <a href="{{ route('perawat.dashboard') }}" class="btn btn-secondary">Kembali</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection
