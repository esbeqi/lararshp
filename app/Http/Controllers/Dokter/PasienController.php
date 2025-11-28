<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
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

        $temu = DB::table('temu_dokter as t')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->select('t.idreservasi_dokter','t.no_urut','t.waktu_daftar','t.status','p.idpet','p.nama as pet_nama','p.tanggal_lahir','u.nama as pemilik_nama','pm.no_wa')
            ->where('t.idrole_user', $idrole_user)
            ->orderBy('t.waktu_daftar','desc')
            ->paginate(15);

        return view('dokter.pasien.index', compact('temu'));
    }

    public function show($idpet)
    {
        $pet = DB::table('pet')
            ->leftJoin('pemilik','pet.idpemilik','=','pemilik.idpemilik')
            ->leftJoin('user','pemilik.iduser','=','user.iduser')
            ->where('pet.idpet', $idpet)
            ->select('pet.*','pemilik.no_wa','pemilik.alamat','user.nama as pemilik_nama')
            ->first();

        if (! $pet) {
            return redirect()->route('dokter.pasien.index')->with('error','Data pet tidak ditemukan.');
        }

        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->where('t.idpet', $idpet)
            ->select('r.*','t.no_urut','t.waktu_daftar')
            ->orderBy('r.created_at','desc')
            ->get();

        return view('dokter.pasien.show', compact('pet','rekam'));
    }
}
