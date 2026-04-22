<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'total_saldo' => 10000000000,
            'pemasukan' => 1000000,
            'pengeluaran' => 50000,
            'recent_transaction' => [
                ['tanggal' => '01 Mar 2026', 'deskripsi' => 'Gaji Bulanan', 'nominal' => 500000, 'kategori' => 'Gaji', 'tipe' => 'income'],
                ['tanggal' => '02 Mar 2026', 'deskripsi' => 'Makan nasi padang', 'nominal' => 15000, 'kategori' => 'Makan', 'tipe' => 'expense'],
                ['tanggal' => '03 Mar 2026', 'deskripsi' => 'Donasi buat Wilbert laptop baru', 'nominal' => 1000000, 'kategori' => 'Sumbangan', 'tipe' => 'expense']
            ]
        ];
        return view('dashboard', $data);
    }
    
}