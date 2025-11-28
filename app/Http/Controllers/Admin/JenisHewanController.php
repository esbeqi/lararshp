<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class JenisHewanController extends Controller
{
    public function index()
    {
        $jenisHewan = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->orderBy('idjenis_hewan')
            ->get();

        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateJenisHewan($request);

        try {
            $this->createJenisHewan($validatedData);

            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.jenis-hewan.index')
                             ->with('error', 'Gagal menambahkan jenis hewan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $hewan = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->where('idjenis_hewan', $id)
            ->first();

        if (! $hewan) {
            return redirect()->route('admin.jenis-hewan.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.jenis-hewan.edit', compact('hewan'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateJenisHewan($request, $id);

        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
                    'nama_jenis_hewan' => $this->formatNamaJenisHewan($validatedData['nama_jenis_hewan']),
                    // 'updated_at' => now(), // dihapus
                ]);

            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->route('admin.jenis-hewan.index')
                             ->with('error', 'Gagal mengubah jenis hewan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->delete();

            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.jenis-hewan.index')
                             ->with('error', 'Gagal menghapus jenis hewan: ' . $e->getMessage());
        }
    }

    protected function createJenisHewan(array $data)
    {
        try {
            return DB::table('jenis_hewan')->insert([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data jenis hewan: ' . $e->getMessage());
        }
    }

    protected function validateJenisHewan(Request $request, $id = null)
    {
        $uniqueRule = $id ?
            'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan' :
            'unique:jenis_hewan,nama_jenis_hewan';

        return $request->validate([
            'nama_jenis_hewan' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule,
            ],
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string'   => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max'      => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.min'      => 'Nama jenis hewan minimal 3 karakter.',
            'nama_jenis_hewan.unique'   => 'Nama jenis hewan sudah ada.',
        ]);
    }

    protected function formatNamaJenisHewan($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}
