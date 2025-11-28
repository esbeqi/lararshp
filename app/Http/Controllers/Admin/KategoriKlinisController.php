<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriKlinis;
use Exception;

class KategoriKlinisController extends Controller
{
    // INDEX
    public function index()
    {
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.kategori-klinis.index', compact('kategoriKlinis'));
    }

    // CREATE
    public function create()
    {
        return view('admin.kategori-klinis.create');
    }

    // STORE
    public function store(Request $request)
    {
        $validatedData = $this->validateKategoriKlinis($request);
        $this->createKategoriKlinis($validatedData);

        return redirect()->route('admin.kategori-klinis.index')
                         ->with('success', 'Kategori klinis berhasil ditambahkan.');
    }

    // EDIT
    public function edit($id)
    {
        $kategoriKlinis = KategoriKlinis::findOrFail($id);
        return view('admin.kategori-klinis.edit', compact('kategoriKlinis'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $validatedData = $this->validateKategoriKlinis($request, $id);

        $kategoriKlinis = KategoriKlinis::findOrFail($id);
        $kategoriKlinis->update([
            'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($validatedData['nama_kategori_klinis']),
        ]);

        return redirect()->route('admin.kategori-klinis.index')
                         ->with('success', 'Kategori klinis berhasil diperbarui.');
    }

    // DELETE
    public function destroy($id)
    {
        try {
            KategoriKlinis::destroy($id);

            return redirect()->route('admin.kategori-klinis.index')
                             ->with('success', 'Kategori klinis berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.kategori-klinis.index')
                             ->with('error', 'Gagal menghapus kategori klinis.');
        }
    }

    // VALIDASI
    protected function validateKategoriKlinis(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis'
            : 'unique:kategori_klinis,nama_kategori_klinis';

        return $request->validate([
            'nama_kategori_klinis' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule,
            ],
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.string'   => 'Nama kategori klinis harus berupa teks.',
            'nama_kategori_klinis.max'      => 'Nama kategori klinis maksimal 255 karakter.',
            'nama_kategori_klinis.min'      => 'Nama kategori klinis minimal 3 karakter.',
            'nama_kategori_klinis.unique'   => 'Nama kategori klinis sudah ada.',
        ]);
    }

    // CREATE DATA
    protected function createKategoriKlinis(array $data)
    {
        try {
            return KategoriKlinis::create([
                'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($data['nama_kategori_klinis']),
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data kategori klinis: ' . $e->getMessage());
        }
    }

    // FORMAT NAMA
    protected function formatNamaKategoriKlinis($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}