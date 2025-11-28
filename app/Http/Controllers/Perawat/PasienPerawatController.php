<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienPerawatController extends Controller
{
    /**
     * Tampilkan list pasien / antrian untuk perawat (hari ini).
     */
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->toDateString());

        $pasien = DB::table('temu_dokter as t')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->leftJoin('role_user as ru','t.idrole_user','=','ru.idrole_user')
            ->leftJoin('user as d','ru.iduser','=','d.iduser')
            ->select(
                't.idreservasi_dokter',
                't.no_urut',
                'p.idpet',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'd.nama as nama_dokter',
                't.status',
                't.waktu_daftar'
            )
            ->whereDate('t.waktu_daftar', $tanggal)
            ->orderBy('t.no_urut')
            ->paginate(15)
            ->withQueryString();

        return view('perawat.pasien.index', compact('pasien','tanggal'));
    }
}
