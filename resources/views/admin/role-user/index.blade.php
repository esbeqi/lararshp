@extends('layouts.lte.main')

@section('title', 'Manajemen Role User')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Manajemen Role</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tabel Role User</h3>
                    <a href="{{ route('admin.role-user.create') }}" class="btn btn-success">Tambah</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px">#</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width:180px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roleUsers as $ru)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ru->nama_user ?? '-' }}</td>
                                    <td>{{ $ru->email_user ?? '-' }}</td>
                                    <td>{{ $ru->nama_role ?? '-' }}</td>
                                    <td>
                                        @if ($ru->status == 1)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.role-user.edit', $ru->idrole_user) }}" class="btn btn-sm btn-primary">Edit</a>

                                        <form action="{{ route('admin.role-user.destroy', $ru->idrole_user) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus role user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada data role user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
@endsection