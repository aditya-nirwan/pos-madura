<?php

namespace App\Http\Controllers;

use App\Models\DailyRevenues;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function daily(Request $request, $date = null)
    {
        $date = $date ?? $request->query('date', Carbon::today()->toDateString());
        $date = Carbon::parse($date);

        $dailyRevenues = DailyRevenues::whereDate('date', $date->toDateString())->get();

        $total_income = $dailyRevenues->sum('income');
        $total_tax    = $dailyRevenues->sum('total_tax');

        return view('income_report.daily', compact('dailyRevenues', 'total_income', 'total_tax', 'date'));
    }

    public function monthly(Request $request, $year = null, $month = null)
    {
        $year  = $year ?? $request->query('year', now()->year);
        $month = $month ?? $request->query('month', now()->month);

        $daily = DailyRevenues::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        $total_income = $daily->sum('income');
        $total_tax    = $daily->sum('total_tax');

        return view('income_report.monthly', compact('daily', 'total_income', 'total_tax', 'year', 'month'));
    }

    public function yearly(Request $request, $year = null)
    {
        $year = $year ?? $request->query('year', now()->year);

        $monthly = DailyRevenues::selectRaw('MONTH(date) as month, SUM(income) as total_income, SUM(total_tax) as total_tax')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $total_income = $monthly->sum('total_income');
        $total_tax    = $monthly->sum('total_tax');

        return view('income_report.yearly', compact('monthly', 'year', 'total_income', 'total_tax'));
    }

    public function monthlyComparison(Request $request)
    {
        if ($request->filled('bulan')) {
            [$year, $month] = explode('-', $request->bulan);
        } else {
            $year = now()->year;
            $month = now()->month;
        }

        $stockDetails = DB::table('stock_in_details as sid')
            ->join('stock_ins as si', 'sid.stock_in_id', '=', 'si.id')
            ->whereYear('si.created_at', $year)
            ->whereMonth('si.created_at', $month)
            ->select(
                'sid.id',
                'sid.qty_pack',
                'sid.qty_per_pack',
                'sid.buy_price',
                'sid.stock_in_id',
                'si.other_cost_total'
            )
            ->get();

        $modalPerBulan = 0;
        $grouped = $stockDetails->groupBy('stock_in_id');

        foreach ($grouped as $stockInId => $details) {
            $productCount = $details->count();
            $costPerProduct = $productCount > 0 ? $details->first()->other_cost_total / $productCount : 0;

            foreach ($details as $d) {
                $totalPcs = $d->qty_pack * $d->qty_per_pack;
                $modalPerBulan += ($totalPcs * $d->buy_price) + $costPerProduct;
            }
        }

        $pendapatanPerBulan = DB::table('daily_revenues')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('income');

        $laba = $pendapatanPerBulan - $modalPerBulan;

        return view('income_report.month_comparison', compact(
            'year',
            'month',
            'modalPerBulan',
            'pendapatanPerBulan',
            'laba'
        ));
    }

    public function pphReport(Request $request)
    {
        $year = $request->query('year', now()->year);

        $revenues = DailyRevenues::selectRaw('
            MONTH(date) as bulan,
            SUM(income) as total_income,
            SUM(total_tax) as total_tax
        ')
            ->whereYear('date', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $revenues = $revenues->map(function ($rev) {
            $rev->omzet = $rev->total_income - $rev->total_tax;
            $rev->pph = $rev->omzet * 0.005;
            return $rev;
        });

        return view('income_report.pph', compact('year', 'revenues'));
    }

    public function downloadDailyPdf(Request $request)
    {
        $date = $request->query('date', \Carbon\Carbon::today()->toDateString());
        $date = \Carbon\Carbon::parse($date);

        $dailyRevenues = DailyRevenues::whereDate('date', $date->toDateString())->get();

        $total_income = $dailyRevenues->sum('income');
        $total_tax    = $dailyRevenues->sum('total_tax');

        $pdf = Pdf::loadView('income_report.daily_pdf', compact('dailyRevenues', 'total_income', 'total_tax', 'date'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan-Harian-' . $date->format('d-m-Y') . '.pdf');
    }

    public function exportMonthlyPDF($year, $month)
    {
        $daily = DailyRevenues::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'asc')
            ->get();

        $total_income = $daily->sum('income');
        $total_tax    = $daily->sum('total_tax');

        $pdf = Pdf::loadView('income_report.pdf_monthly', compact('daily', 'total_income', 'total_tax', 'year', 'month'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan-Bulanan-{$month}-{$year}.pdf");
    }

    public function exportYearlyPDF($year)
    {
        $monthly = DailyRevenues::selectRaw('MONTH(date) as month, SUM(income) as total_income, SUM(total_tax) as total_tax')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        $total_income = $monthly->sum('total_income');
        $total_tax    = $monthly->sum('total_tax');

        $pdf = Pdf::loadView('income_report.pdf_yearly', compact('monthly', 'year', 'total_income', 'total_tax'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan-Tahunan-{$year}.pdf");
    }

    public function exportMonthlyComparisonPDF(Request $request)
    {
        [$year, $month] = explode('-', $request->bulan ?? now()->format('Y-m'));

        $stockDetails = DB::table('stock_in_details as sid')
            ->join('stock_ins as si', 'sid.stock_in_id', '=', 'si.id')
            ->whereYear('si.created_at', $year)
            ->whereMonth('si.created_at', $month)
            ->select('sid.id', 'sid.qty_pack', 'sid.qty_per_pack', 'sid.buy_price', 'sid.stock_in_id', 'si.other_cost_total')
            ->get();

        $modalPerBulan = 0;
        $grouped = $stockDetails->groupBy('stock_in_id');

        foreach ($grouped as $stockInId => $details) {
            $productCount = $details->count();
            $costPerProduct = $productCount > 0 ? $details->first()->other_cost_total / $productCount : 0;

            foreach ($details as $d) {
                $totalPcs = $d->qty_pack * $d->qty_per_pack;
                $modalPerBulan += ($totalPcs * $d->buy_price) + $costPerProduct;
            }
        }

        $pendapatanPerBulan = DB::table('daily_revenues')
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('income');

        $laba = $pendapatanPerBulan - $modalPerBulan;

        $pdf = Pdf::loadView('income_report.monthly_comparison_pdf', compact(
            'year',
            'month',
            'modalPerBulan',
            'pendapatanPerBulan',
            'laba'
        ))->setPaper('A4', 'portrait');

        return $pdf->stream("Laporan_Perbandingan_{$month}_{$year}.pdf");
    }


    public function pphReportPDF(Request $request)
    {
        $year = $request->query('year', now()->year);

        $revenues = DailyRevenues::selectRaw('
        MONTH(date) as bulan,
        SUM(income) as total_income,
        SUM(total_tax) as total_tax
    ')
            ->whereYear('date', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $revenues = $revenues->map(function ($rev) {
            $rev->omzet = $rev->total_income - $rev->total_tax;
            $rev->pph = $rev->omzet * 0.005;
            return $rev;
        });

        $pdf = Pdf::loadView('income_report.pph_pdf', compact('year', 'revenues'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream("laporan-pph-final_{$year}.pdf");
    }
}