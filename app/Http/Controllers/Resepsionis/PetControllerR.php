<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PetControllerR extends Controller
{
    public function index()
    {
        $pet = DB::table('pet as p')
            ->join('pemilik as pm','p.idpemilik','=','pm.idpemilik')
            ->join('user as u','pm.iduser','=','u.iduser')
            ->join('ras_hewan as r','p.idras_hewan','=','r.idras_hewan')
            ->join('jenis_hewan as j','r.idjenis_hewan','=','j.idjenis_hewan')
            ->select(
                'p.*','u.nama as nama_pemilik',
                'r.nama_ras','j.nama_jenis_hewan'
            )
            ->orderBy('p.idpet','desc')
            ->paginate(12);

        return view('resepsionis.pet.index', compact('pet'));
    }

    public function create(Request $request)
    {
        // ambil daftar pemilik
        $pemilik = DB::table('pemilik as pm')
            ->join('user as u','pm.iduser','=','u.iduser')
            ->select('pm.idpemilik','u.nama')
            ->orderBy('u.nama')
            ->get();

        // ambil jenis hewan
        $jenis = DB::table('jenis_hewan')
            ->orderBy('nama_jenis_hewan')->get();

        // jika ingin preselect pemilik
        $pemilik_id = $request->pemilik_id ?? null;

        // daftar ras
        $rasGrouped = DB::table('ras_hewan as r')
            ->join('jenis_hewan as j','r.idjenis_hewan','=','j.idjenis_hewan')
            ->select('r.idras_hewan','r.nama_ras','j.nama_jenis_hewan')
            ->orderBy('j.nama_jenis_hewan')
            ->orderBy('r.nama_ras')
            ->get()
            ->groupBy('nama_jenis_hewan');

        return view('resepsionis.pet.create', compact('pemilik','jenis','pemilik_id','rasGrouped'));
    }

    public function store(Request $request)
    {
        // DEBUG: uncomment dd() saat butuh inspeksi cepat,
        \Log::info('PET STORE INPUT', $request->all());

        $validated = $request->validate([
            'idpemilik'     => 'required|integer|exists:pemilik,idpemilik',
            'nama'          => 'required|string|max:255',
            'idjenis_hewan' => 'required|integer|exists:jenis_hewan,idjenis_hewan',
            'idras_hewan'   => 'required|integer|exists:ras_hewan,idras_hewan',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'warna_tanda'   => 'nullable|string|max:255',
        ]);

        try {
            DB::table('pet')->insert([
                'idpemilik'     => $validated['idpemilik'],
                'nama'          => $validated['nama'],        // <--- pastikan kolom DB = 'nama'
                'idras_hewan'   => $validated['idras_hewan'],
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'warna_tanda'   => $validated['warna_tanda'] ?? null,
            ]);

            return redirect()->route('resepsionis.pet.index')->with('success', 'Hewan berhasil ditambahkan.');
        } catch (\Exception $e) {
            \Log::error('PET STORE ERROR: '.$e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambah hewan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pet = DB::table('pet')->where('idpet',$id)->first();
        if (! $pet) return redirect()->back()->with('error','Data tidak ditemukan.');

        $pemilik = DB::table('pemilik as pm')
            ->join('user as u','pm.iduser','=','u.iduser')
            ->select('pm.idpemilik','u.nama')
            ->get();

        $jenis = DB::table('jenis_hewan')->get();

        $ras = DB::table('ras_hewan as r')
            ->join('jenis_hewan as j','r.idjenis_hewan','=','j.idjenis_hewan')
            ->select('r.idras_hewan','r.nama_ras','r.idjenis_hewan')
            ->orderBy('r.nama_ras')
            ->get();

        return view('resepsionis.pet.edit', compact('pet','pemilik','jenis','ras'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'idpemilik' => 'required|integer|exists:pemilik,idpemilik',
            'nama' => 'required|string|max:255',
            'idjenis_hewan' => 'required|integer|exists:jenis_hewan,idjenis_hewan',
            'idras_hewan' => 'required|integer|exists:ras_hewan,idras_hewan',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'warna_tanda' => 'nullable|string|max:255',
        ]);

        try {
            DB::table('pet')->where('idpet',$id)->update([
                'idpemilik' => $validated['idpemilik'],
                'nama' => $validated['nama'],
                'idras_hewan' => $validated['idras_hewan'],
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'warna_tanda' => $validated['warna_tanda'] ?? null,
            ]);

            return redirect()->route('resepsionis.pet.index')
                ->with('success','Data hewan berhasil diperbarui.');

        } catch (Exception $e) {
            return back()->withInput()
                ->with('error','Gagal memperbarui hewan: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('pet')->where('idpet',$id)->delete();
            return redirect()->route('resepsionis.pet.index')->with('success','Berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('resepsionis.pet.index')->with('error','Gagal hapus: '.$e->getMessage());
        }
    }
}
