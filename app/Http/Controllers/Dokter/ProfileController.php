<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil dokter (tabel ringkas + form edit)
     */
    public function show()
    {
        $userId = auth()->id();

        $profile = DB::table('dokter as dr')
            ->leftJoin('user as u', 'dr.id_user', '=', 'u.iduser')
            ->where('dr.id_user', $userId)
            ->select(
                'dr.id_dokter',
                'dr.alamat',
                'dr.no_hp',
                'dr.bidang_dokter',
                'dr.jenis_kelamin',
                'dr.id_user',
                'u.nama',
                'u.email'
            )
            ->first();

        if (! $profile) {
            $u = DB::table('user')->where('iduser', $userId)->select('iduser as id_user','nama','email')->first();
            $profile = (object) [
                'id_dokter' => null,
                'alamat' => null,
                'no_hp' => null,
                'bidang_dokter' => null,
                'jenis_kelamin' => null,
                'id_user' => $u->id_user ?? $userId,
                'nama' => $u->nama ?? null,
                'email' => $u->email ?? null,
            ];
        }

        return view('dokter.profile.show', compact('profile'));
    }

    /**
     * Update profil dokter (user.name + dokter.*)
     */
    public function update(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:45',
            'bidang_dokter' => 'nullable|string|max:150',
            'jenis_kelamin' => 'nullable|in:L,P',
        ], [
            'jenis_kelamin.in' => 'Pilih jenis kelamin yang valid (L = Pria, P = Wanita).'
        ]);

        try {
            // Update user table
            DB::table('user')
                ->where('iduser', $userId)
                ->update([
                    'nama' => $validated['nama'],
                    'email' => $validated['email'] ?? null,
                ]);

            // Update or insert dokter row
            $exists = DB::table('dokter')->where('id_user', $userId)->exists();

            if ($exists) {
                DB::table('dokter')
                    ->where('id_user', $userId)
                    ->update([
                        'alamat' => $validated['alamat'] ?? null,
                        'no_hp' => $validated['no_hp'] ?? null,
                        'bidang_dokter' => $validated['bidang_dokter'] ?? null,
                        'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    ]);
            } else {
                DB::table('dokter')->insert([
                    'alamat' => $validated['alamat'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                    'bidang_dokter' => $validated['bidang_dokter'] ?? null,
                    'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                    'id_user' => $userId,
                ]);
            }

            return back()->with('success', 'Profil dokter berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}
