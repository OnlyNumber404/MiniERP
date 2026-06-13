<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('category')->latest('trans_date');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('trans_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('trans_date', '<=', $request->end_date);
        }

        if ($request->filled('type')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        $transactions = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('transaksi', compact('transactions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trans_date' => 'required|date',
            'desc' => 'required|string|max:255',
            'path' => 'nullable|mimes:png,jpg,jpeg,pdf|max:2048',
            'amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('path')) {
            $validated['path'] = $request->file('path')->store('transactions');
        }

        Transaction::create($validated);

        return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function delete(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function show(Transaction $transaction)
    {
        if (! $transaction->path || ! Storage::disk('local')->exists($transaction->path)) {
            abort(404);
        }

        return view('transactions.show', compact('transaction'));
    }

    public function file(Transaction $transaction)
    {
        if (! $transaction->path || ! Storage::disk('local')->exists($transaction->path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($transaction->path));
    }
}
