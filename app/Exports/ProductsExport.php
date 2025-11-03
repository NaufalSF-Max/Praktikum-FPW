<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Modifikasi: Pilih hanya kolom yang kita inginkan
        return product::select(
            'id',
            'product_name',
            'unit',
            'type',
            'information',
            'qty',
            'producer'
        )->get();
    }

    /**
     * Menambahkan baris header untuk tabel.
     */
    public function headings(): array
    {
        // Ini akan menjadi baris 5 (karena kita mulai di A5)
        return [
            'ID',
            'Product Name',
            'Unit',
            'Type',
            'Information',
            'Quantity',
            'Producer',
        ];
    }

    /**
     * Memulai tabel data di sel A5.
     */
    public function startCell(): string
    {
        return 'A5';
    }

    /**
     * Mendaftarkan event untuk menambahkan judul kustom.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Mendapatkan objek sheet
                $sheet = $event->sheet->getDelegate();
                
                // Tentukan rentang sel untuk merge (A sampai G, 7 kolom)
                $mergeRange = 'A1:G1';
                $mergeRange2 = 'A2:G2';
                $mergeRange3 = 'A3:G3';

                // --- JUDUL UTAMA (PT. Jurnal Karya) ---
                $sheet->mergeCells($mergeRange);
                $sheet->setCellValue('A1', 'PT. Jurnal Karya (Contoh)');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // --- SUB JUDUL (LAPORAN) ---
                $sheet->mergeCells($mergeRange2);
                $sheet->setCellValue('A2', 'Laporan Penjualan Sederhana'); // Sesuai contoh
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // --- PERIODE ---
                $sheet->mergeCells($mergeRange3);
                $sheet->setCellValue('A3', 'Periode ' . date('F Y')); // Sesuai contoh
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // (Opsional) Memberi style BOLD pada baris Headings (A5:G5)
                $sheet->getStyle('A5:G5')->getFont()->setBold(true);
            }
        ];
    }
}
