@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            
            <div class="mb-4">
                <a href="{{ route('reports.index') }}" class="text-decoration-none text-muted small fw-bold d-inline-flex align-items-center gap-1 transition-all hover-translate">
                    <i class="bi bi-arrow-left-short fs-5"></i> Kembali ke Workspace
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                
                <div class="p-4 text-white d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #0056a3 0%, #003d75 100%);">
                    <div class="rounded-3 p-2.5 bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-pencil-square fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold m-0" style="font-weight: 800; letter-spacing: -0.5px;">Form Edit Laporan Harian</h4>
                        <p class="m-0 small opacity-75">Perbarui data produktivitas dan berkas laporan staf Account Officer.</p>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Nama Account Officer (AO)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-fill"></i></span>
                                    <select name="nama_ao" class="form-select bg-light border-start-0 fw-semibold text-dark" required>
                                        <option value="Anisa Cikal" {{ $report->nama_ao == 'Anisa Cikal' ? 'selected' : '' }}>Anisa Cikal</option>
                                        <option value="Feri Prasetio" {{ $report->nama_ao == 'Feri Prasetio' ? 'selected' : '' }}>Feri Prasetio</option>
                                        <option value="Yanuar Aditya" {{ $report->nama_ao == 'Yanuar Aditya' ? 'selected' : '' }}>Yanuar Aditya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Jabatan Staf</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-briefcase-fill"></i></span>
                                    <input type="text" name="jabatan" class="form-control bg-light border-start-0 fw-semibold" value="{{ old('jabatan', $report->jabatan) }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Sektor Produk</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-pie-chart-fill"></i></span>
                                    <select name="sektor" class="form-select bg-light border-start-0 fw-semibold" required>
                                        <option value="Konsumer" {{ $report->sektor == 'Konsumer' ? 'selected' : '' }}>🛍️ Sektor Konsumer</option>
                                        <option value="Ritel" {{ $report->sektor == 'Ritel' ? 'selected' : '' }}>🏙️ Sektor Ritel</option>
                                        <option value="Digi" {{ $report->sektor == 'Digi' ? 'selected' : '' }}>📱 Sektor Digi</option>
                                        <option value="Tabungan" {{ $report->sektor == 'Tabungan' ? 'selected' : '' }}>💳 Sektor Tabungan</option>
                                        <option value="ATM" {{ $report->sektor == 'ATM' ? 'selected' : '' }}>🏧 Sektor ATM</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Jumlah Nasabah (NOA)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-people-fill"></i></span>
                                    <input type="number" name="jumlah_nasabah" class="form-control bg-light border-start-0 fw-bold" min="0" value="{{ $report->jumlah_nasabah }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Nominal (Rupiah)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 fw-bold text-secondary" style="font-size: 13px;">Rp</span>
                                    <input type="number" name="nominal" class="form-control bg-light border-start-0 fw-bold text-dark" value="{{ intval($report->nominal) }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Tanggal Laporan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-event-fill"></i></span>
                                    <input type="date" name="tanggal_laporan" class="form-control bg-light border-start-0 fw-semibold text-secondary" value="{{ old('tanggal_laporan', $report->tanggal_laporan) }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-secondary small text-uppercase" style="letter-spacing: 0.5px;">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="form-control bg-light p-3" rows="4" placeholder="Tulis rincian atau catatan laporan harian di sini...">{{ $report->keterangan }}</textarea>
                            </div>
                        </div>

                        <div class="mt-5 d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('reports.index') }}" class="btn btn-light px-4 py-2.5 rounded-3 fw-bold text-secondary" style="font-size: 14px;">Batal</a>
                            <button type="submit" class="btn text-white px-5 py-2.5 rounded-3 fw-bold shadow-md transition-all btn-bjb" style="background: #0056a3; font-size: 14px;">
                                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f8fafc !important;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0056a3 !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 86, 163, 0.15) !important;
        background-color: #ffffff !important;
    }
    .input-group:focus-within .input-group-text {
        border-color: #0056a3 !important;
        color: #0056a3 !important;
    }
    .btn-bjb:hover {
        background: #003d75 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 86, 163, 0.25) !important;
    }
    .hover-translate:hover {
        transform: translateX(-3px);
        color: #0056a3 !important;
    }
</style>
@endsection