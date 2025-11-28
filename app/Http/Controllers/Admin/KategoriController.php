<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Exception;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('idkategori')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateKategori($request);

        try {
            $this->createKategori($validatedData);
            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $kategori = Kategori::where('idkategori', $id)->first();

        if (! $kategori) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateKategori($request, $id);

        try {
            Kategori::where('idkategori', $id)->update([
                'nama_kategori' => $this->formatNamaKategori($validatedData['nama_kategori']),
            ]);

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Kategori::where('idkategori', $id)->delete();

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.kategori.index')
                             ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    protected function validateKategori(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kategori,nama_kategori,' . $id . ',idkategori'
            : 'unique:kategori,nama_kategori';

        return $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule,
            ],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.string'   => 'Nama kategori harus berupa teks.',
            'nama_kategori.max'      => 'Nama kategori maksimal 255 karakter.',
            'nama_kategori.min'      => 'Nama kategori minimal 3 karakter.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);
    }

    protected function createKategori(array $data)
    {
        return Kategori::create([
            'nama_kategori' => $this->formatNamaKategori($data['nama_kategori']),
        ]);
    }

    protected function formatNamaKategori($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}