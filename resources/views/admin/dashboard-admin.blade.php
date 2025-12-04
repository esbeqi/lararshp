@extends('layouts.lte.main')

@section('title', 'Dashboard Admin')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Admin</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <!-- Total Pemilik -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ \Illuminate\Support\Facades\DB::table('pemilik')->count() }}</h3>
                        <p>Total Pemilik</p>
                    </div>
                    <div class="small-box-icon">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <a href="{{ route('admin.pemilik.index') }}" class="small-box-footer link-light">Lihat Data</a>
                </div>
            </div>

            <!-- Total Pet -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ \Illuminate\Support\Facades\DB::table('pet')->count() }}</h3>
                        <p>Total Hewan (Pet)</p>
                    </div>
                    <div class="small-box-icon">
                        <i class="fas fa-paw fa-2x"></i>
                    </div>
                    <a href="{{ route('admin.pet.index') }}" class="small-box-footer link-light">Lihat Data</a>
                </div>
            </div>

            <!-- Dokter Aktif -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ \Illuminate\Support\Facades\DB::table('role_user')->join('role','role_user.idrole','=','role.idrole')->where('role.nama_role','Dokter')->count() }}</h3>
                        <p>Dokter Aktif</p>
                    </div>
                    <div class="small-box-icon">
                        <i class="fas fa-user-md fa-2x"></i>
                    </div>
                    <a href="{{ route('admin.user.index') }}" class="small-box-footer link-dark">Info Dokter</a>
                </div>
            </div>

            <!-- Antrian Hari Ini -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{ \Illuminate\Support\Facades\DB::table('temu_dokter')->whereDate('waktu_daftar', now()->toDateString())->count() }}</h3>
                        <p>Antrian Hari Ini</p>
                    </div>
                    <div class="small-box-icon">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <a href="{{ route('resepsionis.temu-dokter.index') }}" class="small-box-footer link-light">Kelola Antrian</a>
                </div>
            </div>
        </div>

        <!-- contoh panel ringkasan / tabel -->
        <div class="row mt-3">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Antrian Hari Ini (Preview)</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th style="width:80px">No Urut</th>
                                    <th>Hewan</th>
                                    <th>Pemilik</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $preview = \Illuminate\Support\Facades\DB::table('temu_dokter as t')
                                        ->join('pet as p','t.idpet','=','p.idpet')
                                        ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
                                        ->leftJoin('user as u','pm.iduser','=','u.iduser')
                                        ->whereDate('t.waktu_daftar', now()->toDateString())
                                        ->orderBy('t.no_urut')
                                        ->limit(6)
                                        ->get();
                                @endphp

                                @forelse($preview as $row)
                                    <tr>
                                        <td>{{ $row->no_urut }}</td>
                                        <td>{{ $row->nama ?? '-' }}</td>
                                        <td>{{ $row->nama ?? ($row->nama_pemilik ?? '-') }}</td>
                                        <td>
                                            @if($row->status === 'M') <span class="badge bg-warning">Menunggu</span>
                                            @elseif($row->status === 'S') <span class="badge bg-success">Selesai</span>
                                            @elseif($row->status === 'B') <span class="badge bg-danger">Batal</span>
                                            @else <span class="badge bg-secondary">{{ $row->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">Belum ada antrian hari ini</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Informasi Penting</h3></div>
                    <div class="card-body">
                        <ul>
                            <li>Periksa data pemilik dan hewan sebelum membuat transaksi antrian.</li>
                            <li>Antrian otomatis diberi nomor urut berdasarkan hari.</li>
                            <li>Gunakan menu Master Data untuk mengelola referensi.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
