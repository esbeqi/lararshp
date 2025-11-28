<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRole($request);
        $role = $this->createRole($validatedData);

        return redirect()->route('admin.role.index')
                         ->with('success', 'Role berhasil ditambahkan.');
    }

    protected function validateRole(Request $request, $id = null)
    {
        $uniqueRule = $id
            ? 'unique:role,nama_role,' . $id . ',idrole'
            : 'unique:role,nama_role';

        return $request->validate([
            'nama_role' => [
                'required',
                'string',
                'min:3',
                'max:100',
                $uniqueRule,
            ],
        ], [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.string'   => 'Nama role harus berupa teks.',
            'nama_role.min'      => 'Nama role minimal 3 karakter.',
            'nama_role.max'      => 'Nama role maksimal 100 karakter.',
            'nama_role.unique'   => 'Nama role sudah ada.',
        ]);
    }

    protected function createRole(array $data)
    {
        try {
            return Role::create([
                'nama_role' => $this->formatNamaRole($data['nama_role']),
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data role: ' . $e->getMessage());
        }
    }

    protected function formatNamaRole($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}