<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $pemasukan = Transaction::whereHas('category', function ($q) {
            $q->where('type', 'income');
        })->sum('amount');

        $pengeluaran = Transaction::whereHas('category', function ($q) {
            $q->where('type', 'expense');
        })->sum('amount');

        // Line Chart Data: 30 transaksi terakhir berdasarkan trans_date
        $recentDates = Transaction::orderBy('trans_date', 'desc')
            ->get(['trans_date'])
            ->pluck('trans_date')
            ->map(fn ($date) => \Carbon\Carbon::parse($date)->format('Y-m-d'))
            ->unique()
            ->take(30)
            ->sort()
            ->values();

        if ($recentDates->isEmpty()) {
            $recentDates->push(now()->format('Y-m-d'));
        }

        $transactions = Transaction::with('category')
            ->whereDate('trans_date', '>=', $recentDates->first())
            ->whereDate('trans_date', '<=', $recentDates->last())
            ->get();

        $lineDates = [];
        $lineIncome = [];
        $lineExpense = [];

        foreach ($recentDates as $dateString) {
            $lineDates[] = \Carbon\Carbon::parse($dateString)->format('d M');

            $dailyTransactions = $transactions->filter(function ($t) use ($dateString) {
                return \Carbon\Carbon::parse($t->trans_date)->format('Y-m-d') === $dateString;
            });

            $lineIncome[] = $dailyTransactions->filter(fn ($t) => $t->category && $t->category->type === 'income')->sum('amount');
            $lineExpense[] = $dailyTransactions->filter(fn ($t) => $t->category && $t->category->type === 'expense')->sum('amount');
        }

        // Pie Chart Data: Categories
        $pieLabels = [];
        $pieData = [];
        $pieColors = [];

        $colors = [
            '#48bb78', '#f56565', '#4299e1', '#ecc94b', '#ed8936', '#9f7aea', '#38b2ac', '#ed64a6', '#667eea',
            '#38a169', '#e53e3e', '#3182ce', '#d69e2e', '#dd6b20', '#805ad5', '#319795', '#d53f8c', '#5a67d8',
        ];

        $categoriesStat = Transaction::with('category')
            ->selectRaw('category_id, sum(amount) as total')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->get();

        foreach ($categoriesStat as $index => $stat) {
            if ($stat->category) {
                $pieLabels[] = $stat->category->cat_name.($stat->category->type == 'income' ? ' (Pemasukan)' : ' (Pengeluaran)');
                $pieData[] = $stat->total;
                $pieColors[] = $stat->category->type == 'income' ? $colors[$index % count($colors)] : $colors[($index + 1) % count($colors)];
            }
        }

        $data = [
            'total_saldo' => $pemasukan - $pengeluaran,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'recent_transaction' => Transaction::with('category')->latest('trans_date')->take(5)->get(),
            'lineDates' => $lineDates,
            'lineIncome' => $lineIncome,
            'lineExpense' => $lineExpense,
            'pieLabels' => $pieLabels,
            'pieData' => $pieData,
            'pieColors' => $pieColors,
        ];

        return view('dashboard', $data);
    }
}
