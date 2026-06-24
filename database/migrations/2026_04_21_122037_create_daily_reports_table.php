<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fungsi ini untuk membuat tabel di database.
     */
    public function up(): void
    {
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ao'); // Nama Account Officer
            $table->string('jabatan'); // Jabatan AO
            
            // Enum membatasi pilihan agar data di database konsisten sesuai sektor di BJB
            $table->enum('sektor', ['Konsumer', 'Ritel', 'Digi', 'Tabungan', 'ATM']); 
            
            $table->integer('jumlah_nasabah'); // Jumlah NOA (Number of Account)
            
            // Decimal(15,2) sangat tepat untuk nominal uang/plafon kredit perbankan
           $table->bigInteger('nominal'); 
            
            $table->date('tanggal_laporan'); 
            $table->text('keterangan')->nullable(); // Boleh kosong
            
            // Status laporan untuk alur birokrasi (Validasi Pimpinan)
            $table->enum('status', ['pending', 'approved', 'revised'])->default('pending');
            
            $table->timestamps(); // create_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     * Fungsi ini untuk menghapus tabel jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};