<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    use Exportable;

    public function __construct(
        protected string $startDate,
        protected string $endDate
    ) {}

    public function query()
    {
        return Transaction::query()
            ->with('category')
            ->whereBetween('trans_date', [$this->startDate, $this->endDate])
            ->orderBy('trans_date', 'asc');
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kategori',
            'Jenis',
            'Deskripsi',
            'Jumlah',
        ];
    }

    public function map($transaction): array
    {
        return [
            // Konversi string tanggal menjadi format Tanggal Excel
            Date::dateTimeToExcel(Carbon::parse($transaction->trans_date)),
            $transaction->category->cat_name ?? '-',
            $transaction->category ? ($transaction->category->type == 'income' ? 'Pemasukan' : 'Pengeluaran') : '-',
            $transaction->desc,
            // Pastikan jumlah (amount) dalam bentuk angka numerik (float/int) bukan string
            (float) $transaction->amount,
        ];
    }

    // Mengatur format spesifik untuk kolom tertentu (Tanggal & Rupiah)
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Format kolom A (Tanggal) menjadi dd/mm/yyyy
            'E' => '"Rp"#,##0_-',                      // Format kolom E (Jumlah) menjadi Rupiah (Misal: Rp 150.000)
        ];
    }

    // Mengatur gaya (Style) untuk Worksheet Excel
    public function styles(Worksheet $sheet)
    {
        // 1. Styling untuk Baris Pertama (Headings)
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // Warna teks putih
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'], // Warna background hijau (Material Green)
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 2. Memberikan border ke seluruh sel yang ada datanya
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:E' . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Border warna hitam
                ],
            ],
        ]);

        // 3. Meratakan teks ke tengah (Center) untuk kolom Kategori (B) dan Jenis (C)
        $sheet->getStyle('B2:C' . $highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Opsional: Atur tinggi baris pertama
        $sheet->getRowDimension(1)->setRowHeight(25);
    }
}
