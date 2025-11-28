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

        $pets = DB::table('pet as p')
            ->where('p.idpemilik', $pemilik->idpemilik)
            ->leftJoin('jenis_hewan as j','p.idjenis_hewan','=','j.idjenis_hewan')
            ->leftJoin('ras_hewan as r','p.idras_hewan','=','r.idras_hewan')
            ->select('p.idpet','p.nama','j.nama_jenis_hewan','r.nama_ras','p.tanggal_lahir','p.jenis_kelamin','p.warna')
            ->orderBy('p.nama')
            ->get();

        return view('pemilik.pet.index', compact('pets'));
    }

    public function show($idpet)
    {
        $userId = auth()->id();
        $pemilik = DB::table('pemilik')->where('iduser',$userId)->first();
        if (! $pemilik) return back()->with('error','Pemilik tidak ditemukan.');

        $pet = DB::table('pet as p')
            ->leftJoin('jenis_hewan as j','p.idjenis_hewan','=','j.idjenis_hewan')
            ->leftJoin('ras_hewan as r','p.idras_hewan','=','r.idras_hewan')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->where('p.idpet',$idpet)
            ->where('p.idpemilik',$pemilik->idpemilik)
            ->select(
                'p.*',
                'j.nama_jenis_hewan',
                'r.nama_ras',
                'pm.idpemilik as pemilik_id',
                'u.nama as pemilik_nama',
                'u.email as pemilik_email',
                'pm.no_hp as pemilik_no_hp'
            )
            ->first();

        if (! $pet) return back()->with('error','Data pet tidak ditemukan atau bukan milik Anda.');

        return view('pemilik.pet.show', compact('pet'));
    }
}
