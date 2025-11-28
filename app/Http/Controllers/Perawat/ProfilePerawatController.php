<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfilePerawatController extends Controller
{
    /**
     * Tampilkan profile perawat (table + edit form)
     */
    public function show()
    {
        $userId = auth()->id();

        // ambil data user + perawat (left join to be safe)
        $profile = DB::table('perawat as pr')
            ->leftJoin('user as u', 'pr.id_user', '=', 'u.iduser')
            ->where('pr.id_user', $userId)
            ->select(
                'pr.id_perawat',
                'pr.alamat',
                'pr.no_hp',
                'pr.jenis_kelamin',
                'pr.pendidikan',
                'pr.id_user',
                'u.nama',
                'u.email'
            )
            ->first();

        // jika belum ada record perawat buatkan default object (bukan insert)
        if (! $profile) {
            // ambil user basic
            $u = DB::table('user')->where('iduser', $userId)->select('iduser as id_user','nama','email')->first();
            $profile = (object) [
                'id_perawat' => null,
                'alamat' => null,
                'no_hp' => null,
                'jenis_kelamin' => null,
                'pendidikan' => null,
                'id_user' => $u->id_user ?? $userId,
                'nama' => $u->nama ?? null,
                'email' => $u->email ?? null,
            ];
        }

        return view('perawat.profil.show', compact('profile'));
    }

    /**
     * Update profil perawat (user.name optional + perawat fields)
     */
    public function update(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:45',
            // jenis_kelamin must be single char 'L' or 'P' in this implementation
            'jenis_kelamin' => 'nullable|in:L,P',
            'pendidikan' => 'nullable|string|max:100',
        ], [
            'jenis_kelamin.in' => 'Pilih jenis kelamin yang valid (L = Pria, P = Wanita).'
        ]);

        try {
            // update user table (nama + optionally email)
            DB::table('user')
                ->where('iduser', $userId)
                ->update([
                    'nama' => $validated['nama'],
                    'email' => $validated['email'] ?? null,
                ]);

            // cek apakah row perawat sudah ada
            $exists = DB::table('perawat')->where('id_user', $userId)->exists();

            if ($exists) {
                DB::table('perawat')
                    ->where('id_user', $userId)
                    ->update([
                        'alamat' => $validated['alamat'] ?? null,
                        'no_hp' => $validated['no_hp'] ?? null,
                        'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                        'pendidikan' => $validated['pendidikan'] ?? null,
                    ]);
            } else {
                // insert baru
                DB::table('perawat')->insert([
                    'alamat' => $validated['alamat'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                    'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    'pendidikan' => $validated['pendidikan'] ?? null,
                    'id_user' => $userId,
                ]);
            }

            return back()->with('success', 'Profil berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
