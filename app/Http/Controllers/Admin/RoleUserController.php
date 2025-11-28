<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RoleUserController extends Controller
{
    protected string $table = 'role_user';
    protected string $pk = 'idrole_user';

    public function index()
    {
        $roleUsers = DB::table($this->table . ' as ru')
            ->select(
                'ru.' . $this->pk,
                'ru.iduser',
                'ru.idrole',
                'ru.status',
                'u.nama as nama_user',
                'u.email as email_user',
                'r.nama_role'
            )
            ->leftJoin('user as u', 'ru.iduser', '=', 'u.iduser')
            ->leftJoin('role as r', 'ru.idrole', '=', 'r.idrole')
            ->orderBy('ru.' . $this->pk)
            ->get();

        return view('admin.role-user.index', compact('roleUsers'));
    }

    public function create()
    {
        $users = DB::table('user')->select('iduser', 'nama', 'email')->orderBy('nama')->get();
        $roles = DB::table('role')->select('idrole', 'nama_role')->orderBy('nama_role')->get();

        return view('admin.role-user.create', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRoleUser($request);

        try {
            // cek duplicate
            $exists = DB::table($this->table)
                ->where('iduser', $validated['iduser'])
                ->where('idrole', $validated['idrole'])
                ->first();

            if ($exists) {
                return redirect()->route('admin.role-user.create')
                                 ->withInput()
                                 ->with('error', 'Role tersebut sudah terdaftar untuk user ini.');
            }

            DB::table($this->table)->insert([
                'iduser' => $validated['iduser'],
                'idrole' => $validated['idrole'],
                'status' => $validated['status'] ?? 0,
                // 'created_at' => now(), // aktifkan jika tabel pakai timestamps
            ]);

            // jika role pemilik (contoh idrole == 2) buat record pemilik
            if ((int)$validated['idrole'] === 2) {
                // create pemilik only if belum ada
                $existPemilik = DB::table('pemilik')->where('iduser', $validated['iduser'])->first();
                if (! $existPemilik) {
                    DB::table('pemilik')->insert([
                        'iduser' => $validated['iduser'],
                        'nama_pemilik' => $request->input('nama_pemilik', 'Pemilik'),
                        'no_wa' => $request->input('no_wa', '-'),
                        'alamat' => $request->input('alamat', '-'),
                    ]);
                }
            }

            return redirect()->route('admin.role-user.index')
                             ->with('success', 'Role user berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.role-user.create')
                             ->withInput()
                             ->with('error', 'Gagal menambahkan role user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $ru = DB::table($this->table)
            ->where($this->pk, $id)
            ->first();

        if (! $ru) {
            return redirect()->route('admin.role-user.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        $users = DB::table('user')->select('iduser', 'nama', 'email')->orderBy('nama')->get();
        $roles = DB::table('role')->select('idrole', 'nama_role')->orderBy('nama_role')->get();

        return view('admin.role-user.edit', compact('ru', 'users', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validateRoleUser($request, $id);

        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->update([
                    'iduser' => $validated['iduser'],
                    'idrole' => $validated['idrole'],
                    'status' => $validated['status'] ?? 0,
                    // 'updated_at' => now(),
                ]);

            return redirect()->route('admin.role-user.index')
                             ->with('success', 'Role user berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->route('admin.role-user.edit', $id)
                             ->withInput()
                             ->with('error', 'Gagal mengubah role user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->delete();

            return redirect()->route('admin.role-user.index')
                             ->with('success', 'Data role user berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.role-user.index')
                             ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    protected function validateRoleUser(Request $request, $id = null)
    {
        $rules = [
            'iduser' => 'required|exists:user,iduser',
            'idrole' => 'required|exists:role,idrole',
            'status' => 'nullable|in:0,1',
        ];

        $messages = [
            'iduser.required' => 'User wajib dipilih.',
            'iduser.exists'   => 'User tidak valid.',
            'idrole.required' => 'Role wajib dipilih.',
            'idrole.exists'   => 'Role tidak valid.',
        ];

        return $request->validate($rules, $messages);
    }

    protected function formatNamaRole($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}