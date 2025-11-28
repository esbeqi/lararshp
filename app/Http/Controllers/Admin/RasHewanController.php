<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RasHewanController extends Controller
{
    protected string $table = 'ras_hewan';
    protected string $pk = 'idras_hewan';

    public function index()
    {
        $rasHewan = DB::table($this->table . ' as r')
            ->select(
                'r.' . $this->pk,
                'r.nama_ras',
                'r.idjenis_hewan',
                'j.nama_jenis_hewan'
            )
            ->leftJoin('jenis_hewan as j', 'r.idjenis_hewan', '=', 'j.idjenis_hewan')
            ->orderBy('r.' . $this->pk)
            ->get();

        return view('admin.ras-hewan.index', compact('rasHewan'));
    }

    public function create()
    {
        $jenisHewan = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->orderBy('nama_jenis_hewan')
            ->get();

        return view('admin.ras-hewan.create', compact('jenisHewan'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRasHewan($request);

        try {
            $this->createRasHewan($validated);

            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.ras-hewan.create')
                             ->withInput()
                             ->with('error', 'Gagal menambahkan ras hewan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ras = DB::table($this->table)
            ->where($this->pk, $id)
            ->first();

        if (! $ras) {
            return redirect()->route('admin.ras-hewan.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        $jenisHewan = DB::table('jenis_hewan')
            ->select('idjenis_hewan', 'nama_jenis_hewan')
            ->orderBy('nama_jenis_hewan')
            ->get();

        return view('admin.ras-hewan.edit', compact('ras', 'jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateRasHewan($request, $id);

        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->update($this->prepareUpdate($validated));

            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->route('admin.ras-hewan.edit', $id)
                             ->withInput()
                             ->with('error', 'Gagal mengubah ras hewan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->delete();

            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.ras-hewan.index')
                             ->with('error', 'Gagal menghapus ras hewan: ' . $e->getMessage());
        }
    }

    protected function validateRasHewan(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:ras_hewan,nama_ras,' . $id . ',idras_hewan'
            : 'unique:ras_hewan,nama_ras';

        return $request->validate([
            'idjenis_hewan' => ['required', 'exists:jenis_hewan,idjenis_hewan'],
            'nama_ras' => ['required', 'string', 'min:3', 'max:255', $uniqueRule],
        ], [
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
            'idjenis_hewan.exists' => 'Jenis hewan tidak valid.',
            'nama_ras.required' => 'Nama ras hewan wajib diisi.',
            'nama_ras.string' => 'Nama ras harus berupa teks.',
            'nama_ras.min' => 'Nama ras minimal 3 karakter.',
            'nama_ras.max' => 'Nama ras maksimal 255 karakter.',
            'nama_ras.unique' => 'Nama ras hewan sudah ada.',
        ]);
    }

    protected function createRasHewan(array $data)
    {
        try {
            return DB::table($this->table)->insert([
                'idjenis_hewan' => $data['idjenis_hewan'],
                'nama_ras' => $this->formatNamaRas($data['nama_ras']),
                // 'created_at' => now(), // aktifkan jika tabel punya timestamps
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data ras hewan: ' . $e->getMessage());
        }
    }

    protected function prepareUpdate(array $data): array
    {
        return [
            'idjenis_hewan' => $data['idjenis_hewan'],
            'nama_ras' => $this->formatNamaRas($data['nama_ras']),
            // 'updated_at' => now(),
        ];
    }

    protected function formatNamaRas($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}