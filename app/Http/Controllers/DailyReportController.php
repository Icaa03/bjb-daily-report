<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use Illuminate\Http\Request;
use App\Exports\ReportsExport; 
use Maatwebsite\Excel\Facades\Excel; 

class DailyReportController extends Controller
{
    // 1. Menampilkan semua data laporan di halaman utama AO (Index) dengan Folder Sektor
    public function index()
    {
        $reports = DailyReport::latest()->get();

        $sectors = [
            'Konsumer' => [
                'name' => 'Konsumer',
                'icon' => 'bi-bag-check-fill',
                'emoji' => '🛍️',
                'color' => '#fd7e14',
                'bg' => 'rgba(253, 126, 20, 0.12)',
                'border' => '#fd7e14'
            ],
            'Ritel' => [
                'name' => 'Ritel',
                'icon' => 'bi-buildings-fill',
                'emoji' => '🏙️',
                'color' => '#0dcaf0',
                'bg' => 'rgba(13, 202, 240, 0.12)',
                'border' => '#0dcaf0'
            ],
            'Digi' => [
                'name' => 'Digi',
                'icon' => 'bi-phone-fill',
                'emoji' => '📱',
                'color' => '#6f42c1',
                'bg' => 'rgba(111, 66, 193, 0.12)',
                'border' => '#6f42c1'
            ],
            'Tabungan' => [
                'name' => 'Tabungan',
                'icon' => 'bi-piggy-bank-fill',
                'emoji' => '💰',
                'color' => '#198754',
                'bg' => 'rgba(25, 135, 84, 0.12)',
                'border' => '#198754'
            ],
            'ATM' => [
                'name' => 'ATM',
                'icon' => 'bi-credit-card-2-front-fill',
                'emoji' => '🏧',
                'color' => '#0056a3',
                'bg' => 'rgba(0, 86, 163, 0.12)',
                'border' => '#0056a3'
            ],
        ];
            
        return view('reports.index', compact('reports', 'sectors'));
    }

    // 2. Menampilkan form tambah laporan baru (Create)
    public function create()
    {
        return view('reports.create');
    }

    // 3. Menyimpan data laporan baru dari form ke database (Store)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ao' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'sektor' => 'required|in:Konsumer,Ritel,Digi,Tabungan,ATM',
            'jumlah_nasabah' => 'required|integer|min:0',
            'nominal' => 'required|numeric|min:0',
            'tanggal_laporan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        DailyReport::create($validated);

        return redirect()->route('reports.index')->with('success', 'Laporan harian berhasil disimpan!');
    }

    // 4. Memperbarui isi data laporan dari form edit AO (Update)
    public function update(Request $request, $id)
    {
        $report = DailyReport::findOrFail($id);

        $validated = $request->validate([
            'nama_ao' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'sektor' => 'required|in:Konsumer,Ritel,Digi,Tabungan,ATM',
            'jumlah_nasabah' => 'required|integer|min:0',
            'nominal' => 'required|numeric|min:0',
            'tanggal_laporan' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        $report->update($validated);

        return redirect()->route('reports.index')->with('success', 'Data laporan harian berhasil diubah!');
    }

    // 5. Menampilkan halaman form edit laporan dengan membawa data lama (Edit)
    public function edit($id)
    {
        $report = DailyReport::findOrFail($id);
        return view('reports.edit', compact('report'));
    }

    // 6. Menghapus data laporan dari database (Destroy)
    public function destroy($id)
    {
        $report = DailyReport::findOrFail($id);
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus!');
    }

    // =========================================================================
    // FITUR EXPORT EXCEL KHUSUS AO: Mendownload Laporan Milik Akun Sendiri Saja
    // =========================================================================
    public function exportExcelAO()
    {
        $namaAo = auth()->user()->name;
        $namaFile = 'Laporan_Excel_AO_' . str_replace(' ', '_', $namaAo) . '.xlsx';

        return Excel::download(new ReportsExport(null, $namaAo), $namaFile);
    }

    // =========================================================================
    // FITUR EXPORT EXCEL PEMIMPIN: Mengambil seluruh data KCP berdasarkan tanggal terbaru
    // =========================================================================
    public function exportExcelPemimpin()
    {
        $laporanTerbaru = DailyReport::latest()->first();
        $tanggalFilter = $laporanTerbaru ? $laporanTerbaru->tanggal_laporan : \Carbon\Carbon::today()->toDateString();
        $namaFile = 'Laporan_Harian_BJB_KCP_' . $tanggalFilter . '.xlsx';

        return Excel::download(new ReportsExport($tanggalFilter, null), $namaFile);
    }

    // =========================================================================
    // FUNGSI UTAMA: Memproses perubahan status Approve / Reject dari Pemimpin
    // =========================================================================
    public function updateStatus(Request $request, $id)
    {
        // KOREKSI AMAN: Sesuaikan dengan string murni 'Pemimpin KCP' di database
        if (auth()->user()->role !== 'Pemimpin KCP') {
            abort(403, 'Akses ditolak. Hanya Pemimpin KCP yang dapat memvalidasi laporan.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        $report = DailyReport::findOrFail($id);
        $report->update([
            'status' => $request->status
        ]);

        return redirect()->back()
            ->with('success', 'Status validasi laporan berhasil diperbarui!');
    }
}