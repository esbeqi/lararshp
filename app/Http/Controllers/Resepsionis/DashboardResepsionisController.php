<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardResepsionisController extends Controller
{
    /**
     * Tampilkan dashboard resepsionis (simple & safe).
     */
    public function index(Request $request)
    {
        // Ambil angka-angka ringkas (fallback 0 jika table kosong)
        $totalPemilik = DB::table('pemilik')->count();
        $totalPet     = DB::table('pet')->count();

        $totalDokter = DB::table('role_user as ru')
            ->join('role as r','ru.idrole','=','r.idrole')
            ->where('r.nama_role','Dokter')
            ->count();

        // Ambil antrian hari ini (simple list, bisa ditampilkan tabel)
        $today = now()->toDateString();
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
            ->whereDate('t.waktu_daftar', $today)
            ->orderBy('t.no_urut')
            ->get();

        $totalAntrian = $antrianToday->count();

        return view('resepsionis.dashboard', compact(
            'totalPemilik','totalPet','totalDokter','totalAntrian','antrianToday'
        ));
    }
}
