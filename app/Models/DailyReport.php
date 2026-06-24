<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    // Memberitahu Laravel nama tabel yang digunakan
    protected $table = 'daily_reports';

    // Daftarkan kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'nama_ao',
        'jabatan',
        'sektor',
        'jumlah_nasabah',
        'nominal',
        'tanggal_laporan',
        'keterangan',
        'status',
    ];

    /**
     * Relasi ke data User (jika kamu menyimpan user_id di database)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // sesuaikan jika ada kolom user_id
    }
}