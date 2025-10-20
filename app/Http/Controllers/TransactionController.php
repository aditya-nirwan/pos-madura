<?php

namespace App\Http\Controllers;

use App\Models\DailyRevenues;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $date = $request->get('date');
        $month = $request->get('month');

        $query = Transaction::query()->latest();

        if ($filter === 'day' && $date) {
            $query->whereDate('created_at', $date);
        }

        if ($filter === 'month' && $month) {
            $query->whereMonth('created_at', date('m', strtotime($month)))
                ->whereYear('created_at', date('Y', strtotime($month)));
        }

        $transactions = $query->paginate(50)->appends($request->all());

        return view('transaction.index', compact('transactions', 'filter', 'date', 'month'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }

    public function today()
    {
        $today = Carbon::today();
        $transactions = Transaction::with('items')
            ->whereDate('created_at', $today)
            ->get();

        return response()->json([
            'status' => 'success',
            'date'   => $today->toDateString(),
            'data'   => $transactions
        ]);
    }

    public function upload(Request $request)
    {
        $data = $request->all();

        foreach ($data as $trxData) {
            $transaction = Transaction::updateOrCreate(
                ['code' => $trxData['code']],
                [
                    'cashier_id'     => $trxData['cashier_id'],
                    'subtotal'       => $trxData['subtotal'],
                    'total_discount' => $trxData['total_discount'] ?? 0,
                    'total_tax'      => $trxData['total_tax'] ?? 0,
                    'total_cost'     => $trxData['total_cost'],
                ]
            );

            $transaction->items()->delete();

            foreach ($trxData['items'] as $item) {
                TransactionItem::create([
                    'transaction_id'  => $transaction->id,
                    'code'            => $item['code'],
                    'name'            => $item['name'],
                    'price'           => $item['price'],
                    'qty'             => $item['qty'],
                    'subtotal'        => $item['subtotal'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'tax_amount'      => $item['tax_amount'] ?? 0,
                    'total'           => $item['total'],
                ]);

                $product = Product::where('code', $item['code'])->first();
                if ($product) {
                    $product->decrement('stock', $item['qty']);
                }
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Sinkronisasi berhasil'
        ]);
    }

    // public function endClosing()
    // {
    //     $today = Carbon::today();

    //     $income = Transaction::whereDate('created_at', $today)->sum('total_cost');
    //     $totalTax = Transaction::whereDate('created_at', $today)->sum('total_tax');

    //     DailyRevenues::updateOrCreate(
    //         ['date' => $today],
    //         [
    //             'income'     => $income,
    //             'total_tax'  => $totalTax,
    //         ]
    //     );

    //     return response()->json([
    //         'status'    => 'success',
    //         'date'      => $today->toDateString(),
    //         'income'    => $income,
    //         'total_tax' => $totalTax,
    //     ]);
    // }

    public function getTodaySummary()
    {
        $today = Carbon::today();

        $summary = Transaction::whereDate('created_at', $today)
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw('COALESCE(SUM(subtotal), 0) as total_subtotal')
            ->selectRaw('COALESCE(SUM(total_discount), 0) as total_discount')
            ->selectRaw('COALESCE(SUM(total_tax), 0) as total_tax')
            ->selectRaw('COALESCE(SUM(total_cost), 0) as income')
            ->first();

        return response()->json([
            'status' => 'success',
            'date' => $today->format('Y-m-d'),
            'data' => [
                'transaction_count' => (int) $summary->transaction_count,
                'total_subtotal' => (float) $summary->total_subtotal,
                'total_discount' => (float) $summary->total_discount,
                'total_tax' => (float) $summary->total_tax,
                'income' => (float) $summary->income,
            ]
        ]);
    }

    public function getTodaySoldItems()
    {
        $today = Carbon::today();

        $soldItems = TransactionItem::whereHas('transaction', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->selectRaw('code, name, SUM(qty) as qty, SUM(total) as revenue')
            ->groupBy('code', 'name')
            ->orderBy('revenue', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'date' => $today->format('Y-m-d'),
            'data' => $soldItems
        ]);
    }

    public function endClosing(Request $request)
    {
        DB::beginTransaction();

        try {
            $today = Carbon::today();

            // Cek apakah sudah ada closing hari ini
            if (DailyRevenues::whereDate('date', $today)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Closing untuk hari ini sudah dilakukan'
                ], 400);
            }

            $summary = Transaction::whereDate('created_at', $today)
                ->selectRaw('COALESCE(SUM(total_cost), 0) as income')
                ->selectRaw('COALESCE(SUM(total_tax), 0) as total_tax')
                ->selectRaw('COUNT(*) as transaction_count')
                ->first();

            $dailyRevenue = DailyRevenues::create([
                'date' => $today,
                'income' => $summary->income,
                'total_tax' => $summary->total_tax,
                'created_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Closing berhasil disimpan',
                'data' => $dailyRevenue
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Closing gagal: ' . $e->getMessage()
            ], 500);
        }
    }

    public function syncSingle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
            'cashier_id' => 'required|integer',
            'subtotal' => 'required|numeric',
            'total_discount' => 'numeric',
            'total_tax' => 'numeric',
            'total_cost' => 'required|numeric',
            'created_at' => 'required|date',
            'items' => 'required|array',
            'items.*.code' => 'required|string',
            'items.*.name' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'items.*.discount_amount' => 'numeric',
            'items.*.tax_amount' => 'numeric',
            'items.*.subtotal' => 'required|numeric',
            'items.*.total' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }

        DB::beginTransaction();

        try {
            $trxData = $request->all();

            $transaction = Transaction::updateOrCreate(
                ['code' => $trxData['code']],
                [
                    'cashier_id' => $trxData['cashier_id'],
                    'subtotal' => $trxData['subtotal'],
                    'total_discount' => $trxData['total_discount'] ?? 0,
                    'total_tax' => $trxData['total_tax'] ?? 0,
                    'total_cost' => $trxData['total_cost'],
                    'created_at' => $trxData['created_at'] ?? now(),
                    'updated_at' => now()
                ]
            );

            $transaction->items()->delete();

            foreach ($trxData['items'] as $item) {
                $transactionItem = TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'tax_amount' => $item['tax_amount'] ?? 0,
                    'total' => $item['total']
                ]);

                $product = Product::where('code', $item['code'])->first();
                if ($product) {
                    if ($product->stock >= $item['qty']) {
                        $product->decrement('stock', $item['qty']);
                    } else {
                        throw new \Exception("Stok tidak cukup untuk produk {$item['code']}");
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil disinkronisasi',
                'transaction_code' => $trxData['code']
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Sinkronisasi gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}