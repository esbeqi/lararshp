<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

class RekamMedisController extends Controller
{
    /**
     * INDEX — list rekam medis (paginated)
     */
    public function index(Request $request)
    {
        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t', 'r.idreservasi_dokter', '=', 't.idreservasi_dokter')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->leftJoin('user as d', 'r.dokter_pemeriksa', '=', 'd.iduser')
            ->select(
                'r.idrekam_medis',
                'r.created_at',
                'p.nama as pet_nama',
                'u.nama as pemilik_nama',
                'd.nama as nama_dokter',
                'r.anamnesa',
                'r.temuan_klinis',
                'r.diagnosa'
            )
            ->orderBy('r.idrekam_medis', 'desc')
            ->paginate(15);

        return view('dokter.rekam.index', compact('rekam'));
    }

    /**
     * SHOW — header + detail tindakan (read-only)
     */
    public function show($id)
    {
        // header + pet/pemilik/dokter
        $rekam = DB::table('rekam_medis as r')
            ->join('temu_dokter as t', 'r.idreservasi_dokter', '=', 't.idreservasi_dokter')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->leftJoin('user as d', 'r.dokter_pemeriksa', '=', 'd.iduser')
            ->select(
                'r.*',
                'p.nama as pet_nama',
                'p.tanggal_lahir as pet_tgl_lahir',
                'u.nama as pemilik_nama',
                'u.email as pemilik_email',
                'd.nama as nama_dokter',
                't.no_urut'
            )
            ->where('r.idrekam_medis', $id)
            ->first();

        if (! $rekam) {
            return redirect()->route('dokter.rekam.index')->with('error', 'Rekam medis tidak ditemukan.');
        }

        // defensive select: cek apakah kolom 'detail' dan 'created_at' ada di tabel detail_rekam_medis
        $hasDetailCol = Schema::hasColumn('detail_rekam_medis', 'detail');
        $hasCreatedAt = Schema::hasColumn('detail_rekam_medis', 'created_at');

        $select = [
            'd.iddetail_rekam_medis',
            'kt.kode',
            'kt.deskripsi_tindakan_terapi as tindakan',
            'kg.nama_kategori',
            'kk.nama_kategori_klinis',
        ];

        $select[] = $hasDetailCol ? DB::raw('d.detail as keterangan') : DB::raw('NULL as keterangan');
        $select[] = $hasCreatedAt ? 'd.created_at' : DB::raw('NULL as created_at');

        $detail = DB::table('detail_rekam_medis as d')
            ->join('kode_tindakan_terapi as kt', 'd.idkode_tindakan_terapi', '=', 'kt.idkode_tindakan_terapi')
            ->leftJoin('kategori as kg', 'kt.idkategori', '=', 'kg.idkategori')
            ->leftJoin('kategori_klinis as kk', 'kt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->select($select)
            ->where('d.idrekam_medis', $id)
            ->orderBy('d.iddetail_rekam_medis', 'desc')
            ->get();

        return view('dokter.rekam.show', compact('rekam', 'detail'));
    }
}
