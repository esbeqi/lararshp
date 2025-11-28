<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PemilikControllerR extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = DB::table('pemilik as pm')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select('pm.*', 'u.nama as nama_user', 'u.email as email_user');

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('u.nama', 'like', "%{$q}%")
                    ->orWhere('u.email', 'like', "%{$q}%")
                    ->orWhere('pm.no_wa', 'like', "%{$q}%")
                    ->orWhere('pm.alamat', 'like', "%{$q}%");
            });
        }

        $pemilik = $query->orderBy('pm.idpemilik', 'desc')->paginate(15)->withQueryString();

        return view('resepsionis.pemilik.index', compact('pemilik', 'q'));
    }

    public function create()
    {
        return view('resepsionis.pemilik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|max:200|unique:user,email',
            'no_wa'  => 'nullable|string|max:45',
            'alamat' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Email sudah digunakan. Periksa kembali.',
        ]);

        DB::beginTransaction();
        try {
            // buat user
            $userId = DB::table('user')->insertGetId([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
                // password default 'password' (bcrypt) — bisa diubah
                'password' => Hash::make('password'),
            ]);

            // buat pemilik
            DB::table('pemilik')->insert([
                'no_wa'  => $validated['no_wa'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'iduser' => $userId,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Pemilik berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Gagal menambahkan pemilik: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pemilik = DB::table('pemilik as pm')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->select('pm.*', 'u.nama as nama_user', 'u.email as email_user')
            ->where('pm.idpemilik', $id)
            ->first();

        if (! $pemilik) {
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Data pemilik tidak ditemukan.');
        }

        return view('resepsionis.pemilik.edit', compact('pemilik'));
    }

    public function update(Request $request, $id)
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
        if (! $pemilik) {
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Data pemilik tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|max:200|unique:user,email,' . $pemilik->iduser . ',iduser',
            'no_wa'  => 'nullable|string|max:45',
            'alamat' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
        ]);

        DB::beginTransaction();
        try {
            // update user
            DB::table('user')->where('iduser', $pemilik->iduser)->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
            ]);

            // update pemilik
            DB::table('pemilik')->where('idpemilik', $id)->update([
                'no_wa'  => $validated['no_wa'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Data pemilik berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Gagal memperbarui pemilik: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
        if (! $pemilik) {
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Data pemilik tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            // hanya hapus record pemilik. Jangan otomatis hapus user (agar aman).
            DB::table('pemilik')->where('idpemilik', $id)->delete();

            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Pemilik berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Gagal menghapus pemilik: ' . $e->getMessage());
        }
    }
}
