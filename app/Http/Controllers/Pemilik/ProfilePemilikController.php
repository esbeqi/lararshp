<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfilePemilikController extends Controller
{
    public function show()
    {
        $userId = auth()->id();

        $profile = DB::table('pemilik as pm')
            ->leftJoin('user as u','pm.iduser','=','u.iduser')
            ->where('pm.iduser', $userId)
            ->select('pm.idpemilik','pm.alamat','pm.no_hp','pm.iduser','u.nama','u.email')
            ->first();

        if (! $profile) {
            $u = DB::table('user')->where('iduser', $userId)->select('iduser as iduser','nama','email')->first();
            $profile = (object)[
                'idpemilik' => null,
                'alamat' => null,
                'no_hp' => null,
                'iduser' => $userId,
                'nama' => $u->nama ?? null,
                'email' => $u->email ?? null,
            ];
        }

        return view('pemilik.profil.show', compact('profile'));
    }

    public function update(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:45'
        ]);

        try {
            DB::table('user')->where('iduser', $userId)->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'] ?? null,
            ]);

            $exists = DB::table('pemilik')->where('iduser', $userId)->exists();
            if ($exists) {
                DB::table('pemilik')->where('iduser', $userId)->update([
                    'alamat' => $validated['alamat'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                ]);
            } else {
                DB::table('pemilik')->insert([
                    'alamat' => $validated['alamat'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                    'iduser' => $userId,
                ]);
            }

            return back()->with('success','Profil pemilik diperbarui.');
        } catch (Exception $e) {
            return back()->withInput()->with('error','Gagal update profil: '.$e->getMessage());
        }
    }
}
