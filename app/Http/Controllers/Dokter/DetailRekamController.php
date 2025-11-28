<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DetailRekamController extends Controller
{
    public function store(Request $request, $idrekam)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|integer',
            'detail' => 'nullable|string|max:1000',
        ]);

        try {
            DB::table('detail_rekam_medis')->insert([
                'idrekam_medis' => $idrekam,
                'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                'detail' => $validated['detail'] ?? null
            ]);
            return redirect()->route('dokter.rekam.show', $idrekam)->with('success','Tindakan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->route('dokter.rekam.show', $idrekam)->with('error','Gagal menambahkan tindakan: '.$e->getMessage());
        }
    }

    public function edit($idrekam, $iddetail)
    {
        $detail = DB::table('detail_rekam_medis')->where('iddetail_rekam_medis',$iddetail)->first();
        if(! $detail) {
            return redirect()->route('dokter.rekam.show', $idrekam)->with('error','Detail tidak ditemukan.');
        }
        $kodes = DB::table('kode_tindakan_terapi')->orderBy('kode')->get();
        return view('dokter.rekam.detail.edit', compact('detail','idrekam','kodes'));
    }

    public function update(Request $request, $idrekam, $iddetail)
    {
        $validated = $request->validate([
            'idkode_tindakan_terapi' => 'required|integer',
            'detail' => 'nullable|string|max:1000',
        ]);

        try {
            DB::table('detail_rekam_medis')->where('iddetail_rekam_medis',$iddetail)->update([
                'idkode_tindakan_terapi' => $validated['idkode_tindakan_terapi'],
                'detail' => $validated['detail'] ?? null
            ]);
            return redirect()->route('dokter.rekam.show', $idrekam)->with('success','Detail tindakan diperbarui.');
        } catch (Exception $e) {
            return redirect()->route('dokter.rekam.show', $idrekam)->with('error','Gagal mengupdate detail: '.$e->getMessage());
        }
    }

    public function destroy($idrekam, $iddetail)
    {
        try {
            DB::table('detail_rekam_medis')->where('iddetail_rekam_medis',$iddetail)->delete();
            return redirect()->route('dokter.rekam.show', $idrekam)->with('success','Detail tindakan dihapus.');
        } catch (Exception $e) {
            return redirect()->route('dokter.rekam.show', $idrekam)->with('error','Gagal menghapus detail: '.$e->getMessage());
        }
    }
}
