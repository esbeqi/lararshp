<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

class PetController extends Controller
{
    protected string $table = 'pet';
    protected string $pk = 'idpet';

    public function index()
    {
        // Pilih kolom dasar
        $select = [
            'p.' . $this->pk,
            'p.nama',
            'p.jenis_kelamin',
            'p.tanggal_lahir',
            'p.warna_tanda',
            'p.idpemilik',
            'p.idras_hewan',
            'pemilik.idpemilik as pk_pemilik',
            'ras_hewan.nama_ras as nama_ras',
        ];

        // Jika tabel 'user' ada dan kolom 'nama' ada, ambil nama pemilik dari 'user'
        $useUserTable = Schema::hasTable('user') && Schema::hasColumn('user', 'nama') && Schema::hasColumn('pemilik', 'iduser');

        if ($useUserTable) {
            $select[] = 'user.nama as nama_pemilik';
        } else {
            // fallback: ambil dari pemilik.nama / pemilik.nama_pemilik jika tersedia
            if (Schema::hasColumn('pemilik', 'nama')) {
                $select[] = 'pemilik.nama as nama_pemilik';
            } elseif (Schema::hasColumn('pemilik', 'nama_pemilik')) {
                $select[] = 'pemilik.nama_pemilik as nama_pemilik';
            } else {
                // agar query valid walau tidak ada kolom nama
                $select[] = DB::raw("'-' as nama_pemilik");
            }
        }

        $query = DB::table($this->table . ' as p')
            ->select($select)
            ->leftJoin('pemilik', 'p.idpemilik', '=', 'pemilik.idpemilik')
            ->leftJoin('ras_hewan', 'p.idras_hewan', '=', 'ras_hewan.idras_hewan');

        if ($useUserTable) {
            $query->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser');
        }

        $pets = $query->orderBy('p.' . $this->pk)->get();

        return view('admin.pet.index', compact('pets'));
    }

    public function create()
    {
        // Ambil list pemilik (gabungkan nama dari tabel user jika ada)
        $pemilikQuery = DB::table('pemilik')
            ->select('pemilik.idpemilik');

        // jika tabel user ada, join ke user untuk ambil nama
        if (Schema::hasTable('user') && Schema::hasColumn('user', 'nama') && Schema::hasColumn('pemilik', 'iduser')) {
            $pemilikQuery->addSelect('user.nama as nama_pemilik')
                         ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser');
        } else {
            // fallback: ambil nama dari kolom di pemilik bila ada
            if (Schema::hasColumn('pemilik', 'nama')) {
                $pemilikQuery->addSelect('pemilik.nama as nama_pemilik');
            } elseif (Schema::hasColumn('pemilik', 'nama_pemilik')) {
                $pemilikQuery->addSelect('pemilik.nama_pemilik as nama_pemilik');
            } else {
                $pemilikQuery->addSelect(DB::raw("CONCAT('Pemilik #', pemilik.idpemilik) as nama_pemilik"));
            }
        }

        $pemilik = $pemilikQuery->orderBy('nama_pemilik')->get();

        $rasHewan = DB::table('ras_hewan')
            ->select('idras_hewan', 'nama_ras')
            ->orderBy('nama_ras')
            ->get();

        return view('admin.pet.create', compact('pemilik', 'rasHewan'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatePet($request);

        try {
            $this->createPet($validated);

            return redirect()->route('admin.pet.index')
                             ->with('success', 'Data hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('admin.pet.create')
                             ->withInput()
                             ->with('error', 'Gagal menambahkan data hewan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pet = DB::table($this->table)
            ->where($this->pk, $id)
            ->first();

        if (! $pet) {
            return redirect()->route('admin.pet.index')
                             ->with('error', 'Data tidak ditemukan.');
        }

        // Ambil opsi pemilik sama seperti di create()
        $pemilikQuery = DB::table('pemilik')
            ->select('pemilik.idpemilik');

        if (Schema::hasTable('user') && Schema::hasColumn('user', 'nama') && Schema::hasColumn('pemilik', 'iduser')) {
            $pemilikQuery->addSelect('user.nama as nama_pemilik')
                         ->leftJoin('user', 'pemilik.iduser', '=', 'user.iduser');
        } else {
            if (Schema::hasColumn('pemilik', 'nama')) {
                $pemilikQuery->addSelect('pemilik.nama as nama_pemilik');
            } elseif (Schema::hasColumn('pemilik', 'nama_pemilik')) {
                $pemilikQuery->addSelect('pemilik.nama_pemilik as nama_pemilik');
            } else {
                $pemilikQuery->addSelect(DB::raw("CONCAT('Pemilik #', pemilik.idpemilik) as nama_pemilik"));
            }
        }

        $pemilik = $pemilikQuery->orderBy('nama_pemilik')->get();

        $rasHewan = DB::table('ras_hewan')
            ->select('idras_hewan', 'nama_ras')
            ->orderBy('nama_ras')
            ->get();

        return view('admin.pet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validatePet($request, $id);

        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->update($this->prepareUpdate($validated));

            return redirect()->route('admin.pet.index')
                             ->with('success', 'Data hewan berhasil diubah.');
        } catch (Exception $e) {
            return redirect()->route('admin.pet.edit', $id)
                             ->withInput()
                             ->with('error', 'Gagal mengubah data hewan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::table($this->table)
                ->where($this->pk, $id)
                ->delete();

            return redirect()->route('admin.pet.index')
                             ->with('success', 'Data hewan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.pet.index')
                             ->with('error', 'Gagal menghapus data hewan: ' . $e->getMessage());
        }
    }

    protected function validatePet(Request $request, $id = null)
    {
        return $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'warna_tanda' => ['nullable', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:Jantan,Betina'],
            'idpemilik' => ['required', 'exists:pemilik,idpemilik'],
            'idras_hewan' => ['required', 'exists:ras_hewan,idras_hewan'],
        ], [
            'nama.required' => 'Nama hewan wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin harus Jantan atau Betina.',
            'idpemilik.required' => 'Pemilik wajib dipilih.',
            'idras_hewan.required' => 'Ras hewan wajib dipilih.',
        ]);
    }

    protected function createPet(array $data)
    {
        try {
            return DB::table($this->table)->insert([
                'nama' => $this->formatNamaPet($data['nama']),
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'warna_tanda' => $data['warna_tanda'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'idpemilik' => $data['idpemilik'],
                'idras_hewan' => $data['idras_hewan'],
                // 'created_at' => now(), // aktifkan jika tabel punya timestamps
            ]);
        } catch (Exception $e) {
            throw new \Exception('Gagal menyimpan data hewan: ' . $e->getMessage());
        }
    }

    protected function prepareUpdate(array $data): array
    {
        return [
            'nama' => $this->formatNamaPet($data['nama']),
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'warna_tanda' => $data['warna_tanda'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'],
            'idpemilik' => $data['idpemilik'],
            'idras_hewan' => $data['idras_hewan'],
            // 'updated_at' => now(),
        ];
    }

    protected function formatNamaPet($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}