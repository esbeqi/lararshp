<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil user
        $user = User::with(['roleUsers' => function ($query) {
            $query->where('status', 1);
        }, 'roleUsers.role'])
        ->where('email', $request->input('email'))
        ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.'])->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.'])->withInput();
        }

        // Login user
        Auth::login($user);

        // Simpan session
        $request->session()->put([
            'user_id' => $user->iduser,
            'user_name' => $user->nama,
            'user_email' => $user->email,
            'user_role' => $user->roleUsers[0]->idrole ?? 'user',
            'user_role_name' => $user->roleUsers[0]->role->nama_role ?? 'User',
            'user_status' => $user->roleUsers[0]->status ?? 'active',
        ]);

        // Arahkan berdasarkan role
        $userRole = $user->roleUsers[0]->idrole ?? null;

        switch ($userRole) {
            case 1:
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Administrator!');
            case 2:
                return redirect()->route('dokter.dashboard')->with('success', 'Login berhasil sebagai Dokter!');
            case 3:
                return redirect()->route('perawat.dashboard')->with('success', 'Login berhasil sebagai Perawat!');    
            case 4:
                return redirect()->route('resepsionis.dashboard')->with('success', 'Login berhasil sebagai Resepsionis!');
            case 5:
                return redirect()->route('pemilik.dashboard')->with('success', 'Login berhasil sebagai Pemilik!');
            default:
                return redirect()->route('home')->with('success', 'Login berhasil!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}