@extends('layouts.app')

@section('content')
<!-- Tambahan CDN Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    
    <!-- 1. HEADER HALAMAN -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <span class="badge bg-primary-light text-primary fw-bold px-3 py-2 text-uppercase mb-2 d-inline-block" style="background-color: rgba(0, 86, 163, 0.1); font-size: 11px; tracking-wider: 1px;">
                <i class="bi bi-shield-check"></i> Account Officer Workspace
            </span>
            <h2 class="fw-bold text-dark m-0" style="font-weight: 800; letter-spacing: -0.5px;">Daftar Laporan Harian</h2>
            <p class="text-muted small m-0 mt-1">Kelola, pantau, dan rekapitulasi data produktivitas harian Anda.</p>
        </div>
        
        <!-- Kumpulan Tombol Aksi Responsif -->
        <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
            <!-- FITUR EXPORT EXCEL RESPONSIF -->
            <a href="{{ route('reports.export') }}" class="btn btn-outline-success px-3 py-2 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2 transition-all" style="font-size: 14px;">
                <i class="bi bi-file-earmark-excel-fill fs-5"></i> Export Excel
            </a>
            <!-- FITUR TAMBAH LAPORAN RESPONSIF -->
            <a href="{{ route('reports.create') }}" class="btn text-white px-4 py-2 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2 transition-all btn-bjb" style="background: #0056a3; font-size: 14px;">
                <i class="bi bi-plus-circle-fill"></i> Tambah Laporan
            </a>
        </div>
    </div>

    <!-- 2. KARTU RINGKASAN DATA BERWARNA (DINAMIS MENGGUNAKAN AGREGASI KOLEKSI) -->
    <div class="row g-3 mb-4">
        <!-- Kartu Total Nasabah -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-primary border-4">
                <div class="rounded-3 p-3 text-primary d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(0, 86, 163, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Nasabah</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        {{ $reports->sum('jumlah_nasabah') }} <span class="text-muted fs-6 fw-normal">Orang</span>
                    </h4>
                </div>
            </div>
        </div>

        <!-- Kartu Total Nominal Dana -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-success border-4">
                <div class="rounded-3 p-3 text-success d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(40, 167, 69, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-wallet2 fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Nominal</p>
                    <h4 class="fw-bold text-success m-0 mt-1" style="font-size: 1.25rem;">
                        Rp {{ number_format($reports->sum('nominal'), 0, ',', '.') }}
                    </h4>
                </div>
            </div>
        </div>

        <!-- Kartu Total Berkas -->
        <div class="col-12 col-md-4 d-sm-none d-md-block">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-warning border-4">
                <div class="rounded-3 p-3 text-warning d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(255, 193, 7, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-file-earmark-text-fill fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Berkas</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        {{ $reports->count() }} <span class="text-muted fs-6 fw-normal">Laporan</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. AREA TABEL PREMIUM DENGAN LOOP DATA REAL -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <!-- Kepala Tabel Khas BJB -->
                <thead class="text-white text-uppercase" style="background: #0056a3; font-size: 12px; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 px-4 text-center text-white" style="width: 70px;">No</th>
                        <th class="py-3 text-white">Nama AO</th>
                        <th class="py-3 text-white">Sektor</th>
                        <th class="py-3 text-center text-white">Jumlah Nasabah</th>
                        <th class="py-3 text-end text-white">Nominal</th>
                        <th class="py-3 text-center text-white">Tanggal</th>
                        <th class="py-3 text-center text-white" style="width: 130px;">Status</th>
                        <th class="py-3 text-center text-white" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <!-- Isi Data Laporan Berdasarkan Database -->
                <tbody class="text-dark" style="font-size: 14px;">
                    @forelse ($reports as $index => $report)
                    <tr class="transition-all">
                        <td class="py-3 px-4 text-center fw-bold text-muted">{{ $index + 1 }}</td>
                        <td class="py-3 fw-bold text-secondary">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" 
                                     style="width: 32px; height: 32px; font-size: 11px; background: #0056a3;">
                                    {{ strtoupper(substr($report->nama_ao ?? $report->user->name ?? 'AO', 0, 2)) }}
                                </div>
                                <span>{{ $report->nama_ao ?? $report->user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            @if(strtolower($report->sektor) == 'ritel')
                                <span class="badge border-0 px-3 py-2 rounded-2 fw-bold bg-info-subtle text-info-emphasis shadow-3xs" style="font-size: 12px;">
                                    <i class="bi bi-shop me-1"></i> Ritel
                                </span>
                            @else
                                <span class="badge border-0 px-3 py-2 rounded-2 fw-bold text-purple bg-purple-light shadow-3xs" style="font-size: 12px;">
                                    <i class="bi bi-cart-dash-fill me-1"></i> Konsumer
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-center fw-bold">{{ $report->jumlah_nasabah }}</td>
                        <td class="py-3 text-end fw-bold text-dark">Rp {{ number_format($report->nominal, 0, ',', '.') }},00</td>
                        <td class="py-3 text-center text-muted">{{ \Carbon\Carbon::parse($report->tanggal)->format('d-0m-Y') }}</td>
                        <td class="py-3 text-center">
                            @if(strtolower($report->status) == 'approved' || strlower($report->status) == 'disetujui')
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 shadow-2xs"><i class="bi bi-check-circle-fill" style="font-size: 11px;"></i> Approved</span>
                            @elseif(strtolower($report->status) == 'rejected' || strlower($report->status) == 'ditolak')
                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 shadow-2xs"><i class="bi bi-x-circle-fill" style="font-size: 11px;"></i> Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 shadow-2xs"><i class="bi bi-hourglass-split" style="font-size: 11px;"></i> Pending</span>
                            @endif
                        </td>
                        <td class="py-3 text-center">
                            <div class="d-inline-flex gap-1">
                                <!-- FITUR EDIT RESPONSIF -->
                                <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-outline-primary rounded-2 p-2 d-flex align-items-center justify-content-center shadow-3xs" style="width: 32px; height: 32px;" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                
                                <!-- FITUR HAPUS RESPONSIF DENGAN PROTEKSI FORM & METHOD DELETE -->
                                <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-2 p-2 d-flex align-items-center justify-content-center shadow-3xs" style="width: 32px; height: 32px;" title="Hapus">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x display-4 d-block mb-2 opacity-50"></i>
                            Belum ada data laporan harian yang tersimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Gaya CSS Kustom Efek Premium -->
<style>
    body {
        background-color: #f8fafc !important;
    }
    .bg-purple-light {
        background-color: rgba(111, 66, 193, 0.12) !important;
    }
    .text-purple {
        color: #6f42c1 !important;
    }
    .btn-bjb:hover {
        background: #003d75 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 86, 163, 0.2) !important;
    }
    .btn-outline-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15) !important;
    }
    tr.transition-all:hover {
        background-color: #f8fafc !important;
    }
    .shadow-2xs {
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
    }
    .shadow-3xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .table th {
        border: none !important;
    }
    .table td {
        border-color: #f1f5f9 !important;
    }
</style>
@endsection