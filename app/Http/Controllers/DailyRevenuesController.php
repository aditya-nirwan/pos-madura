<?php

namespace App\Http\Controllers;

use App\Models\DailyRevenues;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DailyRevenuesController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $transactions = Transaction::whereDate('created_at', $date)->get();

        $income = $transactions->sum('total_cost');
        $totalTax = $transactions->sum('total_tax');

        return view('daily_revenues.show', compact('date', 'transactions', 'income', 'totalTax'));
    }

    public function store(Request $request)
    {
        $date = $request->input('date');

        $transactions = Transaction::whereDate('created_at', $date)->get();
        $income = $transactions->sum('total_cost');
        $totalTax = $transactions->sum('total_tax');

        DailyRevenues::updateOrCreate(
            ['date' => $date],
            ['income' => $income, 'total_tax' => $totalTax]
        );

        return redirect()->route('daily-revenues.index', ['date' => $date])
            ->with('success', 'Rekap harian berhasil disimpan!');
    }
}