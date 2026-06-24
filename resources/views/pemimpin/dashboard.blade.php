@extends('layouts.app')

@section('content')
<!-- Tambahan CDN Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    
    <!-- 1. HEADER DASBOR PEMIMPIN PREMIUM -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <span class="badge bg-primary-light text-primary fw-bold px-3 py-2 text-uppercase mb-2 d-inline-block" style="background-color: rgba(0, 86, 163, 0.1); font-size: 11px; tracking-wider: 1px;">
                <i class="bi bi-person-workspace"></i> Executive Dashboard KCP
            </span>
            <h2 class="fw-bold text-dark m-0" style="font-weight: 800; letter-spacing: -0.5px;">Selamat Datang Kembali, Yosi Prasetyo</h2>
            <p class="text-muted small m-0 mt-1">Sistem Pemantauan dan Validasi Kinerja Laporan Harian Staf Account Officer.</p>
        </div>
        
        <div>
            <span class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-2xs d-inline-flex align-items-center gap-1.5" style="font-size: 13px;">
                <span class="spinner-grow spinner-grow-sm text-white" role="status" style="width: 8px; height: 8px;"></span>
                Mode Pemeriksaan Aktif
            </span>
        </div>
    </div>

    <!-- 2. KARTU ANALISIS & STATISTIK EKSEKUTIF BERWARNA -->
    <div class="row g-3 mb-4">
        <!-- Total Laporan Masuk -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-primary border-4">
                <div class="rounded-3 p-3 text-primary d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(0, 86, 163, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-file-earmark-arrow-down-fill fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Laporan Masuk</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        3 <span class="text-muted fs-6 fw-normal">Berkas</span>
                    </h4>
                </div>
            </div>
        </div>

        <!-- Rekapitulasi Nominal Dana -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-success border-4">
                <div class="rounded-3 p-3 text-success d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(40, 167, 69, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-cash-stack fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Nilai Validasi</p>
                    <h4 class="fw-bold text-success m-0 mt-1" style="font-size: 1.25rem;">
                        Rp 855.000.000,00
                    </h4>
                </div>
            </div>
        </div>

        <!-- Total Staf Terpantau -->
        <div class="col-12 col-md-4 d-sm-none d-md-block">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-warning border-4">
                <div class="rounded-3 p-3 text-warning d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(255, 193, 7, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Staf AO Aktif</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        3 <span class="text-muted fs-6 fw-normal">User</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. PANEL TABEL REKAPITULASI LAPORAN STAF -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <!-- Sub-Header Tabel Internal -->
        <div class="card-header bg-white border-0 py-3 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-journal-text text-primary fs-5"></i>
                <h5 class="m-0 fw-bold text-secondary" style="font-size: 15px;">Rekapitulasi Laporan Staf Account Officer (AO)</h5>
            </div>
            <a href="#" class="btn btn-outline-success btn-sm px-3 py-2 rounded-3 fw-bold shadow-2xs d-inline-flex align-items-center gap-1.5 transition-all" style="font-size: 13px;">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <!-- Kepala Tabel Warna Biru Khas BJB Solid -->
                <thead class="text-white text-uppercase" style="background: #0056a3; font-size: 12px; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 px-4 text-center text-white" style="width: 70px;">No</th>
                        <th class="py-3 text-white text-center">Tanggal Lap.</th>
                        <th class="py-3 text-white">Nama AO</th>
                        <th class="py-3 text-white">Sektor</th>
                        <th class="py-3 text-end text-white">Nominal</th>
                        <th class="py-3 text-white px-3">Keterangan</th>
                        <th class="py-3 text-center text-white" style="width: 150px;">Status & Aksi</th>
                    </tr>
                </thead>
                <!-- Isi Data Validasi Pemimpin -->
                <tbody class="text-dark" style="font-size: 14px;">
                    <!-- Data 1 (Yanuar) -->
                    <tr class="transition-all">
                        <td class="py-3 px-4 text-center fw-bold text-muted">1</td>
                        <td class="py-3 text-center text-muted fw-semibold">2026-06-23</td>
                        <td class="py-3 fw-bold text-secondary">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" style="width: 32px; height: 32px; font-size: 11px; background: #0056a3;">
                                    YA
                                </div>
                                <span>Yanuar Aditya</span>
                            </div>
                        </td>
                        <!-- WARNA SEKTOR RITEL DIUBAH MENJADI BIRU LAUT PASTEL (MENCALOK) -->
                        <td class="py-3">
                            <span class="badge border-0 px-3 py-2 rounded-2 fw-bold text-info" style="background-color: rgba(13, 202, 240, 0.15); font-size: 12px;">
                                🏙️ Ritel
                            </span>
                        </td>
                        <td class="py-3 text-end fw-bold text-success">Rp 500.000.000,00</td>
                        <td class="py-3 px-3 text-secondary italic">Pencairan Ritel</td>
                        <td class="py-3 text-center">
                            <span class="badge bg-success rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 w-100 justify-content-center shadow-2xs"><i class="bi bi-check2-all"></i> Disetujui</span>
                        </td>
                    </tr>

                    <!-- Data 2 (Feri) -->
                    <tr class="transition-all">
                        <td class="py-3 px-4 text-center fw-bold text-muted">2</td>
                        <td class="py-3 text-center text-muted fw-semibold">2026-06-22</td>
                        <td class="py-3 fw-bold text-secondary">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" style="width: 32px; height: 32px; font-size: 11px; background: #0056a3;">
                                    FE
                                </div>
                                <span>Feri Prasetio</span>
                            </div>
                        </td>
                        <!-- WARNA SEKTOR KONSUMER DIUBAH MENJADI JINGGA/ORANYE PASTEL (MENCALOK) -->
                        <td class="py-3">
                            <span class="badge border-0 px-3 py-2 rounded-2 fw-bold text-warning" style="background-color: rgba(255, 159, 64, 0.15); color: #fd7e14 !important; font-size: 12px;">
                                🛍️ Konsumer
                            </span>
                        </td>
                        <td class="py-3 text-end fw-bold text-success">Rp 120.000.000,00</td>
                        <td class="py-3 px-3 text-secondary text-truncate" style="max-width: 150px;">sumber pembiayaan ...</td>
                        <td class="py-3 text-center">
                            <span class="badge bg-success rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 w-100 justify-content-center shadow-2xs"><i class="bi bi-check2-all"></i> Disetujui</span>
                        </td>
                    </tr>

                    <!-- Data 3 (Anisa) -->
                    <tr class="transition-all">
                        <td class="py-3 px-4 text-center fw-bold text-muted">3</td>
                        <td class="py-3 text-center text-muted fw-semibold">2026-06-20</td>
                        <td class="py-3 fw-bold text-secondary">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-dark shadow-2xs" style="width: 32px; height: 32px; font-size: 11px; background: #ffd700;">
                                    AN
                                </div>
                                <span>Anisa Cikal</span>
                            </div>
                        </td>
                        <!-- WARNA SEKTOR KONSUMER DIUBAH MENJADI JINGGA/ORANYE PASTEL (MENCALOK) -->
                        <td class="py-3">
                            <span class="badge border-0 px-3 py-2 rounded-2 fw-bold text-warning" style="background-color: rgba(255, 159, 64, 0.15); color: #fd7e14 !important; font-size: 12px;">
                                🛍️ Konsumer
                            </span>
                        </td>
                        <td class="py-3 text-end fw-bold text-success">Rp 235.000.000,00</td>
                        <td class="py-3 px-3 text-muted">-</td>
                        <td class="py-3 text-center">
                            <span class="badge bg-success rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 w-100 justify-content-center shadow-2xs"><i class="bi bi-check2-all"></i> Disetujui</span>
                        </td>
                    </tr>
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
    .table th {
        border: none !important;
    }
    .table td {
        border-color: #f1f5f9 !important;
    }
</style>
@endsection