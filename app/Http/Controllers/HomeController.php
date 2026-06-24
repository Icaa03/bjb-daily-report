<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DailyReport;

class HomeController extends Controller
{
    public function __construct()
    {
        // Kosong untuk mendukung struktur routing Laravel versi baru
    }

    /**
     * Membaca role user setelah login, lalu melempar ke halaman masing-masing
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $role = Auth::user()->role;

        if ($role === 'ao') {
            return redirect()->route('reports.index');
        }

        if ($role === 'pemimpin') {
            return redirect()->route('pemimpin.dashboard');
        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
    }

    /**
     * Menampilkan Halaman Dasbor Pemimpin KCP beserta data laporan harian
     */
    public function pemimpinIndex()
    {
        // Mengambil semua data laporan, diurutkan dari yang paling baru
        $reports = DailyReport::latest()->get();

        // Menghitung total laporan yang terkumpul di database
        $totalLaporan = $reports->count();

        return view('pemimpin.dashboard', compact('reports', 'totalLaporan')); 
    }
}