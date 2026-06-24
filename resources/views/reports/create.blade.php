@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="badge bg-primary-light text-primary fw-bold px-3 py-2 text-uppercase mb-2 d-inline-block" style="background-color: rgba(0, 86, 163, 0.1); font-size: 11px; tracking-wider: 1px;">
                <i class="bi bi-plus-circle-fill"></i> Data Entry
            </span>
            <h2 class="fw-bold text-dark m-0" style="font-weight: 800; letter-spacing: -0.5px;">Tambah Laporan Harian</h2>
            <p class="text-muted small m-0 mt-1">Silakan lengkapi formulir di bawah dengan data validasi yang akurat.</p>
        </div>
        
        <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3 fw-bold shadow-2xs d-inline-flex align-items-center gap-1.5 transition-all" style="font-size: 14px;">
            <i class="bi bi-arrow-left-short fs-5"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                
                <div class="p-4 text-white d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #0056a3 0%, #003d75 100%);">
                    <i class="bi bi-file-earmark-medical fs-4"></i>
                    <h5 class="m-0 fw-bold" style="letter-spacing: 0.5px;">Formulir Input Dokumen Laporan</h5>
                </div>

                <div class="card-body p-4 p-sm-5 bg-white">
                    <form method="POST" action="{{ route('reports.store') }}">
                        @csrf

                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="nama_ao" class="form-label small fw-bold text-muted text-uppercase">Nama Account Officer (AO)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-person-badge"></i></span>
                                    <select id="nama_ao" class="form-select bg-light border-0 p-2.5 @error('nama_ao') is-invalid @enderror" name="nama_ao" required style="font-size: 14px;">
                                        <option value="">-- Pilih Nama AO --</option>
                                        <option value="Anisa Cikal" {{ old('nama_ao') == 'Anisa Cikal' ? 'selected' : '' }}>Anisa Cikal</option>
                                        <option value="Ali Rohman" {{ old('nama_ao') == 'Ali Rohman' ? 'selected' : '' }}>Ali Rohman</option>
                                        <option value="Amelia Herlina" {{ old('nama_ao') == 'Amelia Herlina' ? 'selected' : '' }}>Amelia Herlina</option>
                                        <option value="Anggun Pressyane Rusmana" {{ old('nama_ao') == 'Anggun Pressyane Rusmana' ? 'selected' : '' }}>Anggun Pressyane Rusmana</option>
                                        <option value="Anton Lukman" {{ old('nama_ao') == 'Anton Lukman' ? 'selected' : '' }}>Anton Lukman</option>
                                        <option value="Billy Priyandi Mufti" {{ old('nama_ao') == 'Billy Priyandi Mufti' ? 'selected' : '' }}>Billy Priyandi Mufti</option>
                                        <option value="Feri Prasetio" {{ old('nama_ao') == 'Feri Prasetio' ? 'selected' : '' }}>Feri Prasetio</option>
                                        <option value="Fian Ginanjar" {{ old('nama_ao') == 'Fian Ginanjar' ? 'selected' : '' }}>Fian Ginanjar</option>
                                        <option value="Galih Gumbira" {{ old('nama_ao') == 'Galih Gumbira' ? 'selected' : '' }}>Galih Gumbira</option>
                                        <option value="Muhammad Faizal Haq" {{ old('nama_ao') == 'Muhammad Faizal Haq' ? 'selected' : '' }}>Muhammad Faizal Haq</option>
                                        <option value="Resti Ramdani" {{ old('nama_ao') == 'Resti Ramdani' ? 'selected' : '' }}>Resti Ramdani</option>
                                        <option value="Rizalludin" {{ old('nama_ao') == 'Rizalludin' ? 'selected' : '' }}>Rizalludin</option>
                                        <option value="Siti Fauziah Nurdini" {{ old('nama_ao') == 'Siti Fauziah Nurdini' ? 'selected' : '' }}>Siti Fauziah Nurdini</option>
                                        <option value="Yanuar Aditya" {{ old('nama_ao') == 'Yanuar Aditya' ? 'selected' : '' }}>Yanuar Aditya</option>
                                        <option value="Yeni Amelia" {{ old('nama_ao') == 'Yeni Amelia' ? 'selected' : '' }}>Yeni Amelia</option>
                                    </select>
                                    @error('nama_ao')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="jabatan" class="form-label small fw-bold text-muted text-uppercase">Jabatan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-briefcase"></i></span>
                                    <input id="jabatan" type="text" class="form-control bg-light border-0 p-2.5 @error('jabatan') is-invalid @enderror" 
                                           name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Staff Funding" required style="font-size: 14px;">
                                    @error('jabatan')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="sektor" class="form-label small fw-bold text-muted text-uppercase">Sektor</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-grid-1x2"></i></span>
                                    <select id="sektor" class="form-select bg-light border-0 p-2.5 @error('sektor') is-invalid @enderror" name="sektor" required style="font-size: 14px;">
                                        <option value="">-- Pilih Sektor --</option>
                                        <option value="Konsumer" {{ old('sektor') == 'Konsumer' ? 'selected' : '' }}>Konsumer</option>
                                        <option value="Ritel" {{ old('sektor') == 'Ritel' ? 'selected' : '' }}>Ritel</option>
                                        <option value="Digi" {{ old('sektor') == 'Digi' ? 'selected' : '' }}>Digi</option>
                                        <option value="Tabungan" {{ old('sektor') == 'Tabungan' ? 'selected' : '' }}>Tabungan</option>
                                        <option value="ATM" {{ old('sektor') == 'ATM' ? 'selected' : '' }}>ATM</option>
                                    </select>
                                    @error('sektor')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="jumlah_nasabah" class="form-label small fw-bold text-muted text-uppercase">Jumlah Nasabah (NOA)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-people"></i></span>
                                    <input id="jumlah_nasabah" type="number" min="0" class="form-control bg-light border-0 p-2.5 @error('jumlah_nasabah') is-invalid @enderror" 
                                           name="jumlah_nasabah" value="{{ old('jumlah_nasabah', 0) }}" placeholder="0" required style="font-size: 14px;">
                                    @error('jumlah_nasabah')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="nominal" class="form-label small fw-bold text-muted text-uppercase">Nominal (Rupiah)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold text-muted" style="font-size: 13px;">Rp</span>
                                    <input id="nominal" type="number" min="0" class="form-control bg-light border-0 p-2.5 @error('nominal') is-invalid @enderror" 
                                           name="nominal" value="{{ old('nominal') }}" placeholder="Contoh: 200000000" required style="font-size: 14px;">
                                    @error('nominal')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="tanggal_laporan" class="form-label small fw-bold text-muted text-uppercase">Tanggal Laporan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-calendar-event"></i></span>
                                    <input id="tanggal_laporan" type="date" class="form-control bg-light border-0 p-2.5 @error('tanggal_laporan') is-invalid @enderror" 
                                           name="tanggal_laporan" value="{{ old('tanggal_laporan') }}" required style="font-size: 14px;">
                                    @error('tanggal_laporan')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="keterangan" class="form-label small fw-bold text-muted text-uppercase">Keterangan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted align-items-start pt-2.5"><i class="bi bi-chat-left-text"></i></span>
                                    <textarea id="keterangan" class="form-control bg-light border-0 p-2.5 @error('keterangan') is-invalid @enderror" 
                                              name="keterangan" rows="3" placeholder="Catatan tambahan (opsional)" style="font-size: 14px;">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-2 border-top border-light">
                            <button type="submit" class="btn text-white px-5 py-2.5 rounded-3 fw-bold shadow-sm d-inline-flex align-items-center gap-2 btn-bjb transition-all" style="background: #0056a3; font-size: 15px;">
                                <i class="bi bi-cloud-arrow-up-fill"></i> Simpan Laporan
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
    .btn-bjb:hover {
        background: #003d75 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 86, 163, 0.2) !important;
    }
    .btn-outline-secondary:hover {
        transform: translateY(-1px);
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 86, 163, 0.15) !important;
        border: 1px solid #0056a3 !important;
    }
    .input-group-text {
        border-top-left-radius: 0.5rem !important;
        border-bottom-left-radius: 0.5rem !important;
    }
    .form-control, .form-select {
        border-top-right-radius: 0.5rem !important;
        border-bottom-right-radius: 0.5rem !important;
    }
    .shadow-2xs {
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
    }
</style>
@endsection