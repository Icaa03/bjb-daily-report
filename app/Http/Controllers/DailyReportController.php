<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use Illuminate\Http\Request;
use App\Exports\ReportsExport; 
use Maatwebsite\Excel\Facades\Excel; 

class DailyReportController extends Controller
{
    // 1. Menampilkan semua data laporan di halaman utama AO (Index)
    public function index()
    {
        $reports = DailyReport::latest()->get();
        return view('reports.index', compact('reports'));
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

        // Otomatis ubah status kembali ke 'pending' jika laporan diedit oleh AO agar bisa diperiksa ulang oleh atasan
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
    // FITUR EXPORT EXCEL BARU: Mengambil data berdasarkan tanggal inputan terbaru
    // =========================================================================
    public function exportExcel()
    {
        // 1. Ambil 1 data laporan yang paling terakhir diinput untuk tahu tanggal terbarunya
        $laporanTerbaru = DailyReport::latest()->first();

        // 2. Jika database ternyata kosong, gunakan tanggal hari ini sebagai cadangan
        $tanggalFilter = $laporanTerbaru ? $laporanTerbaru->tanggal_laporan : \Carbon\Carbon::today()->toDateString();

        // 3. Nama file otomatis mengikuti tanggal data tersebut
        $namaFile = 'Laporan_Harian_BJB_' . $tanggalFilter . '.xlsx';

        // 4. Unduh Excel dengan melemparkan tanggal filter tersebut
        return Excel::download(new ReportsExport($tanggalFilter), $namaFile);
    }

    // =========================================================================
    // FUNGSI UTAMA BARU: Memproses perubahan status Approve / Reject dari Pemimpin
    // =========================================================================
    public function updateStatus(Request $request, $id)
    {
        // Keamanan tingkat akhir: Tolak jika yang menembak link ini bukan pemimpin
        if (auth()->user()->role !== 'pemimpin') {
            abort(403, 'Akses ditolak. Hanya Pemimpin KCP yang dapat memvalidasi laporan.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        $report = DailyReport::findOrFail($id);
        $report->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status validasi laporan berhasil diperbarui!');
    }
}