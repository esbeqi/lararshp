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
        $totalPet = DB::table('pet')->where('idpemilik', $idpemilik)->count();
        $totalRekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->where('p.idpemilik',$idpemilik)->count();

        $today = now()->toDateString();
        $upcoming = DB::table('temu_dokter as t')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->where('p.idpemilik', $idpemilik)
            ->whereDate('t.waktu_daftar', $today)
            ->where('t.status', 'M')
            ->count();

        // ambil pet tanpa join (aman)
        $pets = DB::table('pet')
            ->where('idpemilik', $idpemilik)
            ->select('*')
            ->orderBy('nama', 'asc')
            ->get();

        // kumpulkan id jenis & ras (jika ada) lalu fetch sekali
        $jenisIds = [];
        $rasIds = [];
        foreach ($pets as $p) {
            if (isset($p->idjenis_hewan) && $p->idjenis_hewan) $jenisIds[] = $p->idjenis_hewan;
            if (isset($p->idras_hewan) && $p->idras_hewan) $rasIds[] = $p->idras_hewan;
        }

        $jenisMap = [];
        if (! empty($jenisIds)) {
            $rows = DB::table('jenis_hewan')
                ->whereIn('idjenis_hewan', array_values(array_unique($jenisIds)))
                ->select('idjenis_hewan','nama_jenis_hewan')
                ->get();
            foreach ($rows as $r) $jenisMap[$r->idjenis_hewan] = $r->nama_jenis_hewan;
        }

        $rasMap = [];
        if (! empty($rasIds)) {
            $rows = DB::table('ras_hewan')
                ->whereIn('idras_hewan', array_values(array_unique($rasIds)))
                ->select('idras_hewan','nama_ras')
                ->get();
            foreach ($rows as $r) $rasMap[$r->idras_hewan] = $r->nama_ras;
        }

        // pasang nama_jenis_hewan & nama_ras ke objek pet untuk blade
        foreach ($pets as $p) {
            if (isset($p->idjenis_hewan) && $p->idjenis_hewan) {
                $p->nama_jenis_hewan = $jenisMap[$p->idjenis_hewan] ?? null;
            } elseif (isset($p->jenis_hewan)) {
                $p->nama_jenis_hewan = $p->jenis_hewan;
            } else {
                $p->nama_jenis_hewan = null;
            }

            if (isset($p->idras_hewan) && $p->idras_hewan) {
                $p->nama_ras = $rasMap[$p->idras_hewan] ?? null;
            } elseif (isset($p->ras)) {
                $p->nama_ras = $p->ras;
            } else {
                $p->nama_ras = null;
            }
        }

        $stats = (object)[
            'total_pet' => $totalPet,
            'total_rekam' => $totalRekam,
            'upcoming_temu' => $upcoming,
        ];

        return view('pemilik.dashboard', compact('stats','pets'));
    }
}
