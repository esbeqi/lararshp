<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ambil record role_user untuk user login yang bernama role 'Dokter'
        $roleUser = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $user->iduser)
            ->where('role.nama_role', 'LIKE', 'Dokter')
            ->select('role_user.*')
            ->first();

        // jika bukan dokter, arahkan atau tampilkan kosong (atau abort)
        if (! $roleUser) {
            // kamu bilang auth + middleware sudah aman, tapi jaga fallback:
            return redirect()->route('home')->with('error', 'Akses dashboard dokter tidak tersedia.');
        }

        $idrole_user = $roleUser->idrole_user;
        $today = date('Y-m-d');

        // 1. jumlah antrian hari ini (status '1' dianggap aktif/antri)
        $countAntrianToday = DB::table('temu_dokter')
            ->where('idrole_user', $idrole_user)
            ->whereRaw('DATE(waktu_daftar) = ?', [$today])
            ->where('status', '1')
            ->count();

        // 2. total pasien unik yang pernah ditangani dokter ini (distinct idpet)
        $totalPasien = DB::table('temu_dokter')
            ->where('idrole_user', $idrole_user)
            ->distinct()
            ->count('idpet');

        // 3. total rekam medis yang dibuat oleh dokter ini
        $totalRekam = DB::table('rekam_medis')
            ->where('dokter_pemeriksa', $idrole_user)
            ->count();

        // 4. jumlah rekam medis keseluruhan (opsional)
        $totalRekamGlobal = DB::table('rekam_medis')->count();

        // 5. next upcoming appointments (5 item)
        $upcoming = DB::table('temu_dokter as t')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select('t.idreservasi_dokter','t.no_urut','t.waktu_daftar','t.status','p.nama as pet_nama','u.nama as pemilik_nama','pm.no_wa')
            ->where('t.idrole_user', $idrole_user)
            ->where('t.status', '1')
            ->orderBy('t.waktu_daftar', 'asc')
            ->limit(5)
            ->get();

        return view('dokter.dashboard.index', compact(
            'countAntrianToday',
            'totalPasien',
            'totalRekam',
            'totalRekamGlobal',
            'upcoming'
        ));
    }
}
