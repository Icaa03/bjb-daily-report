@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <span class="badge bg-primary-light text-primary fw-bold px-3 py-2 text-uppercase mb-2 d-inline-block" style="background-color: rgba(0, 86, 163, 0.1); font-size: 11px; tracking-wider: 1px;">
                <i class="bi bi-person-workspace"></i> Executive Dashboard KCP
            </span>
            <h2 class="fw-bold text-dark m-0" style="font-weight: 800; letter-spacing: -0.5px;">Selamat Datang Kembali, {{ Auth::user()->name ?? 'Yosi Prasetyo' }}</h2>
            <p class="text-muted small m-0 mt-1">Sistem Pemantauan dan Validasi Kinerja Laporan Harian Staf Account Officer.</p>
        </div>
        
        <div>
            <span class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-2xs d-inline-flex align-items-center gap-1.5" style="font-size: 13px;">
                <span class="spinner-grow spinner-grow-sm text-white" role="status" style="width: 8px; height: 8px;"></span>
                Mode Pemeriksaan Aktif
            </span>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-primary border-4">
                <div class="rounded-3 p-3 text-primary d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(0, 86, 163, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-file-earmark-arrow-down-fill fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Laporan Masuk</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        {{ $reports->count() }} <span class="text-muted fs-6 fw-normal">Berkas</span>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-success border-4">
                <div class="rounded-3 p-3 text-success d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(40, 167, 69, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-cash-stack fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Nilai Validasi</p>
                    <h4 class="fw-bold text-success m-0 mt-1" style="font-size: 1.25rem;">
                        Rp {{ number_format($reports->whereIn('status', ['approved', 'disetujui', 'Approved', 'Disetujui'])->sum('nominal'), 0, ',', '.') }},00
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4 d-sm-none d-md-block">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white d-flex flex-row align-items-center gap-3 border-start border-warning border-4">
                <div class="rounded-3 p-3 text-warning d-flex align-items-center justify-content-center shadow-2xs" style="background-color: rgba(255, 193, 7, 0.08); width: 55px; height: 55px;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div>
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Staf AO Aktif</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        {{ $reports->unique('nama_ao')->count() }} <span class="text-muted fs-6 fw-normal">User</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-journal-text text-primary fs-5"></i>
                <h5 class="m-0 fw-bold text-secondary" style="font-size: 15px;">Rekapitulasi Laporan Staf Account Officer (AO)</h5>
            </div>
            <a href="{{ route('pemimpin.export') }}" class="btn btn-outline-success btn-sm px-3 py-2 rounded-3 fw-bold shadow-2xs d-inline-flex align-items-center gap-1.5 transition-all" style="font-size: 13px;">
                <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle m-0">
                <thead class="text-white text-uppercase" style="background: #0056a3; font-size: 12px; letter-spacing: 0.5px;">
                    <tr>
                        <th class="py-3 px-4 text-center text-white" style="width: 70px;">No</th>
                        <th class="py-3 text-white text-center">Tanggal Lap.</th>
                        <th class="py-3 text-white">Nama AO</th>
                        <th class="py-3 text-white">Sektor</th>
                        <th class="py-3 text-end text-white">Nominal</th>
                        <th class="py-3 text-white px-3">Keterangan</th>
                        <th class="py-3 text-center text-white" style="width: 160px;">Status & Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-dark" style="font-size: 14px;">
                    @forelse ($reports as $index => $report)
                    <tr class="transition-all">
                        <td class="py-3 px-4 text-center fw-bold text-muted">{{ $index + 1 }}</td>
                        <td class="py-3 text-center text-muted fw-semibold">
                            {{ \Carbon\Carbon::parse($report->tanggal_laporan ?? $report->tanggal)->format('Y-m-d') }}
                        </td>
                        <td class="py-3 fw-bold text-secondary">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" style="width: 32px; height: 32px; font-size: 11px; background: #0056a3;">
                                    {{ strtoupper(substr($report->nama_ao ?? $report->user->name ?? 'AO', 0, 2)) }}
                                </div>
                                <span>{{ $report->nama_ao ?? $report->user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            @if(strtolower($report->sektor) == 'ritel')
                                <span class="badge border-0 px-3 py-2 rounded-2 fw-bold text-info" style="background-color: rgba(13, 202, 240, 0.15); font-size: 12px;">
                                    🏙️ Ritel
                                </span>
                            @else
                                <span class="badge border-0 px-3 py-2 rounded-2 fw-bold text-warning" style="background-color: rgba(255, 159, 64, 0.15); color: #fd7e14 !important; font-size: 12px;">
                                    🛍️ Konsumer
                                </span>
                            @endif
                        </td>
                        <td class="py-3 text-end fw-bold text-success">Rp {{ number_format($report->nominal, 0, ',', '.') }},00</td>
                        <td class="py-3 px-3 text-secondary text-truncate" style="max-width: 150px;">
                            {{ $report->keterangan ?? '-' }}
                        </td>
                        <td class="py-3 text-center">
                            @if(strtolower($report->status) == 'approved' || strtolower($report->status) == 'disetujui')
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 w-100 justify-content-center shadow-2xs"><i class="bi bi-check2-all"></i> Disetujui</span>
                            @elseif(strtolower($report->status) == 'rejected' || strtolower($report->status) == 'ditolak')
                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center gap-1 w-100 justify-content-center shadow-2xs"><i class="bi bi-x-circle-fill"></i> Ditolak</span>
                            @else
                                <div class="d-flex gap-1 justify-content-center">
                                    <form action="{{ route('reports.updateStatus', $report->id) }}" method="POST" class="m-0 w-50">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-success rounded-3 fw-bold py-1 px-2 w-100 shadow-2xs" style="font-size: 11px;">
                                            <i class="bi bi-check-lg"></i> Acc
                                        </button>
                                    </form>

                                    <form action="{{ route('reports.updateStatus', $report->id) }}" method="POST" class="m-0 w-50">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-danger rounded-3 fw-bold py-1 px-2 w-100 shadow-2xs" style="font-size: 11px;">
                                            <i class="bi bi-x"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x display-4 d-block mb-2 opacity-50"></i>
                            Belum ada berkas laporan masuk dari staf AO.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

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