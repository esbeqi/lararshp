<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    protected string $table = 'kategori';
    protected string $pk = 'idkategori';

    public function index(Request $request)
    {
        $isTrash = $request->query('trash');

        $kategori = DB::table($this->table)
            ->select($this->pk, 'nama_kategori', 'deleted_at')
            ->when(!$isTrash, fn ($q) => $q->whereNull('deleted_at'))
            ->when($isTrash, fn ($q) => $q->whereNotNull('deleted_at'))
            ->orderBy($this->pk)
            ->get();

        return view('admin.kategori.index', compact('kategori', 'isTrash'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateKategori($request);

        DB::table($this->table)->insert([
            'nama_kategori' => $this->formatNama($validated['nama_kategori']),
        ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = DB::table($this->table)
            ->where($this->pk, $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$kategori) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateKategori($request, $id);

        DB::table($this->table)
            ->where($this->pk, $id)
            ->update([
                'nama_kategori' => $this->formatNama($validated['nama_kategori']),
            ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table($this->table)
            ->where($this->pk, $id)
            ->update([
                'deleted_at' => now(),
                'deleted_by' => auth()->id(),
            ]);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    public function restore($id)
    {
        DB::table($this->table)
            ->where($this->pk, $id)
            ->update([
                'deleted_at' => null,
                'deleted_by' => null,
            ]);

        return redirect()->route('admin.kategori.index', ['trash' => 1])
            ->with('success', 'Kategori berhasil direstore.');
    }

    protected function validateKategori(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kategori,nama_kategori,' . $id . ',idkategori'
            : 'unique:kategori,nama_kategori';

        return $request->validate([
            'nama_kategori' => ['required', 'string', 'min:3', 'max:255', $uniqueRule],
        ]);
    }

    protected function formatNama(string $nama): string
    {
        return trim(ucwords(strtolower($nama)));
    }
}
