<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Edit Laporan Harian</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reports.update', $report->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Account Officer (AO)</label>
                                <select name="nama_ao" class="form-select" required>
                                    <option value="Anisa Cikal" {{ $report->nama_ao == 'Anisa Cikal' ? 'selected' : '' }}>Anisa Cikal</option>
                                    <option value="Feri Prasetio" {{ $report->nama_ao == 'Feri Prasetio' ? 'selected' : '' }}>Feri Prasetio</option>
                                    <option value="Yanuar Aditya" {{ $report->nama_ao == 'Yanuar Aditya' ? 'selected' : '' }}>Yanuar Aditya</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ $report->jabatan }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sektor</label>
                                <select name="sektor" class="form-select" required>
                                    <option value="Konsumer" {{ $report->sektor == 'Konsumer' ? 'selected' : '' }}>Konsumer</option>
                                    <option value="Ritel" {{ $report->sektor == 'Ritel' ? 'selected' : '' }}>Ritel</option>
                                    <option value="Digi" {{ $report->sektor == 'Digi' ? 'selected' : '' }}>Digi</option>
                                    <option value="Tabungan" {{ $report->sektor == 'Tabungan' ? 'selected' : '' }}>Tabungan</option>
                                    <option value="ATM" {{ $report->sektor == 'ATM' ? 'selected' : '' }}>ATM</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah Nasabah (NOA)</label>
                                <input type="number" name="jumlah_nasabah" class="form-control" min="0" value="{{ $report->jumlah_nasabah }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nominal (Rupiah)</label>
                                <input type="number" name="nominal" class="form-control" value="{{ intval($report->nominal) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal Laporan</label>
                                <input type="date" name="tanggal_laporan" class="form-control" value="{{ $report->tanggal_laporan }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3">{{ $report->keterangan }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update Laporan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>