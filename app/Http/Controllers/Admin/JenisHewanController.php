<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class JenisHewanController extends Controller
{
    /* =====================================================
     * INDEX
     * ===================================================== */
    public function index()
    {
        // data aktif
        $jenisHewan = DB::table('jenis_hewan')
            ->whereNull('deleted_at')
            ->orderBy('idjenis_hewan')
            ->get();

        // data terhapus (soft delete)
        $jenisHewanDeleted = DB::table('jenis_hewan')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('admin.jenis-hewan.index', compact(
            'jenisHewan',
            'jenisHewanDeleted'
        ));
    }

    /* =====================================================
     * CREATE
     * ===================================================== */
    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    /* =====================================================
     * STORE
     * ===================================================== */
    public function store(Request $request)
    {
        $data = $this->validateJenisHewan($request);

        try {
            DB::table('jenis_hewan')->insert([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menambah data: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * EDIT
     * ===================================================== */
    public function edit($id)
    {
        $hewan = DB::table('jenis_hewan')
            ->where('idjenis_hewan', $id)
            ->whereNull('deleted_at')
            ->first();

        if (! $hewan) {
            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.jenis-hewan.edit', compact('hewan'));
    }

    /* =====================================================
     * UPDATE
     * ===================================================== */
    public function update(Request $request, $id)
    {
        $data = $this->validateJenisHewan($request, $id);

        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
                    'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
                ]);

            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * SOFT DELETE
     * ===================================================== */
    public function destroy($id)
    {
        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
                    'deleted_at' => now(),
                    'deleted_by' => auth()->id(),
                ]);

            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil dihapus (soft delete).');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * RESTORE
     * ===================================================== */
    public function restore($id)
    {
        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
                    'deleted_at' => null,
                    'deleted_by' => null,
                ]);

            return redirect()
                ->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil direstore.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal restore data: ' . $e->getMessage());
        }
    }

    /* =====================================================
     * VALIDATION
     * ===================================================== */
    protected function validateJenisHewan(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan'
            : 'unique:jenis_hewan,nama_jenis_hewan';

        return $request->validate([
            'nama_jenis_hewan' => [
                'required',
                'string',
                'min:3',
                'max:255',
                $uniqueRule,
            ],
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.unique'   => 'Nama jenis hewan sudah ada.',
        ]);
    }

    /* =====================================================
     * FORMAT NAMA
     * ===================================================== */
    protected function formatNamaJenisHewan($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
