<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    protected string $table = 'user';
    protected string $pk = 'iduser';

    public function index()
    {
        $users = DB::table($this->table)
            ->select($this->pk, 'nama', 'email')
            ->orderBy($this->pk)
            ->get();

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateUser($request);

        try {
            DB::table($this->table)->insert([
                'nama' => $this->formatNama($validated['nama']),
                'email' => strtolower($validated['email']),
                'password' => Hash::make($validated['password']),
                // 'created_at' => now(), // aktifkan bila tabel punya timestamps
            ]);

            return redirect()->route('admin.user.index')
                             ->with('success', 'User berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.user.create')
                             ->withInput()
                             ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = DB::table($this->table)
            ->where($this->pk, $id)
            ->first();

        if (! $user) {
            return redirect()->route('admin.user.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateUser($request, $id);

        try {
            $update = [
                'nama' => $this->formatNama($validated['nama']),
                'email' => strtolower($validated['email']),
            ];

            // jika password diisi saat edit, update password juga
            if (! empty($validated['password'])) {
                $update['password'] = Hash::make($validated['password']);
            }

            // 'updated_at' => now(), // aktifkan bila tabel punya timestamps

            DB::table($this->table)
                ->where($this->pk, $id)
                ->update($update);

            return redirect()->route('admin.user.index')
                             ->with('success', 'User berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->route('admin.user.edit', $id)
                             ->withInput()
                             ->with('error', 'Gagal mengubah user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->delete();

            return redirect()->route('admin.user.index')
                             ->with('success', 'User berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.user.index')
                             ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    protected function validateUser(Request $request, $id = null)
    {
        // unique rule mengacu ke table `user` dan kolom email; sesuaikan pk bila perlu
        $uniqueEmail = $id
            ? 'unique:user,email,' . $id . ',iduser'
            : 'unique:user,email';

        $passwordRule = $id ? 'nullable|min:6' : 'required|min:6';

        return $request->validate([
            'nama' => 'required|string|min:3|max:255',
            'email' => ['required','email',$uniqueEmail],
            'password' => $passwordRule,
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);
    }

    protected function formatNama($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}