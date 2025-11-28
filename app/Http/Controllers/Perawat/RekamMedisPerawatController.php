<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RekamMedisPerawatController extends Controller
{
    /**
     * INDEX — list rekam medis (header)
     */
    public function index()
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
                't.no_urut',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'd.nama as nama_dokter'
            )
            ->orderBy('r.idrekam_medis', 'desc')
            ->get();

        return view('perawat.rekam_medis.index', compact('rekam'));
    }

    /**
     * CREATE — form buat header rekam medis
     */
    public function create()
    {
        $available = DB::table('temu_dokter as t')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->leftJoin('role_user as ru', 't.idrole_user', '=', 'ru.idrole_user')
            ->leftJoin('user as d', 'ru.iduser', '=', 'd.iduser')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                  ->from('rekam_medis as r')
                  ->whereRaw('r.idreservasi_dokter = t.idreservasi_dokter');
            })
            ->select(
                't.idreservasi_dokter',
                't.no_urut',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'd.nama as nama_dokter'
            )
            ->orderBy('t.no_urut')
            ->get();

        return view('perawat.rekam_medis.create', compact('available'));
    }

    /**
     * STORE — simpan header rekam medis baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'idreservasi_dokter' => 'required|integer|exists:temu_dokter,idreservasi_dokter',
            'dokter_pemeriksa'   => 'nullable|integer|exists:user,iduser',
            'anamnesa'           => 'nullable|string|max:1000',
            'temuan_klinis'      => 'nullable|string|max:1000',
            'diagnosa'           => 'nullable|string|max:1000',
        ]);

        try {
            if (DB::table('rekam_medis')
                ->where('idreservasi_dokter', $validated['idreservasi_dokter'])
                ->exists()) {
                return back()->with('error', 'Rekam medis untuk antrian ini sudah ada.');
            }

            $id = DB::table('rekam_medis')->insertGetId([
                'idreservasi_dokter' => $validated['idreservasi_dokter'],
                'dokter_pemeriksa'   => $validated['dokter_pemeriksa'] ?? null,
                'anamnesa'           => $validated['anamnesa'] ?? null,
                'temuan_klinis'      => $validated['temuan_klinis'] ?? null,
                'diagnosa'           => $validated['diagnosa'] ?? null,
                'created_at'         => now(),
            ]);

            return redirect()->route('perawat.rekam-medis.detail', $id)
                ->with('success', 'Rekam medis berhasil dibuat.');

        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat rekam medis: ' . $e->getMessage());
        }
    }

    /**
     * EDIT header rekam medis (form)
     */
    public function edit($id)
    {
        $rekam = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (! $rekam) return back()->with('error', 'Rekam medis tidak ditemukan.');

        $antrian = DB::table('rekam_medis as r')
            ->join('temu_dokter as t', 'r.idreservasi_dokter', '=', 't.idreservasi_dokter')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select(
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                't.no_urut'
            )
            ->where('r.idrekam_medis', $id)
            ->first();

        return view('perawat.rekam_medis.edit', compact('rekam', 'antrian'));
    }

    /**
     * UPDATE header rekam medis
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'anamnesa'      => 'nullable|string|max:1000',
            'temuan_klinis' => 'nullable|string|max:1000',
            'diagnosa'      => 'nullable|string|max:1000',
        ]);

        try {
            DB::table('rekam_medis')
                ->where('idrekam_medis', $id)
                ->update($validated);

            return redirect()->route('perawat.rekam-medis.detail', $id)
                ->with('success', 'Header rekam medis diperbarui.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * DETAIL — header + detail tindakan (tabel gabungan)
     */
    public function detail($id)
    {
        $antrian = DB::table('rekam_medis as r')
            ->join('temu_dokter as t','r.idreservasi_dokter','=','t.idreservasi_dokter')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->leftJoin('user as d','r.dokter_pemeriksa','=','d.iduser')
            ->select(
                'r.*',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'd.nama as nama_dokter',
                't.no_urut'
            )
            ->where('r.idrekam_medis',$id)
            ->first();

        if (! $antrian) return back()->with('error','Rekam medis tidak ditemukan.');

        // ambil detail tindakan — gunakan kolom 'detail' di DB dan alias menjadi 'keterangan' agar blade tetap work
        $detail = DB::table('detail_rekam_medis as d')
            ->join('kode_tindakan_terapi as kt', 'd.idkode_tindakan_terapi', '=', 'kt.idkode_tindakan_terapi')
            ->leftJoin('kategori as kg', 'kt.idkategori', '=', 'kg.idkategori')
            ->leftJoin('kategori_klinis as kk', 'kt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->select(
                'd.iddetail_rekam_medis',
                'kt.kode',
                'kt.deskripsi_tindakan_terapi',
                'kg.nama_kategori',
                'kk.nama_kategori_klinis',
                DB::raw('d.detail as keterangan')
            )
            ->where('d.idrekam_medis', $id)
            ->orderBy('d.iddetail_rekam_medis','desc')
            ->get();

        // dropdown kode tindakan
        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->select('idkode_tindakan_terapi','kode','deskripsi_tindakan_terapi')
            ->orderBy('deskripsi_tindakan_terapi')
            ->get();

        return view('perawat.rekam_medis.detail', compact('antrian','detail','kodeTindakan'));
    }

    /**
     * STORE tindakan (insert ke kolom 'detail')
     */
    public function storeTindakan(Request $request, $id)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|integer|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'keterangan'             => 'nullable|string|max:500'
        ]);

        try {
            DB::table('detail_rekam_medis')->insert([
                'idrekam_medis'          => $id,
                'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                // simpan ke kolom 'detail' sesuai DB
                'detail'                 => $validated['keterangan'] ?? null,
            ]);

            return back()->with('success','Tindakan berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->with('error','Gagal tambah tindakan: '.$e->getMessage());
        }
    }

    /**
     * EDIT tindakan (form)
     */
    public function editTindakan($iddetail)
    {
        $data = DB::table('detail_rekam_medis as d')
            ->join('kode_tindakan_terapi as kt', 'd.idkode_tindakan_terapi', '=', 'kt.idkode_tindakan_terapi')
            ->select(
                'd.iddetail_rekam_medis',
                'd.idrekam_medis',
                'd.idkode_tindakan_terapi',
                'd.detail',
                'kt.kode',
                'kt.deskripsi_tindakan_terapi'
            )
            ->where('d.iddetail_rekam_medis', $iddetail)
            ->first();

        if (! $data) return back()->with('error','Data tindakan tidak ditemukan.');

        $kodeTindakan = DB::table('kode_tindakan_terapi')
            ->select('idkode_tindakan_terapi','kode','deskripsi_tindakan_terapi')
            ->orderBy('deskripsi_tindakan_terapi')
            ->get();

        return view('perawat.rekam_medis.edit_detail', compact('data','kodeTindakan'));
    }

    /**
     * UPDATE tindakan (update ke kolom 'detail')
     */
    public function updateTindakan(Request $request, $iddetail)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'keterangan'             => 'nullable|string|max:500',
        ]);

        try {
            DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $iddetail)
                ->update([
                    'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                    // update actual column 'detail'
                    'detail'                 => $validated['keterangan'] ?? null,
                ]);

            return back()->with('success','Tindakan berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error','Gagal update tindakan: '.$e->getMessage());
        }
    }

    /**
     * DELETE tindakan
     */
    public function deleteTindakan($iddetail)
    {
        try {
            DB::table('detail_rekam_medis')
                ->where('iddetail_rekam_medis', $iddetail)
                ->delete();

            return back()->with('success','Tindakan dihapus.');
        } catch (Exception $e) {
            return back()->with('error','Gagal hapus: '.$e->getMessage());
        }
    }

    /**
     * DELETE header (beserta detail)
     */
    public function destroy($id)
    {
        try {
            DB::table('detail_rekam_medis')->where('idrekam_medis', $id)->delete();
            DB::table('rekam_medis')->where('idrekam_medis', $id)->delete();

            return redirect()->route('perawat.rekam-medis.index')
                ->with('success','Rekam medis dihapus.');
        } catch (Exception $e) {
            return back()->with('error','Gagal menghapus: '.$e->getMessage());
        }
    }

    /**
     * DETAILS INDEX — daftar semua detail_rekam_medis gabungan dengan header & kategori (paginate + filter)
     */
    public function detailsIndex(Request $request)
    {
        $q = DB::table('detail_rekam_medis as d')
            ->join('rekam_medis as r', 'd.idrekam_medis', '=', 'r.idrekam_medis')
            ->join('temu_dokter as t', 'r.idreservasi_dokter', '=', 't.idreservasi_dokter')
            ->join('pet as p', 't.idpet', '=', 'p.idpet')
            ->leftJoin('pemilik as pm', 'p.idpemilik', '=', 'pm.idpemilik')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->leftJoin('user as duser', 'r.dokter_pemeriksa', '=', 'duser.iduser')
            ->join('kode_tindakan_terapi as kt', 'd.idkode_tindakan_terapi', '=', 'kt.idkode_tindakan_terapi')
            ->leftJoin('kategori as kg', 'kt.idkategori', '=', 'kg.idkategori')
            ->leftJoin('kategori_klinis as kk', 'kt.idkategori_klinis', '=', 'kk.idkategori_klinis')
            ->select(
                'd.iddetail_rekam_medis',
                'd.idrekam_medis',
                'r.idreservasi_dokter',
                't.no_urut',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'duser.nama as nama_dokter',
                'kt.kode',
                'kt.deskripsi_tindakan_terapi',
                'kg.nama_kategori',
                'kk.nama_kategori_klinis',
                DB::raw('d.detail as keterangan')
            );

        if ($request->filled('pet')) {
            $q->where('p.nama', 'like', '%' . $request->pet . '%');
        }

        $details = $q->orderBy('d.iddetail_rekam_medis', 'desc')->paginate(25)->withQueryString();

        return view('perawat.rekam_medis.details_index', compact('details'));
    }

    /**
     * STORE tindakan dari form standalone pada details index
     */
    public function storeTindakanStandalone(Request $request)
    {
        $validated = $request->validate([
            'idrekam_medis' => 'required|integer|exists:rekam_medis,idrekam_medis',
            'idkode_tindakan_terapi' => 'required|integer|exists:kode_tindakan_terapi,idkode_tindakan_terapi',
            'keterangan' => 'nullable|string|max:500',
        ]);

        try {
            DB::table('detail_rekam_medis')->insert([
                'idrekam_medis' => $validated['idrekam_medis'],
                'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                'detail' => $validated['keterangan'] ?? null,
            ]);

            return redirect()->route('perawat.rekam-medis.details.index')
                ->with('success', 'Tindakan berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal tambah tindakan: ' . $e->getMessage());
        }
    }
}
