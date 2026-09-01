@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    
    <!-- HEADER WORKSPACE -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-1 gap-3">
        <div>
            <span class="badge text-white fw-bold px-3 py-2 text-uppercase mb-2 d-inline-block shadow-2xs" style="background-color: #0056a3 !important; font-size: 11px; letter-spacing: 0.5px;">
                <i class="bi bi-laptop me-1"></i> Account Officer Workspace
            </span>
            <h2 class="fw-bold text-dark m-0" style="font-weight: 800; letter-spacing: -0.5px;">Selamat Datang, {{ Auth::user()->name ?? 'AO Bank bjb' }}</h2>
            <p class="text-muted small m-0 mt-1">Kelola dan pantau produktivitas pencairan laporan harian Anda terorganisir per folder sektor.</p>
        </div>
        
        <div class="d-flex gap-2.5 align-items-center flex-wrap">
            <a href="{{ route('ao.export') }}" class="btn btn-outline-success px-3.5 py-2 rounded-3 fw-bold shadow-2xs d-inline-flex align-items-center gap-2 transition-all" style="font-size: 14px;">
                <i class="bi bi-file-earmark-excel-fill text-success"></i> Export Excel
            </a>
            <a href="{{ route('reports.create') }}" class="btn text-white fw-bold px-4 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-2 transition-all btn-bjb-primary" style="font-size: 14px; text-decoration: none;">
                <i class="bi bi-plus-circle-fill"></i> Tambah Laporan Harian
            </a>
        </div>
    </div>

    <!-- FLASH MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-3">
            <i class="bi bi-check-circle-fill text-success fs-4"></i>
            <div>
                <strong class="d-block">Berhasil!</strong>
                <span class="small">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- OVERALL METRIC CARDS -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3.5 bg-white d-flex flex-row align-items-center gap-3 border-start border-primary border-4 h-100">
                <div class="rounded-3 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: rgba(0, 86, 163, 0.08); width: 56px; height: 56px;">
                    <i class="bi bi-folder-fill fs-3"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Seluruh Berkas</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        {{ $reports->count() }} <span class="text-muted fs-6 fw-normal">Berkas</span>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3.5 bg-white d-flex flex-row align-items-center gap-3 border-start border-success border-4 h-100">
                <div class="rounded-3 text-success d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: rgba(40, 167, 69, 0.08); width: 56px; height: 56px;">
                    <i class="bi bi-cash-stack fs-3"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Capaian Nominal</p>
                    <h4 class="fw-bold text-success m-0 mt-1" style="font-size: 1.25rem;">
                        Rp {{ number_format($reports->sum('nominal'), 0, ',', '.') }},00
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3.5 bg-white d-flex flex-row align-items-center gap-3 border-start border-info border-4 h-100">
                <div class="rounded-3 text-info d-flex align-items-center justify-content-center flex-shrink-0" style="background-color: rgba(13, 202, 240, 0.1); width: 56px; height: 56px;">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
                <div class="overflow-hidden">
                    <p class="text-muted small fw-bold text-uppercase m-0" style="font-size: 11px; letter-spacing: 0.5px;">Total Nasabah (NOA)</p>
                    <h4 class="fw-bold text-dark m-0 mt-1">
                        {{ $reports->sum('jumlah_nasabah') }} <span class="text-muted fs-6 fw-normal">Nasabah</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- FOLDER SEKTOR DIRECTORY NAVIGATION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 pb-3 border-bottom border-light gap-2">
            <div>
                <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2" style="font-size: 16px;">
                    <i class="bi bi-folder2-open text-primary fs-5"></i> Direktori Folder Sektor
                </h5>
                <p class="text-muted small m-0 mt-1">Pilih folder di bawah ini untuk menampilkan daftar laporan terpisah per sektor bisnis.</p>
            </div>
            <span class="badge bg-light text-primary border px-3 py-1.5 rounded-pill small fw-semibold">
                {{ count($sectors) }} Sektor Bisnis Aktif
            </span>
        </div>

        <!-- FOLDER GRID BUTTONS (RESPONSIVE CARDS) -->
        <div class="nav nav-pills row g-3 row-cols-2 row-cols-md-3 row-cols-xl-6 p-0 m-0 border-0" id="sectorFolderTabs" role="tablist">
            
            <!-- FOLDER CARD: SEMUA SEKTOR -->
            <div class="col p-1" role="presentation">
                <button class="nav-link active folder-card w-100 text-start border-0" 
                        id="tab-all" 
                        data-bs-toggle="pill" 
                        data-bs-target="#folder-all" 
                        type="button" 
                        role="tab" 
                        aria-controls="folder-all" 
                        aria-selected="true">
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="folder-icon-circle bg-primary text-white">
                            <i class="bi bi-grid-fill"></i>
                        </div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1 small fw-bold">
                            {{ $reports->count() }} Berkas
                        </span>
                    </div>

                    <div class="folder-content">
                        <span class="folder-name fw-bold d-block text-dark">Semua Sektor</span>
                        <span class="folder-meta text-muted small d-block">
                            Rp {{ number_format($reports->sum('nominal'), 0, ',', '.') }}
                        </span>
                    </div>
                </button>
            </div>

            <!-- FOLDER CARDS: TIAP SEKTOR -->
            @foreach($sectors as $key => $sector)
                @php
                    $secReports = $reports->where('sektor', $key);
                    $sectorCount = $secReports->count();
                    $sectorSum = $secReports->sum('nominal');
                @endphp
                <div class="col p-1" role="presentation">
                    <button class="nav-link folder-card w-100 text-start border-0" 
                            id="tab-{{ strtolower($key) }}" 
                            data-bs-toggle="pill" 
                            data-bs-target="#folder-{{ strtolower($key) }}" 
                            type="button" 
                            role="tab" 
                            aria-controls="folder-{{ strtolower($key) }}" 
                            aria-selected="false">
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="folder-icon-circle" style="background-color: {{ $sector['bg'] }}; color: {{ $sector['color'] }};">
                                <i class="bi {{ $sector['icon'] }}"></i>
                            </div>
                            <span class="badge rounded-pill px-2 py-1 small fw-bold" style="background-color: {{ $sector['bg'] }}; color: {{ $sector['color'] }};">
                                {{ $sectorCount }} Berkas
                            </span>
                        </div>

                        <div class="folder-content">
                            <span class="folder-name fw-bold d-block text-dark">{{ $sector['emoji'] }} {{ $sector['name'] }}</span>
                            <span class="folder-meta text-muted small d-block">
                                Rp {{ number_format($sectorSum, 0, ',', '.') }}
                            </span>
                        </div>
                    </button>
                </div>
            @endforeach

        </div>
    </div>

    <!-- TAB CONTENT: DAFTAR LAPORAN PER FOLDER SEKTOR -->
    <div class="tab-content" id="sectorFolderTabsContent">
        
        <!-- PANE: SEMUA SEKTOR -->
        <div class="tab-pane fade show active" id="folder-all" role="tabpanel" aria-labelledby="tab-all">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-white border-0 py-3.5 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle bg-primary-subtle text-primary p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-journal-text fs-5"></i>
                        </div>
                        <div>
                            <h5 class="m-0 fw-bold text-dark" style="font-size: 15px;">Daftar Seluruh Laporan Harian (Semua Sektor)</h5>
                            <span class="text-muted small">Menampilkan semua berkas laporan dari seluruh lini sektor bisnis</span>
                        </div>
                    </div>
                    <span class="badge bg-light text-primary border px-3 py-2 rounded-pill fw-bold small">
                        Total: {{ $reports->count() }} Berkas
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="text-white text-uppercase" style="background: #0056a3; font-size: 12px; letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-3 px-3 text-center text-white" style="width: 60px;">No</th>
                                <th class="py-3 text-white text-center" style="width: 120px;">Tanggal Lap.</th>
                                <th class="py-3 text-white" style="min-width: 160px;">Nama AO</th>
                                <th class="py-3 text-white text-center" style="width: 140px;">Sektor</th>
                                <th class="py-3 text-center text-white" style="width: 80px;">NOA</th>
                                <th class="py-3 text-end text-white" style="min-width: 160px;">Nominal</th>
                                <th class="py-3 text-white px-3" style="min-width: 180px;">Keterangan</th>
                                <th class="py-3 text-center text-white" style="width: 120px;">Status</th>
                                <th class="py-3 text-center text-white" style="width: 110px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark" style="font-size: 14px;">
                            @forelse ($reports as $index => $report)
                            <tr class="transition-all">
                                <td class="py-3 px-3 text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                <td class="py-3 text-center text-muted fw-semibold">
                                    {{ \Carbon\Carbon::parse($report->tanggal_laporan ?? $report->tanggal)->format('Y-m-d') }}
                                </td>
                                <td class="py-3 fw-bold text-secondary">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" style="width: 30px; height: 30px; font-size: 11px; background: #0056a3;">
                                            {{ strtoupper(substr($report->nama_ao ?? 'AO', 0, 2)) }}
                                        </div>
                                        <span>{{ $report->nama_ao }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    @php
                                        $secInfo = $sectors[$report->sektor] ?? [
                                            'emoji' => '📁', 
                                            'bg' => 'rgba(0, 86, 163, 0.1)', 
                                            'color' => '#0056a3'
                                        ];
                                    @endphp
                                    <span class="badge border-0 px-2.5 py-1.5 rounded-pill fw-bold" style="background-color: {{ $secInfo['bg'] }}; color: {{ $secInfo['color'] }}; font-size: 12px;">
                                        {{ $secInfo['emoji'] }} {{ $report->sektor }}
                                    </span>
                                </td>
                                <td class="py-3 text-center fw-semibold text-secondary">
                                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill">
                                        {{ $report->jumlah_nasabah ?? 0 }}
                                    </span>
                                </td>
                                <td class="py-3 text-end fw-bold text-success">Rp {{ number_format($report->nominal, 0, ',', '.') }},00</td>
                                <td class="py-3 px-3 text-secondary text-truncate" style="max-width: 180px;" title="{{ $report->keterangan }}">
                                    {{ $report->keterangan ?? '-' }}
                                </td>
                                <td class="py-3 text-center">
                                    @if(strtolower($report->status) == 'approved' || strtolower($report->status) == 'disetujui')
                                        <span class="badge bg-success rounded-pill px-3 py-1.5 fw-bold text-white small shadow-2xs"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                                    @elseif(strtolower($report->status) == 'rejected' || strtolower($report->status) == 'ditolak')
                                        <span class="badge bg-danger rounded-pill px-3 py-1.5 fw-bold text-white small shadow-2xs"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1.5 fw-bold small shadow-2xs"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex gap-1.5 justify-content-center">
                                        <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1" title="Edit Laporan">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2.5 py-1" title="Hapus Laporan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x display-4 d-block mb-2 opacity-50 text-muted"></i>
                                    <p class="m-0 fw-semibold">Belum ada berkas laporan harian.</p>
                                    <a href="{{ route('reports.create') }}" class="btn btn-sm text-white mt-2 rounded-3 px-3 py-2 btn-bjb-primary">
                                        <i class="bi bi-plus-lg me-1"></i> Tambah Laporan Sekarang
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PANE: KHUSUS PER SEKTOR (DIPISAHKAN MASING-MASING) -->
        @foreach($sectors as $key => $sector)
            @php
                $sectorReports = $reports->where('sektor', $key);
                $secCount = $sectorReports->count();
                $secSum = $sectorReports->sum('nominal');
                $secNoa = $sectorReports->sum('jumlah_nasabah');
            @endphp
            <div class="tab-pane fade" id="folder-{{ strtolower($key) }}" role="tabpanel" aria-labelledby="tab-{{ strtolower($key) }}">
                
                <!-- HEADER BANNER KHUSUS FOLDER SEKTOR -->
                <div class="card border-0 shadow-sm rounded-4 p-3.5 mb-3 bg-white border-start border-4" style="border-color: {{ $sector['border'] }} !important;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 p-3 d-flex align-items-center justify-content-center shadow-2xs flex-shrink-0" style="background-color: {{ $sector['bg'] }}; color: {{ $sector['color'] }}; width: 52px; height: 52px; font-size: 24px;">
                                <i class="bi {{ $sector['icon'] }}"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                                    <span>Folder Laporan: Sektor {{ $sector['name'] }}</span>
                                    <span class="badge border-0 rounded-pill px-2.5 py-1 small fw-bold" style="background-color: {{ $sector['bg'] }}; color: {{ $sector['color'] }};">
                                        {{ $sector['emoji'] }} {{ $sector['name'] }}
                                    </span>
                                </h5>
                                <p class="text-muted small m-0 mt-1">
                                    Menampilkan <strong>{{ $secCount }} berkas</strong> • Total Nominal: <strong class="text-success">Rp {{ number_format($secSum, 0, ',', '.') }},00</strong> • Total NOA: <strong>{{ $secNoa }} Nasabah</strong>
                                </p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('reports.create', ['sektor' => $key]) }}" class="btn btn-sm text-white fw-bold px-3.5 py-2 rounded-3 shadow-2xs d-inline-flex align-items-center gap-1.5 btn-bjb-primary" style="font-size: 13px;">
                                <i class="bi bi-plus-circle-fill"></i> Tambah di Sektor {{ $sector['name'] }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- TABEL LAPORAN SEKTOR INI -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle m-0">
                            <thead class="text-white text-uppercase" style="background: #0056a3; font-size: 12px; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-3 px-3 text-center text-white" style="width: 60px;">No</th>
                                    <th class="py-3 text-white text-center" style="width: 120px;">Tanggal Lap.</th>
                                    <th class="py-3 text-white" style="min-width: 160px;">Nama AO</th>
                                    <th class="py-3 text-white" style="min-width: 140px;">Jabatan</th>
                                    <th class="py-3 text-center text-white" style="width: 120px;">Jumlah Nasabah</th>
                                    <th class="py-3 text-end text-white" style="min-width: 160px;">Nominal</th>
                                    <th class="py-3 text-white px-3" style="min-width: 180px;">Keterangan</th>
                                    <th class="py-3 text-center text-white" style="width: 120px;">Status</th>
                                    <th class="py-3 text-center text-white" style="width: 110px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark" style="font-size: 14px;">
                                @forelse ($sectorReports as $idx => $report)
                                <tr class="transition-all">
                                    <td class="py-3 px-3 text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                    <td class="py-3 text-center text-muted fw-semibold">
                                        {{ \Carbon\Carbon::parse($report->tanggal_laporan ?? $report->tanggal)->format('Y-m-d') }}
                                    </td>
                                    <td class="py-3 fw-bold text-secondary">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-2xs" style="width: 30px; height: 30px; font-size: 11px; background: #0056a3;">
                                                {{ strtoupper(substr($report->nama_ao ?? 'AO', 0, 2)) }}
                                            </div>
                                            <span>{{ $report->nama_ao }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-muted small">{{ $report->jabatan ?? '-' }}</td>
                                    <td class="py-3 text-center fw-semibold text-secondary">
                                        <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill">
                                            <i class="bi bi-person-fill text-muted me-1"></i>{{ $report->jumlah_nasabah ?? 0 }} NOA
                                        </span>
                                    </td>
                                    <td class="py-3 text-end fw-bold text-success">Rp {{ number_format($report->nominal, 0, ',', '.') }},00</td>
                                    <td class="py-3 px-3 text-secondary text-truncate" style="max-width: 180px;" title="{{ $report->keterangan }}">
                                        {{ $report->keterangan ?? '-' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        @if(strtolower($report->status) == 'approved' || strtolower($report->status) == 'disetujui')
                                            <span class="badge bg-success rounded-pill px-3 py-1.5 fw-bold text-white small shadow-2xs"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>
                                        @elseif(strtolower($report->status) == 'rejected' || strtolower($report->status) == 'ditolak')
                                            <span class="badge bg-danger rounded-pill px-3 py-1.5 fw-bold text-white small shadow-2xs"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1.5 fw-bold small shadow-2xs"><i class="bi bi-hourglass-split me-1"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex gap-1.5 justify-content-center">
                                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1" title="Edit Laporan">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2.5 py-1" title="Hapus Laporan">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">
                                        <div class="d-inline-flex p-3 rounded-circle mb-3" style="background-color: {{ $sector['bg'] }}; color: {{ $sector['color'] }}; font-size: 32px;">
                                            <i class="bi {{ $sector['icon'] }}"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark">Folder Sektor {{ $sector['name'] }} Masih Kosong</h6>
                                        <p class="text-muted small mb-3">Belum ada berkas laporan harian yang dicatat untuk sektor ini.</p>
                                        <a href="{{ route('reports.create', ['sektor' => $key]) }}" class="btn btn-sm text-white fw-bold px-3.5 py-2 rounded-3 shadow-2xs btn-bjb-primary">
                                            <i class="bi bi-plus-lg me-1"></i> Buat Laporan Sektor {{ $sector['name'] }}
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endforeach

    </div>

</div>

<style>
    body {
        background-color: #f8fafc !important;
    }

    /* BJB BRAND BUTTON */
    .btn-bjb-primary {
        background-color: #0056a3 !important;
        border: none;
    }
    .btn-bjb-primary:hover {
        background-color: #003d75 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 86, 163, 0.25) !important;
    }

    .btn-outline-success:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15) !important;
    }

    /* FOLDER CARD STYLING (CLEAN & SPACIOUS GRID) */
    .folder-card {
        background-color: #f8fafc !important;
        border: 1.5px solid #e2e8f0 !important;
        border-radius: 14px !important;
        padding: 14px 14px !important;
        transition: all 0.2s ease-in-out !important;
        cursor: pointer;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        min-height: 108px !important;
    }

    .folder-card:hover {
        background-color: #ffffff !important;
        border-color: #94a3b8 !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06) !important;
    }

    .folder-card.active {
        background-color: #ffffff !important;
        border: 2px solid #0056a3 !important;
        box-shadow: 0 6px 20px rgba(0, 86, 163, 0.15) !important;
        transform: translateY(-2px) !important;
    }

    .folder-card.active .folder-name {
        color: #0056a3 !important;
        font-weight: 800 !important;
    }

    .folder-icon-circle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .folder-name {
        font-size: 13.5px;
        letter-spacing: -0.2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .folder-meta {
        font-size: 11px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bg-primary-subtle {
        background-color: rgba(0, 86, 163, 0.1) !important;
        color: #0056a3 !important;
    }

    /* TABLE STYLING */
    tr.transition-all:hover {
        background-color: #f8fafc !important;
    }

    .shadow-2xs {
        box-shadow: 0 2px 4px rgba(0,0,0,0.03) !important;
    }

    .table th {
        border: none !important;
    }

    .table td {
        border-color: #f1f5f9 !important;
    }
</style>
@endsection