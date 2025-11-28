<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PemilikController extends Controller
{
    public function index()
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama as nama_user')
            ->orderBy('pemilik.idpemilik')
            ->get();

        return view('admin.pemilik.index', compact('pemilik'));
    }

    public function create()
    {
        $users = DB::table('user')
            ->select('iduser', 'nama')
            ->orderBy('nama')
            ->get();

        return view('admin.pemilik.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePemilik($request);

        try {
            $this->createPemilik($validatedData);

            return redirect()->route('admin.pemilik.index')
                             ->with('success', 'Data pemilik berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.pemilik.index')
                             ->with('error', 'Gagal menambahkan data pemilik: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pemilik = DB::table('pemilik')
            ->where('idpemilik', $id)
            ->first();

        if (! $pemilik) {
            return redirect()->route('admin.pemilik.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        $users = DB::table('user')
            ->select('iduser', 'nama')
            ->orderBy('nama')
            ->get();

        return view('admin.pemilik.edit', compact('pemilik', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validatePemilik($request, $id);

        try {
            DB::table('pemilik')
                ->where('idpemilik', $id)
                ->update([
                    'iduser' => $validatedData['iduser'],
                    'no_wa' => $this->formatNoWA($validatedData['no_wa']),
                    'alamat' => trim($validatedData['alamat']),
                ]);

            return redirect()->route('admin.pemilik.index')
                             ->with('success', 'Data pemilik berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->route('admin.pemilik.index')
                             ->with('error', 'Gagal mengubah data pemilik: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('pemilik')->where('idpemilik', $id)->delete();

            return redirect()->route('admin.pemilik.index')
                             ->with('success', 'Data pemilik berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.pemilik.index')
                             ->with('error', 'Gagal menghapus data pemilik: ' . $e->getMessage());
        }
    }

    protected function validatePemilik(Request $request, $id = null)
    {
        $uniqueNoWA = $id
            ? 'unique:pemilik,no_wa,' . $id . ',idpemilik'
            : 'unique:pemilik,no_wa';

        return $request->validate([
            'iduser' => ['required', 'exists:user,iduser'],
            'no_wa' => ['required', 'string', 'regex:/^[0-9+ ]{10,15}$/', $uniqueNoWA],
            'alamat' => ['required', 'string', 'min:5', 'max:255'],
        ], [
            'iduser.required' => 'User wajib dipilih.',
            'iduser.exists' => 'User tidak valid.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'no_wa.regex' => 'Format nomor WhatsApp tidak valid.',
            'no_wa.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.min' => 'Alamat minimal 5 karakter.',
        ]);
    }

    protected function createPemilik(array $data)
    {
        try {
            return DB::table('pemilik')->insert([
                'iduser' => $data['iduser'],
                'no_wa' => $this->formatNoWA($data['no_wa']),
                'alamat' => trim($data['alamat']),
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data pemilik: ' . $e->getMessage());
        }
    }

    protected function formatNoWA($no_wa)
    {
        $no_wa = preg_replace('/[^0-9]/', '', $no_wa);
        if (substr($no_wa, 0, 1) === '0') {
            $no_wa = '62' . substr($no_wa, 1);
        }
        return '+' . $no_wa;
    }
}