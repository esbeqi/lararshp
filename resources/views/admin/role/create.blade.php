<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Role</title>
</head>
<body>
    <h1>Tambah Role</h1>

    <form action="{{ route('admin.role.store') }}" method="POST">
        @csrf
        <label>Nama Role:</label><br>
        <input type="text" name="nama_role" value="{{ old('nama_role') }}"><br>
        @error('nama_role') <small style="color:red">{{ $message }}</small><br> @enderror

        <button type="submit">Simpan</button>
    </form>

    <a href="{{ route('admin.role.index') }}">Kembali ke daftar</a>
</body>
</html>