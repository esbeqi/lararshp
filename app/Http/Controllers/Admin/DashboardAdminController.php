<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // arahkan ke tampilan dashboard admin
        return view('admin.dashboard-admin');
    }
}