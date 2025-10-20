<?php

namespace App\Http\Controllers;

use App\Models\DailyRevenues;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\WerehouseProduct;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show(Request $request, $year = null)
    {
        $year = $year ?? $request->query('year', now()->year);

        $monthly = DailyRevenues::selectRaw('MONTH(date) as month, SUM(income) as total_income, SUM(total_tax) as total_tax')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $total_income = $monthly->sum('total_income');
        $total_tax    = $monthly->sum('total_tax');

        $total_products = Product::count();
        $total_stock = WerehouseProduct::sum('stock');

        $today = now()->toDateString();

        $today_transactions = Transaction::whereDate('created_at', $today)->count();
        $today_income = DailyRevenues::whereDate('date', $today)->sum('income');

        return view('welcome', compact(
            'monthly',
            'year',
            'total_income',
            'total_tax',
            'total_products',
            'total_stock',
            'today_transactions',
            'today_income'
        ));
    }
}