<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardPerawatController extends Controller
{
    public function index()
    {
        // Total Rekam Medis
        $totalRekamMedis = DB::table('rekam_medis')->count();

        // Total tindakan (berdasarkan rekam_medis.created_at karena detail tidak punya timestamp)
        $totalTindakanHariIni = DB::table('detail_rekam_medis as d')
            ->join('rekam_medis as r', 'd.idrekam_medis', '=', 'r.idrekam_medis')
            ->whereDate('r.created_at', now()->toDateString())
            ->count();

        // Total pasien hari ini dari antrian
        $totalPasienHariIni = DB::table('temu_dokter')
            ->whereDate('waktu_daftar', now()->toDateString())
            ->count();

        // Ambil antrian hari ini (untuk tabel)
        $antrianToday = DB::table('temu_dokter as t')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->leftJoin('role_user as ru','t.idrole_user','=','ru.idrole_user')
            ->leftJoin('user as d','ru.iduser','=','d.iduser')
            ->select(
                't.idreservasi_dokter',
                't.no_urut',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'd.nama as nama_dokter',
                't.status',
                't.waktu_daftar'
            )
            ->whereDate('t.waktu_daftar', now()->toDateString())
            ->orderBy('t.no_urut')
            ->limit(20)
            ->get();

        return view('perawat.dashboard', compact(
            'totalRekamMedis',
            'totalTindakanHariIni',
            'totalPasienHariIni',
            'antrianToday'
        ));
    }
}
