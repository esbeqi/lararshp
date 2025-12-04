<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfilePemilikController extends Controller
{
    /**
     * TAMPILKAN PROFIL PEMILIK
     */
    public function show()
    {
        $userId = auth()->id();

        $profile = DB::table('pemilik as pm')
            ->leftJoin('user as u', 'pm.iduser', '=', 'u.iduser')
            ->where('pm.iduser', $userId)
            ->select(
                'pm.idpemilik',
                'pm.alamat',
                'pm.no_wa',
                'pm.iduser',
                'u.nama',
                'u.email'
            )
            ->first();

        // Jika belum punya row di tabel pemilik, buat objek kosong
        if (! $profile) {
            $u = DB::table('user')->where('iduser', $userId)->first();

            $profile = (object)[
                'idpemilik' => null,
                'alamat' => null,
                'no_wa' => null,
                'iduser' => $userId,
                'nama' => $u->nama ?? null,
                'email' => $u->email ?? null,
            ];
        }

        return view('pemilik.profil.show', compact('profile'));
    }

    /**
     * UPDATE PROFIL PEMILIK
     */
    public function update(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_wa'  => 'nullable|string|max:50',
        ]);

        try {

            // update tabel user
            DB::table('user')
                ->where('iduser', $userId)
                ->update([
                    'nama'  => $validated['nama'],
                    'email' => $validated['email'] ?? null,
                ]);

            // cek apakah pemilik sudah punya row atau belum
            $exists = DB::table('pemilik')
                ->where('iduser', $userId)
                ->exists();

            if ($exists) {
                // update baris yang sudah ada
                DB::table('pemilik')
                    ->where('iduser', $userId)
                    ->update([
                        'alamat' => $validated['alamat'] ?? null,
                        'no_wa'  => $validated['no_wa'] ?? null,
                    ]);
            } else {
                // insert baru
                DB::table('pemilik')->insert([
                    'iduser' => $userId,
                    'alamat' => $validated['alamat'] ?? null,
                    'no_wa'  => $validated['no_wa'] ?? null,
                ]);
            }

            return back()->with('success', 'Profil berhasil diperbarui.');

        } catch (Exception $e) {
            return back()->with('error', 'Gagal update profil: '.$e->getMessage());
        }
    }
}
