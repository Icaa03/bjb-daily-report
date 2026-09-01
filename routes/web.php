<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// 1. Jalur awal otomatis mengarah ke pintu login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Fitur Autentikasi Bawaan Laravel (Login, Register, Logout)
Auth::routes();

// 3. Jembatan Pengalihan Sesaat Setelah Sukses Login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 4. GROUP ROUTE KHUSUS ACCOUNT OFFICER (AO) - (Role diubah ke 'AO' huruf besar)
Route::middleware(['auth', 'role:AO'])->group(function () {
    // RUTE EXPORT KHUSUS AO (Nama Rute diubah agar unik dan anti-bentrok)
    Route::get('ao/export/excel', [DailyReportController::class, 'exportExcelAO'])->name('ao.export');
    
    Route::get('reports', [DailyReportController::class, 'index'])->name('reports.index');
    Route::get('reports/create', [DailyReportController::class, 'create'])->name('reports.create');
    Route::post('reports', [DailyReportController::class, 'store'])->name('reports.store');
    Route::get('reports/{id}/edit', [DailyReportController::class, 'edit'])->name('reports.edit');
    Route::put('reports/{id}', [DailyReportController::class, 'update'])->name('reports.update');
    Route::delete('reports/{id}', [DailyReportController::class, 'destroy'])->name('reports.destroy');
});

// 5. GROUP ROUTE KHUSUS PEMIMPIN KCP - (Role diubah ke 'Pemimpin KCP' sesuai database)
Route::middleware(['auth', 'role:Pemimpin KCP'])->group(function () {
    Route::get('/pemimpin/dashboard', [HomeController::class, 'pemimpinIndex'])->name('pemimpin.dashboard');
    
    // Jalur khusus untuk Pemimpin mengunduh Excel (Semua data KCP)
    Route::get('/pemimpin/export/excel', [DailyReportController::class, 'exportExcelPemimpin'])->name('pemimpin.export');
    
    // Jalur khusus untuk memproses tombol Approve & Reject dari Pemimpin
    Route::put('/reports/{id}/status', [DailyReportController::class, 'updateStatus'])->name('reports.updateStatus');
});

// 6. JALUR PINTAS RE-FRESH AKUN
Route::get('/fix-akun-bjb', function () {
    // 1. Hapus akun lama menggunakan import yang sah
    User::where('email', 'kcpsurade@bankbjb.co.id')->delete();

    // 2. Buat ulang akun secara murni tanpa backslash tambahan
    $user = User::create([
        'name' => 'Pemimpin KCP Surade',
        'email' => 'kcpsurade@bankbjb.co.id',
        'password' => Hash::make('password123'),
        'role' => 'Pemimpin KCP'
    ]);

    // Kita return response teks + pastikan role yang masuk benar-benar tercetak
    return "Berhasil! Akun baru terbuat dengan Role: " . $user->role . ". Silakan login ulang.";
});

// 7. JALUR SETUP DATABASE ON-DEPLOY (Migrate & Akun Default untuk Vercel / Production)
Route::get('/setup-production-bjb', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate --force');
        
        // Buat / Update akun Pemimpin
        User::updateOrCreate(
            ['email' => 'kcpsurade@bankbjb.co.id'],
            [
                'name' => 'Pemimpin KCP Surade',
                'password' => Hash::make('password123'),
                'role' => 'Pemimpin KCP'
            ]
        );

        // Buat / Update akun AO
        User::updateOrCreate(
            ['email' => 'ao@bankbjb.co.id'],
            [
                'name' => 'Anisa Cikal',
                'password' => Hash::make('password123'),
                'role' => 'AO'
            ]
        );

        return "<h3>✅ Berhasil Setup Database!</h3><p>Tabel database telah dibuat dan akun testing sudah siap:</p><ul><li><b>Pemimpin:</b> kcpsurade@bankbjb.co.id | password: password123</li><li><b>AO:</b> ao@bankbjb.co.id | password: password123</li></ul><br><a href='/login' style='display:inline-block;padding:8px 16px;background:#0056a3;color:#fff;text-decoration:none;border-radius:6px;'>Menuju Pintu Login</a>";
    } catch (\Exception $e) {
        return "❌ Gagal setup database: " . $e->getMessage();
    }
});