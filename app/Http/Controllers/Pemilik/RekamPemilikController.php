<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamPemilikController extends Controller
{
    public function index($idpet)
    {
        $userId = auth()->id();
        $pemilik = DB::table('pemilik')->where('iduser',$userId)->first();
        if (! $pemilik) return back()->with('error','Pemilik tidak ditemukan.');

        $exists = DB::table('pet')->where('idpet',$idpet)->where('idpemilik',$pemilik->idpemilik)->exists();
        if (! $exists) return back()->with('error','Pet tidak ditemukan atau bukan milik Anda.');

        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->leftJoin('role_user as ru','t.idrole_user','=','ru.idrole_user')
            ->leftJoin('user as d','ru.iduser','=','d.iduser')
            ->select('r.idrekam_medis','r.created_at','d.nama as nama_dokter','t.no_urut')
            ->where('t.idpet',$idpet)
            ->orderBy('r.created_at','desc')
            ->get();

        return view('pemilik.pet.rekam_index', compact('rekam','idpet'));
    }

    public function show($idrekam)
    {
        $antrian = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->leftJoin('user as d','r.dokter_pemeriksa','=','d.iduser')
            ->select('r.*','p.nama as nama_pet','u.nama as nama_pemilik','d.nama as nama_dokter')
            ->where('r.idrekam_medis', $idrekam)
            ->first();

        if (! $antrian) return back()->with('error','Rekam medis tidak ditemukan.');

        // ambil detail tindakan (gabungkan kategori & kategori klinis)
        $detail = DB::table('detail_rekam_medis as d')
            ->join('kode_tindakan_terapi as kt','d.idkode_tindakan_terapi','=','kt.idkode_tindakan_terapi')
            ->leftJoin('kategori as kg','kt.idkategori','=','kg.idkategori')
            ->leftJoin('kategori_klinis as kk','kt.idkategori_klinis','=','kk.idkategori_klinis')
            ->select(
                'd.iddetail_rekam_medis',
                'kt.kode',
                'kt.deskripsi_tindakan_terapi',
                'kg.nama_kategori',
                'kk.nama_kategori_klinis',
                DB::raw('d.detail as keterangan'),
                'd.created_at'
            )
            ->where('d.idrekam_medis', $idrekam)
            ->orderBy('d.iddetail_rekam_medis','desc')
            ->get();

        return view('pemilik.rekam.show', compact('antrian','detail'));
    }
}
