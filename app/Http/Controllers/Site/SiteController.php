<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    // halaman home
    public function home()
    {
        return view('site.home');
    }

    // halaman layanan
    public function layanan()
    {
        return view('site.layanan');
    }

    //halaman kontak (GET)
    public function kontak()
    {
        return view('site.kontak');
    }

    // kirim form kontak (POST)
    public function submitKontak(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    // halaman struktur organisasi
    public function struktur()
    {
        return view('site.struktur');
    }

    // halaman login (GET)
    public function login()
    {
        return view('site.login');
    }

    // proses login (POST) 
    public function handleLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // simulasi autentikasi (ganti dengan Auth::attempt di implementasi nyata)
        if ($request->email === 'admin@rshp.com' && $request->password === '12345') {
            // contoh redirect ke dashboard/beranda setelah login
            return redirect('/')->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }
}
