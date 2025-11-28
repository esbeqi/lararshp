<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $pemilik = DB::table('pemilik')->where('iduser', $userId)->first();
        if (! $pemilik) {
            $stats = (object)[
                'total_pet' => 0,
                'total_rekam' => 0,
                'upcoming_temu' => 0,
            ];
            $pets = collect();
            return view('pemilik.dashboard', compact('stats','pets'));
        }

        $idpemilik = $pemilik->idpemilik;

        // statistik
        $totalPet = DB::table('pet')->where('idpemilik',$idpemilik)->count();
        $totalRekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->where('p.idpemilik',$idpemilik)
            ->count();

        $today = now()->toDateString();
        $upcoming = DB::table('temu_dokter as t')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->where('p.idpemilik', $idpemilik)
            ->whereDate('t.waktu_daftar', $today)
            ->where('t.status','M')
            ->count();

        // daftar pet singkat — join ke jenis_hewan & ras_hewan
        $pets = DB::table('pet as p')
            ->leftJoin('jenis_hewan as j', 'p.idjenis_hewan', '=', 'j.idjenis_hewan')
            ->leftJoin('ras_hewan as r', 'p.idras_hewan', '=', 'r.idras_hewan')
            ->where('p.idpemilik', $idpemilik)
            ->select('p.idpet','p.nama','j.nama_jenis_hewan','r.nama_ras','p.tanggal_lahir')
            ->orderBy('p.nama')
            ->get();

        $stats = (object)[
            'total_pet' => $totalPet,
            'total_rekam' => $totalRekam,
            'upcoming_temu' => $upcoming,
        ];

        return view('pemilik.dashboard', compact('stats','pets'));
    }
}
