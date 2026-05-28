<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has(['start_date', 'end_date'])) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $fileName = 'laporan-keuangan-'.$request->start_date.'-ke-'.$request->end_date.'.xlsx';

            return Excel::download(
                new TransactionsExport($request->start_date, $request->end_date),
                $fileName
            );
        }

        return view('report');
    }
}
