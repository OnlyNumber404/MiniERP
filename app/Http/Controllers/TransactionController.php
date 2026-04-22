<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionController extends Controller
{
    public function Transaction(){
        $transactions = Transaction::all();

        return view('transactions', compact('transactions'));
    }
}