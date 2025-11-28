<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KodeTindakanTerapi;
use App\Models\Kategori;
use App\Models\KategoriKlinis;
use Exception;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        $tindakanTerapi = KodeTindakanTerapi::with(['kategori', 'kategoriKlinis'])->get();
        return view('admin.kode-tindakan-terapi.index', compact('tindakanTerapi'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();
        return view('admin.kode-tindakan-terapi.create', compact('kategori', 'kategoriKlinis'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateKodeTindakanTerapi($request);
        $this->createKodeTindakanTerapi($validatedData);

        return redirect()->route('admin.kode-tindakan-terapi.index')
                         ->with('success', 'Kode tindakan terapi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tindakan = KodeTindakanTerapi::findOrFail($id);
        $kategori = Kategori::all();
        $kategoriKlinis = KategoriKlinis::all();

        return view('admin.kode-tindakan-terapi.edit', compact('tindakan', 'kategori', 'kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateKodeTindakanTerapi($request, $id);

        $tindakan = KodeTindakanTerapi::findOrFail($id);
        $tindakan->update([
            'kode' => strtoupper(trim($validatedData['kode'])),
            'deskripsi_tindakan_terapi' => ucfirst(trim($validatedData['deskripsi_tindakan_terapi'])),
            'idkategori' => $validatedData['idkategori'],
            'idkategori_klinis' => $validatedData['idkategori_klinis'],
        ]);

        return redirect()->route('admin.kode-tindakan-terapi.index')
                         ->with('success', 'Kode tindakan terapi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tindakan = KodeTindakanTerapi::findOrFail($id);
        $tindakan->delete();

        return redirect()->route('admin.kode-tindakan-terapi.index')
                         ->with('success', 'Kode tindakan terapi berhasil dihapus.');
    }

    protected function validateKodeTindakanTerapi(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan_terapi'
            : 'unique:kode_tindakan_terapi,kode';

        return $request->validate([
            'kode' => ['required', 'string', 'max:50', $uniqueRule],
            'deskripsi_tindakan_terapi' => ['required', 'string', 'min:3'],
            'idkategori' => ['required', 'exists:kategori,idkategori'],
            'idkategori_klinis' => ['required', 'exists:kategori_klinis,idkategori_klinis'],
        ], [
            'kode.required' => 'Kode wajib diisi.',
            'kode.unique' => 'Kode sudah digunakan.',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi tindakan terapi wajib diisi.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
        ]);
    }

    protected function createKodeTindakanTerapi(array $data)
    {
        try {
            return KodeTindakanTerapi::create([
                'kode' => strtoupper(trim($data['kode'])),
                'deskripsi_tindakan_terapi' => ucfirst(trim($data['deskripsi_tindakan_terapi'])),
                'idkategori' => $data['idkategori'],
                'idkategori_klinis' => $data['idkategori_klinis'],
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data tindakan terapi: ' . $e->getMessage());
        }
    }
}