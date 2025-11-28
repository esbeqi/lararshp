<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $roleUser = DB::table('role_user')
            ->join('role', 'role_user.idrole', '=', 'role.idrole')
            ->where('role_user.iduser', $user->iduser)
            ->where('role.nama_role', 'LIKE', 'Dokter')
            ->select('role_user.*')
            ->first();

        if (! $roleUser) {
            return redirect()->route('home')->with('error', 'Akses tidak tersedia.');
        }

        $idrole_user = $roleUser->idrole_user;

        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->select('r.idrekam_medis','r.created_at','r.anamnesa','r.temuan_klinis','r.diagnosa','p.nama as pet_nama','t.no_urut','t.waktu_daftar')
            ->where('r.dokter_pemeriksa', $idrole_user)
            ->orderBy('r.created_at','desc')
            ->paginate(20);

        return view('dokter.rekam.index', compact('rekam'));
    }

    public function show($idrekam)
    {
        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->select('r.*','t.no_urut','t.waktu_daftar','p.nama as pet_nama','p.idpet','u.nama as pemilik_nama','pm.no_wa')
            ->where('r.idrekam_medis',$idrekam)
            ->first();

        if (! $rekam) {
            return redirect()->route('dokter.rekam.index')->with('error','Rekam medis tidak ditemukan.');
        }

        $detail = DB::table('detail_rekam_medis as d')
            ->leftJoin('kode_tindakan_terapi as k','d.idkode_tindakan_terapi','=','k.idkode_tindakan_terapi')
            ->where('d.idrekam_medis',$idrekam)
            ->select('d.*','k.kode','k.deskripsi_tindakan_terapi')
            ->get();

        $kodes = DB::table('kode_tindakan_terapi')->orderBy('kode')->get();

        return view('dokter.rekam.show', compact('rekam','detail','kodes'));
    }
}
