<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\StockInOther;
use App\Models\StockInProduct;
use App\Models\Unit;
use App\Models\WerehouseProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    public function show()
    {
        $details = StockInDetail::with(['stockIn.user'])
            ->orderByDesc('id')
            ->get();

        return view('stock.show', compact('details'));
    }


    public function create()
    {
        $units = Unit::all();
        $products = Product::all(); // atau model yang sesuai
        return view('stock.stock_in', compact('units', 'products'));
    }


    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $subtotal = 0;

            foreach ($request->products as $prod) {
                $totalPerItem = $prod['qty'] * $prod['buy_price'];
                $subtotal += $totalPerItem;

                $product = WerehouseProduct::firstOrNew(['product_id' => $prod['product_id']]);
                $product->code = $product->exists ? $product->code : strtoupper(uniqid('GD-'));
                $product->product_id = $prod['product_id'];
                $product->description = $request->description ?? null;
                $product->category_id = $request->category_id ?? 1;
                $product->unit_id = $prod['unit_id'];
                $product->buy_price = $prod['buy_price'];
                $product->stock = $product->exists ? $product->stock + $prod['qty'] : $prod['qty'];
                $product->save();
            }

            $stockIn = StockIn::create([
                'code' => $request->code,
                'user_id' => 1,
                'subtotal' => $subtotal,
                'other_cost_total' => 0,
                'total' => $subtotal
            ]);

            $otherCost = 0;
            foreach ($request->other_costs as $cost) {
                $description = $cost['description'] ?? '';
                $amount = isset($cost['amount']) && $cost['amount'] !== '' ? (float) $cost['amount'] : 0;

                if ($description !== '') {
                    $otherCost += $amount;

                    $costItem = new StockInOther();
                    $costItem->stock_in_id = $stockIn->id;
                    $costItem->description = $description;
                    $costItem->amount = $amount;
                    $costItem->save();
                }
            }

            foreach ($request->products as $prod) {
                $detail = new StockInDetail();
                $detail->stock_in_id = $stockIn->id;
                $detail->product_name = $prod['product_id'];
                $detail->qty = $prod['qty'];
                $detail->buy_price = $prod['buy_price'];
                $detail->save();
            }

            $stockIn->other_cost_total = $otherCost;
            $stockIn->total = $subtotal + $otherCost;
            $stockIn->save();
        });

        return redirect('stock.show')->with('success', 'Stok masuk berhasil disimpan');
    }
}