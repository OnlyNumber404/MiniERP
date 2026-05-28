<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
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
            $transaction->trans_date,
            $transaction->category->cat_name ?? '-',
            $transaction->category ? ($transaction->category->type == 'income' ? 'Pemasukan' : 'Pengeluaran') : '-',
            $transaction->desc,
            $transaction->amount,
        ];
    }
}
