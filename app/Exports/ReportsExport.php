<?php

namespace App\Exports;

use App\Models\DailyReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $tanggal;

    // Menangkap tanggal filter dari controller
    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    /**
    * Mengambil data dari database berdasarkan tanggal laporan
    */
    public function collection()
    {
        return DailyReport::where('tanggal_laporan', $this->tanggal)->latest()->get();
    }

    /**
    * Memetakan data agar masuk ke kolomnya masing-masing
    */
    public function map($report): array
    {
        return [
            (string) $report->tanggal_laporan,
            (string) $report->nama_ao,
            (string) $report->sektor,
            (string) 'Rp ' . number_format($report->nominal, 0, ',', '.'),
            (string) ($report->keterangan ?? '-'),
            (string) strtoupper($report->status ?? 'PENDING'),
        ];
    }

    /**
    * Mengatur judul Header baris pertama di Excel
    */
    public function headings(): array
    {
        return [
            'Tanggal Laporan',
            'Nama AO',
            'Sektor',
            'Nominal',
            'Keterangan',
            'Status'
        ];
    }

    /**
    * Mengatur Perataan Tengah, Ukuran Font Berbeda (14 & 12), Warna, dan Garis Tabel
    */
    public function styles(Worksheet $sheet)
    {
        // Hitung total baris data yang ada (+ 1 untuk baris judul header)
        $totalBaris = $this->collection()->count() + 1;
        
        $rangeHeader = 'A1:F1'; // Range khusus untuk baris judul
        $rangeIsiData = 'A2:F' . $totalBaris; // SUDAH DIPERBAIKI: variabel tanpa spasi
        $rangeTabelLengkap = 'A1:F' . $totalBaris; // Range untuk keseluruhan tabel

        // 1. ATUR GAYA FONT GLOBAL & UKURAN ISI DATA (FONT 12)
        $sheet->getStyle($rangeTabelLengkap)->getFont()->setName('Times New Roman');
        $sheet->getStyle($rangeIsiData)->getFont()->setSize(12);

        // 2. KUSTOMISASI KHUSUS BARIS JUDUL (HEADER - BARIS 1 - FONT 14 & BOLD)
        $sheet->getStyle($rangeHeader)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14, // Ukuran font judul 14
                'color' => ['argb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '87CEEB'], // Warna Biru Langit
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Huruf bergeser rata tengah
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 3. OTOMATIS MEMBUAT GARIS BORDER (Kotak-kotak penuh)
        $sheet->getStyle($rangeTabelLengkap)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Garis warna hitam tipis rapi
                ],
            ],
        ]);
    }
}