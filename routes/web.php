<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// 1. Jalur awal otomatis mengarah ke pintu login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Fitur Autentikasi Bawaan Laravel (Login, Register, Logout)
Auth::routes();

// 3. Jembatan Pengalihan Sesaat Setelah Sukses Login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 4. GROUP ROUTE KHUSUS ACCOUNT OFFICER (AO)
// Wajib login dan harus memiliki role 'ao'
Route::middleware(['auth', 'role:ao'])->group(function () {
    Route::get('reports/export/excel', [DailyReportController::class, 'exportExcel'])->name('reports.export');
    Route::resource('reports', DailyReportController::class);
});

// 5. GROUP ROUTE KHUSUS PEMIMPIN KCP
// Wajib login dan harus memiliki role 'pemimpin'
Route::middleware(['auth', 'role:pemimpin'])->group(function () {
    Route::get('/pemimpin/dashboard', [HomeController::class, 'pemimpinIndex'])->name('pemimpin.dashboard');
    
    // Jalur khusus untuk Pemimpin mengunduh Excel
    Route::get('/pemimpin/export/excel', [DailyReportController::class, 'exportExcel'])->name('pemimpin.export');
    
    // Jalur khusus untuk memproses tombol Approve & Reject dari Pemimpin
    Route::put('/reports/{id}/status', [DailyReportController::class, 'updateStatus'])->name('reports.updateStatus');
});