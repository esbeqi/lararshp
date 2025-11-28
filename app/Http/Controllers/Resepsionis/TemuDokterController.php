<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TemuDokterController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->toDateString());

        $antrian = DB::table('temu_dokter as t')
            ->join('pet as p','t.idpet','=','p.idpet')
            ->leftJoin('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->leftJoin('role_user as ru','t.idrole_user','=','ru.idrole_user')
            ->leftJoin('role as r','ru.idrole','=','r.idrole')
            ->leftJoin('user as d','ru.iduser','=','d.iduser')
            ->select(
                't.*',
                'p.nama as nama_pet',
                'u.nama as nama_pemilik',
                'd.nama as nama_dokter'
            )
            ->whereDate('t.waktu_daftar', $tanggal)
            ->orderBy('t.no_urut')
            ->paginate(15);

        return view('resepsionis.temu_dokter.index', compact('antrian','tanggal'));
    }

    public function create(Request $request)
    {
        // Ambil semua pemilik
        $pemilik = DB::table('pemilik as pm')
            ->join('user as u','pm.iduser','=','u.iduser')
            ->select('pm.idpemilik','u.nama')
            ->orderBy('u.nama')
            ->get();

        // Ambil idpemilik jika dipilih dari dropdown
        $pemilik_id = $request->get('idpemilik');

        // Default pet kosong
        $pet = collect([]);

        // Jika pemilik dipilih → ambil pet miliknya
        if ($pemilik_id) {
            $pet = DB::table('pet')
                ->where('idpemilik', $pemilik_id)
                ->select('idpet','nama')
                ->orderBy('nama')
                ->get();
        }

        // List Dokter
        $dokter = DB::table('role_user as ru')
            ->join('role','ru.idrole','=','role.idrole')
            ->join('user','ru.iduser','=','user.iduser')
            ->where('role.nama_role','Dokter')
            ->select('ru.idrole_user','user.nama')
            ->orderBy('user.nama')
            ->get();

        return view('resepsionis.temu_dokter.create', compact('pemilik','pemilik_id','pet','dokter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idpet'        => 'required|integer|exists:pet,idpet',
            'idrole_user'  => 'required|integer|exists:role_user,idrole_user',
        ]);

        try {
            $tanggal = now()->toDateString();

            $maxToday = DB::table('temu_dokter')
                ->whereDate('waktu_daftar', $tanggal)
                ->max('no_urut');

            $noUrut = $maxToday ? $maxToday + 1 : 1;

            DB::table('temu_dokter')->insert([
                'no_urut'      => $noUrut,
                'waktu_daftar' => now(),
                'status'       => 'M',
                'idpet'        => $validated['idpet'],
                'idrole_user'  => $validated['idrole_user'],
            ]);

            return redirect()->route('resepsionis.temu-dokter.index')
                ->with('success','Antrian berhasil dibuat.');
        }
        catch (Exception $e) {
            return back()->withInput()->with('error','Gagal membuat antrian: '.$e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        // ambil data antrian
        $data = DB::table('temu_dokter')->where('idreservasi_dokter', $id)->first();
        if (! $data) {
            return redirect()->route('resepsionis.temu-dokter.index')->with('error', 'Data tidak ditemukan.');
        }

        // Ambil semua pemilik
        $pemilik = DB::table('pemilik as pm')
            ->join('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select('pm.idpemilik', 'u.nama')
            ->orderBy('u.nama')
            ->get();

        // Tentukan pemilik pilihan
        // 1. Jika user memilih pemilik via GET → pakai GET
        // 2. Jika tidak → pakai pemilik dari data antrian (hewan yg terdaftar)
        $pemilik_id = $request->get('idpemilik');
        if (!$pemilik_id) {
            $pemilik_id = DB::table('pet')
                ->where('idpet', $data->idpet)
                ->value('idpemilik');
        }

        // Ambil list PET berdasarkan pemilik
        $pet = DB::table('pet')
            ->where('idpemilik', $pemilik_id)
            ->select('idpet', 'nama')
            ->orderBy('nama')
            ->get();

        // List Dokter
        $dokter = DB::table('role_user as ru')
            ->join('role', 'ru.idrole', '=', 'role.idrole')
            ->join('user', 'ru.iduser', '=', 'user.iduser')
            ->where('role.nama_role', 'Dokter')
            ->select('ru.idrole_user', 'user.nama')
            ->orderBy('user.nama')
            ->get();

        return view('resepsionis.temu_dokter.edit', compact('data', 'pemilik', 'pemilik_id', 'pet', 'dokter'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idpet'        => 'required|integer|exists:pet,idpet',
            'idrole_user'  => 'required|integer|exists:role_user,idrole_user',
            'status'       => 'required|in:M,S,B',
        ]);

        try {
            DB::table('temu_dokter')->where('idreservasi_dokter',$id)->update([
                'idpet'        => $validated['idpet'],
                'idrole_user'  => $validated['idrole_user'],
                'status'       => $validated['status'],
            ]);

            return redirect()->route('resepsionis.temu-dokter.index')
                ->with('success','Antrian berhasil diperbarui.');
        }
        catch (Exception $e) {
            return back()->withInput()->with('error','Gagal update: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('temu_dokter')->where('idreservasi_dokter',$id)->delete();
            return redirect()->route('resepsionis.temu-dokter.index')->with('success','Data antrian dihapus.');
        }
        catch (Exception $e) {
            return redirect()->route('resepsionis.temu-dokter.index')->with('error','Gagal menghapus: '.$e->getMessage());
        }
    }

    // Kalau nanti mau dipakai (tidak wajib)
    public function petByPemilik($idpemilik)
    {
        return DB::table('pet')
            ->where('idpemilik',$idpemilik)
            ->select('idpet','nama')
            ->orderBy('nama')
            ->get();
    }
}
