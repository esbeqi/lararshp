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

    public function index(Request $request)
    {
        $isTrash = $request->query('trash');

        $rasHewan = DB::table($this->table . ' as r')
            ->leftJoin('jenis_hewan as j', 'r.idjenis_hewan', '=', 'j.idjenis_hewan')
            ->select(
                'r.' . $this->pk,
                'r.nama_ras',
                'r.deleted_at',
                'j.nama_jenis_hewan'
            )
            ->when(!$isTrash, fn ($q) => $q->whereNull('r.deleted_at'))
            ->when($isTrash, fn ($q) => $q->whereNotNull('r.deleted_at'))
            ->orderBy('r.' . $this->pk)
            ->get();

        return view('admin.ras-hewan.index', compact('rasHewan', 'isTrash'));
    }

    public function create()
    {
        $jenisHewan = DB::table('jenis_hewan')
            ->whereNull('deleted_at')
            ->orderBy('nama_jenis_hewan')
            ->get();

        return view('admin.ras-hewan.create', compact('jenisHewan'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRasHewan($request);

        DB::table($this->table)->insert([
            'idjenis_hewan' => $validated['idjenis_hewan'],
            'nama_ras'      => $this->formatNama($validated['nama_ras']),
        ]);

        return redirect()->route('admin.ras-hewan.index')
            ->with('success', 'Ras hewan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ras = DB::table($this->table)
            ->where($this->pk, $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$ras) {
            return redirect()->route('admin.ras-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        $jenisHewan = DB::table('jenis_hewan')
            ->whereNull('deleted_at')
            ->orderBy('nama_jenis_hewan')
            ->get();

        return view('admin.ras-hewan.edit', compact('ras', 'jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateRasHewan($request, $id);

        DB::table($this->table)
            ->where($this->pk, $id)
            ->update([
                'idjenis_hewan' => $validated['idjenis_hewan'],
                'nama_ras'      => $this->formatNama($validated['nama_ras']),
            ]);

        return redirect()->route('admin.ras-hewan.index')
            ->with('success', 'Ras hewan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table($this->table)
            ->where($this->pk, $id)
            ->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->id(),
            ]);

        return redirect()->route('admin.ras-hewan.index')
            ->with('success', 'Ras hewan berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::table($this->table)
            ->where($this->pk, $id)
            ->update([
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

        return redirect()->route('admin.ras-hewan.index', ['trash' => 1])
            ->with('success', 'Ras hewan berhasil direstore.');
    }

    protected function validateRasHewan(Request $request, $id = null)
    {
        $unique = $id
            ? 'unique:ras_hewan,nama_ras,' . $id . ',idras_hewan'
            : 'unique:ras_hewan,nama_ras';

        return $request->validate([
            'idjenis_hewan' => ['required', 'exists:jenis_hewan,idjenis_hewan'],
            'nama_ras' => ['required', 'string', 'min:3', 'max:255', $unique],
        ]);
    }

    protected function formatNama(string $nama): string
    {
        return trim(ucwords(strtolower($nama)));
    }
}
