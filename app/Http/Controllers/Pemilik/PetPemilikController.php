<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetPemilikController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $pemilik = DB::table('pemilik')->where('iduser', $userId)->first();
        if (! $pemilik) return back()->with('error','Data pemilik tidak ditemukan.');

        $pets = DB::table('pet')->where('idpemilik', $pemilik->idpemilik)->select('*')->orderBy('nama')->get();

        // kumpulkan FK jika ada
        $jenisIds = $rasIds = [];
        foreach ($pets as $p) {
            if (isset($p->idjenis_hewan) && $p->idjenis_hewan) $jenisIds[] = $p->idjenis_hewan;
            if (isset($p->idras_hewan) && $p->idras_hewan) $rasIds[] = $p->idras_hewan;
        }

        $jenisMap = [];
        if (! empty($jenisIds)) {
            $rows = DB::table('jenis_hewan')->whereIn('idjenis_hewan', array_values(array_unique($jenisIds)))->select('idjenis_hewan','nama_jenis_hewan')->get();
            foreach ($rows as $r) $jenisMap[$r->idjenis_hewan] = $r->nama_jenis_hewan;
        }

        $rasMap = [];
        if (! empty($rasIds)) {
            $rows = DB::table('ras_hewan')->whereIn('idras_hewan', array_values(array_unique($rasIds)))->select('idras_hewan','nama_ras')->get();
            foreach ($rows as $r) $rasMap[$r->idras_hewan] = $r->nama_ras;
        }

        foreach ($pets as $p) {
            $p->nama_jenis_hewan = (isset($p->idjenis_hewan) && $p->idjenis_hewan) ? ($jenisMap[$p->idjenis_hewan] ?? null) : (isset($p->jenis_hewan) ? $p->jenis_hewan : null);
            $p->nama_ras = (isset($p->idras_hewan) && $p->idras_hewan) ? ($rasMap[$p->idras_hewan] ?? null) : (isset($p->ras) ? $p->ras : null);
        }

        return view('pemilik.pet.index', compact('pets'));
    }

    public function show($idpet)
    {
        $userId = auth()->id();
        $pemilik = DB::table('pemilik')->where('iduser', $userId)->first();
        if (! $pemilik) return back()->with('error','Pemilik tidak ditemukan.');

        $pet = DB::table('pet')
            ->where('idpet', $idpet)
            ->where('idpemilik', $pemilik->idpemilik)
            ->first();

        if (! $pet) return back()->with('error','Data pet tidak ditemukan atau bukan milik Anda.');

        // lookup jenis & ras (single) — aman jika kolom tidak ada, fallback ke nama langsung
        if (isset($pet->idjenis_hewan) && $pet->idjenis_hewan) {
            $j = DB::table('jenis_hewan')->where('idjenis_hewan', $pet->idjenis_hewan)->select('nama_jenis_hewan')->first();
            $pet->nama_jenis_hewan = $j->nama_jenis_hewan ?? null;
        } elseif (isset($pet->jenis_hewan)) {
            $pet->nama_jenis_hewan = $pet->jenis_hewan;
        } else {
            $pet->nama_jenis_hewan = null;
        }

        if (isset($pet->idras_hewan) && $pet->idras_hewan) {
            $r = DB::table('ras_hewan')->where('idras_hewan', $pet->idras_hewan)->select('nama_ras')->first();
            $pet->nama_ras = $r->nama_ras ?? null;
        } elseif (isset($pet->ras)) {
            $pet->nama_ras = $pet->ras;
        } else {
            $pet->nama_ras = null;
        }

        // ambil info pemilik (gunakan no_wa, bukan no_hp)
        $pem = DB::table('pemilik as pm')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->where('pm.idpemilik', $pet->idpemilik)
            ->select(
                'u.nama as pemilik_nama',
                'u.email as pemilik_email',
                'pm.no_wa as pemilik_no_wa'   // <-- gunakan no_wa
            )
            ->first();

        if ($pem) {
            $pet->pemilik_nama = $pem->pemilik_nama ?? null;
            $pet->pemilik_email = $pem->pemilik_email ?? null;
            $pet->pemilik_no_wa = $pem->pemilik_no_wa ?? null;
        } else {
            $pet->pemilik_nama = null;
            $pet->pemilik_email = null;
            $pet->pemilik_no_wa = null;
        }

        return view('pemilik.pet.show', compact('pet'));
    }
}
