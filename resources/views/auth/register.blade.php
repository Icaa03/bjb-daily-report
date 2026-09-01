@extends('layouts.app')

@section('content')
<div class="container-fluid p-0" style="min-height: 100vh; margin-top: -24px; margin-bottom: -24px;">
    <div class="row g-0" style="min-height: 100vh;">
        
        <div class="col-lg-7 d-none d-lg-flex flex-column justify-content-between p-5 position-relative" 
             style="background: linear-gradient(135deg, #0056a3 0%, #003d75 100%); color: white; overflow: hidden;">
            
            <div class="position-absolute" style="width: 500px; height: 500px; background: rgba(255,255,255,0.03); border-radius: 50%; top: -10%; left: -10%;"></div>
            <div class="position-absolute" style="width: 400px; height: 400px; background: rgba(255,215,0,0.05); border-radius: 50%; bottom: -5%; right: -5%;"></div>

            <div class="brand-logo d-inline-flex align-items-center justify-content-center rounded-3 shadow-sm bg-white" 
                 style="width: 160px; height: 65px; z-index: 2; overflow: hidden; position: relative; padding-bottom: 5px;">
                <img src="{{ asset('images/logo-bjb.png.webp') }}" alt="Logo Bank BJB" 
                     style="height: 100%; width: 100%; object-fit: contain; mix-blend-mode: multiply; transform: scale(1.7); image-rendering: -webkit-optimize-contrast;">
            </div>

            <div class="my-auto" style="max-width: 550px; z-index: 2;">
                <span class="badge bg-warning text-dark fw-bold mb-3 px-3 py-2 text-uppercase tracking-wider">Pendaftaran Akun Baru</span>
                <h1 class="display-4 fw-black mb-3 text-white" style="line-height: 1.2; font-weight: 800;">
                    Bergabung ke Sistem Laporan Harian BJB
                </h1>
                <p class="lead opacity-75" style="font-size: 1.1rem;">
                    Daftarkan identitas Anda untuk mulai mengisi laporan harian sebagai Account Officer atau memvalidasi data sebagai Pemimpin KCP.
                </p>
            </div>

            <div class="opacity-50 text-sm" style="z-index: 2;">
                &copy; {{ date('Y') }} PT Bank Pembangunan Daerah Jawa Barat dan Banten Tbk. All rights reserved.
            </div>
        </div>

        <div class="col-lg-5 d-flex align-items-center justify-content-center bg-light p-4 p-sm-5">
            <div class="w-100" style="max-width: 450px;">
                
                <div class="text-center d-lg-none mb-4">
                    <div class="bg-white d-inline-flex mb-3 shadow-sm rounded-3" 
                         style="width: 140px; height: 55px; overflow: hidden; position: relative; align-items: center; justify-content: center; padding-bottom: 4px;">
                        <img src="{{ asset('images/logo-bjb.png.webp') }}" alt="Logo Bank BJB" 
                               style="height: 100%; width: 100%; object-fit: contain; mix-blend-mode: multiply; transform: scale(1.6); image-rendering: -webkit-optimize-contrast;">
                    </div>
                    <h4 class="fw-bold text-dark">Registrasi Akun Baru</h4>
                </div>

                <div class="card border-0 shadow-lg rounded-4 p-4 p-sm-5 bg-white">
                    <div class="mb-4">
                        <h3 class="fw-bold text-dark mb-1">Buat Akun</h3>
                        <p class="text-muted small">Lengkapi data untuk akses web privat</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-person"></i></span>
                                <input id="name" type="text" class="form-control bg-light border-0 p-2 @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nama Lengkap Anda" style="font-size: 14px;">
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-muted text-uppercase">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-envelope"></i></span>
                                <input id="email" type="email" class="form-control bg-light border-0 p-2 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@bankbjb.co.id" style="font-size: 14px;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label small fw-bold text-muted text-uppercase">Pilih Jabatan (Role)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-briefcase"></i></span>
                                <select id="role" class="form-select bg-light border-0 p-2 @error('role') is-invalid @enderror" name="role" required style="font-size: 14px;">
                                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                                    <!-- VALUE JABATAN DISINKRONKAN DENGAN FORMAT HURUF DATABASE -->
                                    <option value="AO" {{ old('role') == 'AO' ? 'selected' : '' }}>Account Officer (AO)</option>
                                    <option value="Pemimpin KCP" {{ old('role') == 'Pemimpin KCP' ? 'selected' : '' }}>Pemimpin KCP</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold text-muted text-uppercase">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input id="password" type="password" class="form-control bg-light border-0 p-2 @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" style="font-size: 14px;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label small fw-bold text-muted text-uppercase">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                <input id="password-confirm" type="password" class="form-control bg-light border-0 p-2" 
                                       name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" style="font-size: 14px;">
                            </div>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn w-100 py-2.5 rounded-3 fw-bold text-white border-0 shadow-sm transition-all" 
                                    style="background: #0056a3; font-size: 15px;">
                                Daftar Akun Baru &nbsp;<i class="bi bi-check-circle"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #0056a3;">Masuk Aplikasi</a></p>
                </div>

            </div>
        </div>

    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .btn:hover {
        background: #003d75 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(0, 86, 163, 0.15) !important;
        border: 1px solid #0056a3 !important;
    }
</style>
@endsection