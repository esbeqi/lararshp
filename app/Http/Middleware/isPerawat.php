<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isPerawat
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = session('user_role');

        if ($userRole == 3) {
            return $next($request);
        }

        return back()->with('error', 'Akses ditolak. Anda bukan perawat.');
    }
}