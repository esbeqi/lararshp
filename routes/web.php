<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Site\SiteController;

//admin
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\DashboardAdminController;

//dokter
use App\Http\Controllers\Dokter\DashboardController;
use App\Http\Controllers\Dokter\PasienController;
use App\Http\Controllers\Dokter\RekamMedisController;
use App\Http\Controllers\Dokter\DetailRekamController;
use App\Http\Controllers\Dokter\ProfileController;

//perawat
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Perawat\PasienPerawatController;
use App\Http\Controllers\Perawat\RekamMedisPerawatController;
use App\Http\Controllers\Perawat\ProfilePerawatController;

//resepsionis
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;
use App\Http\Controllers\Resepsionis\PemilikControllerR;
use App\Http\Controllers\Resepsionis\PetControllerR;
use App\Http\Controllers\Resepsionis\TemuDokterController;

//pemilik
use App\Http\Controllers\Pemilik\DashboardPemilikController;
use App\Http\Controllers\Pemilik\PetPemilikController;
use App\Http\Controllers\Pemilik\RekamPemilikController;
use App\Http\Controllers\Pemilik\ProfilePemilikController;


Route::get('/cek-koneksi', function () {
    try {
        DB::connection()->getPdo();
        return "Koneksi ke database berhasil: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Koneksi gagal: " . $e->getMessage();
    }
});

// halaman utama
Route::get('/', [SiteController::class, 'home'])->name('site.home');
Route::get('/layanan', [SiteController::class, 'layanan'])->name('layanan');
Route::get('/kontak', [SiteController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [SiteController::class, 'submitKontak'])->name('kontak.submit');
Route::get('/struktur', [SiteController::class, 'struktur'])->name('struktur');

// Authentication routes
Auth::routes(); // <-- ini yang buat login/register bawaan Laravel

// admin
Route::middleware('isAdministrator')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::patch('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Role (Tidak pake)
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');

    // Role User (Manajemen Role)
    Route::get('/role-user', [RoleUserController::class, 'index'])->name('role-user.index');
    Route::get('/role-user/create', [RoleUserController::class, 'create'])->name('role-user.create');
    Route::post('/role-user/store', [RoleUserController::class, 'store'])->name('role-user.store');
    Route::get('/role-user/{id}/edit', [RoleUserController::class, 'edit'])->name('role-user.edit');
    Route::put('/role-user/{id}', [RoleUserController::class, 'update'])->name('role-user.update');
    Route::patch('/role-user/{id}', [RoleUserController::class, 'update']);
    Route::delete('/role-user/{id}', [RoleUserController::class, 'destroy'])->name('role-user.destroy');

    // Jenis Hewan
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
    Route::get('/jenis-hewan/create', [JenisHewanController::class, 'create'])->name('jenis-hewan.create');
    Route::post('/jenis-hewan/store', [JenisHewanController::class, 'store'])->name('jenis-hewan.store');
    Route::get('/jenis-hewan/{id}/edit', [JenisHewanController::class, 'edit'])->name('jenis-hewan.edit');
    Route::put('/jenis-hewan/{id}', [JenisHewanController::class, 'update'])->name('jenis-hewan.update');
    Route::patch('/jenis-hewan/{id}', [JenisHewanController::class, 'update']);
    Route::delete('/jenis-hewan/{id}', [JenisHewanController::class, 'destroy'])->name('jenis-hewan.destroy');

    // Ras Hewan
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('ras-hewan.index');
    Route::get('/ras-hewan/create', [RasHewanController::class, 'create'])->name('ras-hewan.create');
    Route::post('/ras-hewan/store', [RasHewanController::class, 'store'])->name('ras-hewan.store');
    Route::get('/ras-hewan/{id}/edit', [RasHewanController::class, 'edit'])->name('ras-hewan.edit');
    Route::put('/ras-hewan/{id}', [RasHewanController::class, 'update'])->name('ras-hewan.update');
    Route::patch('/ras-hewan/{id}', [RasHewanController::class, 'update']);
    Route::delete('/ras-hewan/{id}', [RasHewanController::class, 'destroy'])->name('ras-hewan.destroy');

    // Pemilik
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik.index');
    Route::get('/pemilik/create', [PemilikController::class, 'create'])->name('pemilik.create');
    Route::post('/pemilik/store', [PemilikController::class, 'store'])->name('pemilik.store');
    Route::get('/pemilik/{id}/edit', [PemilikController::class, 'edit'])->name('pemilik.edit');
    Route::put('/pemilik/{id}', [PemilikController::class, 'update'])->name('pemilik.update');
    Route::patch('/pemilik/{id}', [PemilikController::class, 'update']);
    Route::delete('/pemilik/{id}', [PemilikController::class, 'destroy'])->name('pemilik.destroy');

    // Pet
    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('/pet/create', [PetController::class, 'create'])->name('pet.create');
    Route::post('/pet/store', [PetController::class, 'store'])->name('pet.store');
    Route::get('/pet/{id}/edit', [PetController::class, 'edit'])->name('pet.edit');
    Route::put('/pet/{id}', [PetController::class, 'update'])->name('pet.update');
    Route::patch('/pet/{id}', [PetController::class, 'update']);
    Route::delete('/pet/{id}', [PetController::class, 'destroy'])->name('pet.destroy');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::patch('/kategori/{id}', [KategoriController::class, 'update']); // optional patch
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Kategori Klinis
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('kategori-klinis.index');
    Route::get('/kategori-klinis/create', [KategoriKlinisController::class, 'create'])->name('kategori-klinis.create');
    Route::post('/kategori-klinis/store', [KategoriKlinisController::class, 'store'])->name('kategori-klinis.store');
    Route::get('/kategori-klinis/{id}/edit', [KategoriKlinisController::class, 'edit'])->name('kategori-klinis.edit');
    Route::put('/kategori-klinis/{id}', [KategoriKlinisController::class, 'update'])->name('kategori-klinis.update');
    Route::patch('/kategori-klinis/{id}', [KategoriKlinisController::class, 'update']);
    Route::delete('/kategori-klinis/{id}', [KategoriKlinisController::class, 'destroy'])->name('kategori-klinis.destroy');

    // Kode Tindakan Terapi
    Route::get('/kode-tindakan-terapi', [KodeTindakanTerapiController::class, 'index'])->name('kode-tindakan-terapi.index');
    Route::get('/kode-tindakan-terapi/create', [KodeTindakanTerapiController::class, 'create'])->name('kode-tindakan-terapi.create');
    Route::post('/kode-tindakan-terapi/store', [KodeTindakanTerapiController::class, 'store'])->name('kode-tindakan-terapi.store');
    Route::get('/kode-tindakan-terapi/{id}/edit', [KodeTindakanTerapiController::class, 'edit'])->name('kode-tindakan-terapi.edit');
    Route::put('/kode-tindakan-terapi/{id}', [KodeTindakanTerapiController::class, 'update'])->name('kode-tindakan-terapi.update');
    Route::patch('/kode-tindakan-terapi/{id}', [KodeTindakanTerapiController::class, 'update']);
    Route::delete('/kode-tindakan-terapi/{id}', [KodeTindakanTerapiController::class, 'destroy'])->name('kode-tindakan-terapi.destroy');

});

//dokter
Route::middleware(['auth','isDokter'])->prefix('dokter')->name('dokter.')->group(function(){
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pasien (temu_dokter)
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/{idpet}', [PasienController::class, 'show'])->name('pasien.show');

    // Rekam Medis
    Route::get('/rekam-medis', [RekamMedisController::class, 'index'])->name('rekam.index');
    Route::get('/rekam-medis/{idrekam}', [RekamMedisController::class, 'show'])->name('rekam.show');

    // CRUD Detail Rekam Medis
    Route::post('/rekam-medis/{idrekam}/detail', [DetailRekamController::class, 'store'])->name('detail.store');
    Route::get('/rekam-medis/{idrekam}/detail/{iddetail}/edit', [DetailRekamController::class, 'edit'])->name('detail.edit');
    Route::put('/rekam-medis/{idrekam}/detail/{iddetail}', [DetailRekamController::class, 'update'])->name('detail.update');
    Route::delete('/rekam-medis/{idrekam}/detail/{iddetail}', [DetailRekamController::class, 'destroy'])->name('detail.destroy');

    // Profile Dokter
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });


    // PERAWAT
    Route::middleware(['auth', 'isPerawat'])
        ->prefix('perawat')
        ->name('perawat.')
        ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardPerawatController::class, 'index'])
            ->name('dashboard');

        // PASIEN
        Route::get('/pasien', [PasienPerawatController::class, 'index'])
            ->name('pasien.index');

        // List RM (header)
        Route::get('/rekam-medis', [RekamMedisPerawatController::class, 'index'])
            ->name('rekam-medis.index');

        // Create RM (form & store)
        Route::get('/rekam-medis/create', [RekamMedisPerawatController::class, 'create'])
            ->name('rekam-medis.create');
        Route::post('/rekam-medis', [RekamMedisPerawatController::class, 'store'])
            ->name('rekam-medis.store');

        // Edit header RM
        Route::get('/rekam-medis/{id}/edit', [RekamMedisPerawatController::class, 'edit'])
            ->name('rekam-medis.edit');
        Route::post('/rekam-medis/{id}/update', [RekamMedisPerawatController::class, 'update'])
            ->name('rekam-medis.update');

        // Delete header RM
        Route::delete('/rekam-medis/{id}/delete', [RekamMedisPerawatController::class, 'destroy'])
            ->name('rekam-medis.destroy');

        // Detail page (header + tindakan)
        Route::get('/rekam-medis/{id}/detail', [RekamMedisPerawatController::class, 'detail'])
            ->name('rekam-medis.detail');

        // Tambah tindakan (dari halaman detail rekam medis)
        Route::post('/rekam-medis/{id}/tindakan', [RekamMedisPerawatController::class, 'storeTindakan'])
            ->name('rekam-medis.store-tindakan');

        // Edit tindakan (form)
        Route::get('/rekam-medis/tindakan/{iddetail}/edit', [RekamMedisPerawatController::class, 'editTindakan'])
            ->name('rekam-medis.edit-detail');

        // Update tindakan (submit edit)
        Route::post('/rekam-medis/tindakan/{iddetail}/update', [RekamMedisPerawatController::class, 'updateTindakan'])
            ->name('rekam-medis.update-detail');

        // Delete tindakan
        Route::delete('/rekam-medis/tindakan/{iddetail}', [RekamMedisPerawatController::class, 'deleteTindakan'])
            ->name('rekam-medis.delete-tindakan');

        // Daftar semua detail_rekam_medis (gabungan header + kode + kategori)
        Route::get('/rekam-medis/details', [RekamMedisPerawatController::class, 'detailsIndex'])
            ->name('rekam-medis.details.index');

        // Tambah tindakan dari halaman details (standalone form)
        Route::post('/rekam-medis/details/create', [RekamMedisPerawatController::class, 'storeTindakanStandalone'])
            ->name('rekam-medis.details.store');

        // PROFIL PERAWAT
        Route::get('/profil', [ProfilePerawatController::class, 'show'])
            ->name('profil.show');
        Route::post('/profil', [ProfilePerawatController::class, 'update'])
            ->name('profil.update');
    });




    // resepsionis
    Route::middleware(['auth', 'isResepsionis'])->prefix('resepsionis')->name('resepsionis.')->group(function () {
            
        // Dashboard
        Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])
            ->name('dashboard');

        // CRUD Pemilik
        Route::resource('pemilik', PemilikControllerR::class);

        // CRUD Pet
        Route::resource('pet', PetControllerR::class);

        // AJAX ambil ras berdasarkan jenis hewan (pet create/edit)
        Route::get('/pet/ras-by-jenis/{idjenis}', [PetControllerR::class, 'rasByJenis'])
            ->name('pet.ras-by-jenis');

        // CRUD Antrian Temu Dokter
        Route::resource('temu-dokter', TemuDokterController::class);

        // AJAX ambil pet berdasarkan pemilik
        Route::get('/pet-by-pemilik/{idpemilik}', [TemuDokterController::class, 'petByPemilik'])
            ->name('pet-by-pemilik');
});


    // PEMILIK
    Route::middleware(['auth','isPemilik'])->prefix('pemilik')->name('pemilik.')->group(function(){
        // dashboard
        Route::get('/dashboard', [DashboardPemilikController::class, 'index'])
            ->name('dashboard');

        // profile pemilik
        Route::get('/profil', [ProfilePemilikController::class, 'show'])
            ->name('profil.show');
        Route::post('/profil', [ProfilePemilikController::class, 'update'])
            ->name('profil.update');

        // daftar pet milik pemilik
        Route::get('/pet', [PetPemilikController::class, 'index'])
            ->name('pet.index');
        Route::get('/pet/{idpet}', [PetPemilikController::class, 'show'])
            ->name('pet.show');

        // lihat rekam medis pet (read-only)
        Route::get('/pet/{idpet}/rekam-medis', [RekamPemilikController::class, 'index'])
            ->name('pet.rekam.index');
        Route::get('/rekam-medis/{idrekam}', [RekamPemilikController::class, 'show'])
            ->name('rekam.show');
    });