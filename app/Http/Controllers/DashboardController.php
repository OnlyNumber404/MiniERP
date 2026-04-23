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

        $data = [
            'total_saldo' => $pemasukan - $pengeluaran,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'recent_transaction' => Transaction::with('category')->latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
