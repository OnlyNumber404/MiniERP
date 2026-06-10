<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        @page {
            margin: 30px;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333333;
            line-height: 1.4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .text-right { text-align: right !important; }
        .text-center { text-align: center !important; }
        .text-bold { font-weight: bold; }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .report-period {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        .items-table th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .items-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .total-section {
            margin-top: 20px;
        }
        .total-table {
            width: 40%;
            float: right;
        }
        .total-table td {
            padding: 5px;
            border: none;
        }
        .grand-total {
            font-weight: bold;
            background-color: #f2f2f2;
            border-top: 1px solid #333 !important;
        }
        .footer {
            margin-top: 30px;
            text-align: left;
            font-size: 9px;
            color: #777;
        }
        .income { color: #27ae60; }
        .expense { color: #c0392b; }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="company-name">{{ Auth::user()->name }}</div>
                </td>
                <td width="50%" class="text-right">
                    Dicetak pada: {{ date('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="report-title">Laporan Keuangan</div>
    <div class="report-period">
        Periode: {{ \Carbon\Carbon::parse($start_date)->format('d F Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d F Y') }}
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Kategori</th>
                <th width="15%">Jenis</th>
                <th width="30%">Deskripsi</th>
                <th width="15%" class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $totalIncome = 0;
                $totalExpense = 0;
            @endphp
            @forelse($transactions as $index => $trans)
                @php
                    if($trans->category->type == 'income') {
                        $totalIncome += $trans->amount;
                    } else {
                        $totalExpense += $trans->amount;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($trans->trans_date)->format('d/m/Y') }}</td>
                    <td>{{ $trans->category->cat_name ?? '-' }}</td>
                    <td class="{{ $trans->category->type == 'income' ? 'income' : 'expense' }}">
                        {{ $trans->category->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </td>
                    <td>{{ $trans->desc }}</td>
                    <td class="text-right">
                        Rp {{ number_format($trans->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total-section clearfix">
        <table class="total-table">
            <tr>
                <td>Total Pemasukan:</td>
                <td class="text-right income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran:</td>
                <td class="text-right expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            </tr>
            <tr class="grand-total">
                <td>Saldo Akhir:</td>
                <td class="text-right text-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh sistem MiniERP.</p>
    </div>
</body>
</html>
