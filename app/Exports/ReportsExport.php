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
    protected $namaAo;

    /**
     * Menangkap filter tanggal dan namaAo
     */
    public function __construct($tanggal = null, $namaAo = null)
    {
        $this->tanggal = $tanggal;
        $this->namaAo = $namaAo;
    }

    /**
    * Mengambil data dari database dengan filter yang fleksibel
    */
    public function collection()
    {
        $query = DailyReport::query();

        // FIX AMAN: Karena 1 akun dipakai bersama oleh semua AO, kita nonaktifkan filter namaAo.
        // Dengan begini, semua laporan yang diinput oleh AO mana pun akan otomatis ditarik.
        /*
        if ($this->namaAo) {
            $query->where('nama_ao', $this->namaAo);
        }
        */

        // Filter tanggal tetap dibiarkan aktif untuk kebutuhan ekspor Pemimpin KCP
        if ($this->tanggal) {
            $query->where('tanggal_laporan', $this->tanggal);
        }

        return $query->latest()->get();
    }

    /**
    * Memetakan data agar masuk ke kolomnya masing-masing
    */
    public function map($report): array
    {
        return [
            (string) $report->tanggal_laporan,
            (string) ($report->nama_ao ?? $report->user->name ?? '-'),
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
        
        // Antisipasi jika data kosong agar border tidak rusak
        if ($totalBaris < 2) {
            $totalBaris = 2;
        }
        
        $rangeHeader = 'A1:F1'; 
        $rangeIsiData = 'A2:F' . $totalBaris; 
        $rangeTabelLengkap = 'A1:F' . $totalBaris; 

        // 1. ATUR GAYA FONT GLOBAL & UKURAN ISI DATA (FONT 12)
        $sheet->getStyle($rangeTabelLengkap)->getFont()->setName('Times New Roman');
        $sheet->getStyle($rangeIsiData)->getFont()->setSize(12);

        // 2. KUSTOMISASI KHUSUS BARIS JUDUL (HEADER - BARIS 1 - FONT 14 & BOLD)
        $sheet->getStyle($rangeHeader)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14, 
                'color' => ['argb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '87CEEB'], // Warna Biru Langit
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, 
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 3. OTOMATIS MEMBUAT GARIS BORDER (Kotak-kotak penuh)
        $sheet->getStyle($rangeTabelLengkap)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], 
                ],
            ],
        ]);
    }
}