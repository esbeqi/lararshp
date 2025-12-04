<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamPemilikController extends Controller
{
    /**
     * Index — daftar rekam medis untuk sebuah pet (idpet)
     */
    public function index($idpet)
    {
        $userId = auth()->id();

        // pastikan pemilik
        $pemilik = DB::table('pemilik')->where('iduser', $userId)->first();
        if (! $pemilik) {
            return back()->with('error', 'Data pemilik tidak ditemukan.');
        }

        // pastikan pet milik pemilik
        $petExists = DB::table('pet')->where('idpet', $idpet)->where('idpemilik', $pemilik->idpemilik)->exists();
        if (! $petExists) {
            return back()->with('error', 'Pet tidak ditemukan atau bukan milik Anda.');
        }

        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t', 'r.idreservasi_dokter', '=', 't.idreservasi_dokter')
            ->leftJoin('role_user as ru', 't.idrole_user', '=', 'ru.idrole_user')
            ->leftJoin('user as d', 'ru.iduser', '=', 'd.iduser')
            ->where('t.idpet', $idpet)
            ->select('r.idrekam_medis', 'r.created_at', 'd.nama as nama_dokter', 't.no_urut')
            ->orderBy('r.created_at', 'desc')
            ->get();

        return view('pemilik.rekam.index', compact('rekam','idpet'));
    }

    /**
     * Show — detail rekam medis (header + detail tindakan)
     */
    public function show($idrekam)
    {
        $userId = auth()->id();

        $pemilik = DB::table('pemilik')->where('iduser', $userId)->first();
        if (! $pemilik) {
            return back()->with('error', 'Data pemilik tidak ditemukan.');
        }

        // header rekam medis (cek kepemilikan pet juga)
        $header = DB::table('rekam_medis as r')
            ->join('temu_dokter as t', 'r.idreservasi_dokter', '=', 't.idreservasi_dokter')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('user as d', 'r.dokter_pemeriksa', '=', 'd.iduser')
            ->where('r.idrekam_medis', $idrekam)
            ->where('p.idpemilik', $pemilik->idpemilik)
            ->select('r.*', 'p.nama as nama_pet', 'd.nama as nama_dokter', 't.no_urut', 'p.idpet')
            ->first();

        if (! $header) {
            return back()->with('error', 'Rekam medis tidak ditemukan atau bukan milik Anda.');
        }

        // detail tindakan — jangan pakai d.created_at jika kolom tidak ada
        $detail = DB::table('detail_rekam_medis as d')
            ->join('kode_tindakan_terapi as kt', 'd.idkode_tindakan_terapi', '=', 'kt.idkode_tindakan_terapi')
            ->leftJoin('kategori as kg', 'kt.idkategori', '=', 'kg.idkategori')
            ->leftJoin('kategori_klinis as kk', 'kt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->where('d.idrekam_medis', $idrekam)
            ->select(
                'd.iddetail_rekam_medis',
                'kt.kode',
                'kt.deskripsi_tindakan_terapi',
                'kg.nama_kategori',
                'kk.nama_kategori_klinis',
                DB::raw('d.detail as keterangan')
            )
            ->orderBy('d.iddetail_rekam_medis', 'desc')
            ->get();

        return view('pemilik.rekam.show', compact('header','detail'));
    }
}
