<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyReport; // IMPOR: Pastikan model DailyReport ini sudah dipanggil

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Sengaja dikosongkan untuk mendukung routing Laravel 12
    }

    /**
     * Jembatan Utama Pengalihan Sesaat Setelah Sukses Login
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'AO') {
            return redirect()->route('reports.index');
        } 
        
        if ($user->role === 'Pemimpin KCP') {
            return redirect()->route('pemimpin.dashboard');
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Jabatan akun tidak dikenali oleh sistem.');
    }

    /**
     * Halaman Dashboard Utama Khusus Pemimpin KCP (SUDAH DIPERBAIKI)
     */
    public function pemimpinIndex()
    {
        // 1. Ambil semua data laporan dari database, urutkan dari yang paling baru
        $reports = DailyReport::latest()->get();

        // 2. Kirim variabel $reports ke dalam view pemimpin/dashboard.blade.php
        return view('pemimpin.dashboard', compact('reports'));
    }
}