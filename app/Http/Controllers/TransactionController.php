<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('category')->latest()->get();
        $categories = Category::all();

        return view('transaksi', compact('transactions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trans_date' => 'required|date',
            'desc' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Transaction::create($validated);

        return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }
}
