<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\StockInOther;
use App\Models\StockInProduct;
use App\Models\StoreTransfer;
use App\Models\Unit;
use App\Models\WerehouseProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WerehouseProductController extends Controller
{

    public function index()
    {
        $products = WerehouseProduct::with('unit')->get();

        return view('werehouse.show', compact('products'));
    }

    public function show(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $date   = $request->get('date');
        $month  = $request->get('month');

        $query = StockInDetail::with(['stockIn.user', 'product'])
            ->orderByDesc('id');

        if ($filter === 'day' && $date) {
            $query->whereDate('created_at', $date);
        }

        if ($filter === 'month' && $month) {
            $query->whereMonth('created_at', date('m', strtotime($month)))
                ->whereYear('created_at', date('Y', strtotime($month)));
        }

        $details = $query->get();

        return view('werehouse.laporan', compact('details', 'filter', 'date', 'month'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        $products = Product::all();
        return view('werehouse.create', compact('units', 'products'));
    }


    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $subtotal = 0;

            foreach ($request->details as $prod) {
                $qtyPack     = $prod['qty_pack'] ?? 0;
                $qtyPerPack  = $prod['qty_per_pack'] ?? 1;
                $qtyTotal    = $qtyPack * $qtyPerPack; // pcs

                $totalPerItem = $qtyTotal * $prod['buy_price'];
                $subtotal += $totalPerItem;

                $productMaster = Product::findOrFail($prod['product_id']);

                $product = WerehouseProduct::firstOrNew(['product_id' => $prod['product_id']]);
                $product->code = $product->exists ? $product->code : strtoupper(uniqid('GD-'));
                $product->product_id = $prod['product_id'];
                $product->description = $request->description ?? null;
                $product->category_id = $productMaster->category_id;
                $product->unit_id = $prod['unit_id'];
                $product->buy_price = $prod['buy_price'];
                $product->qty_per_pack = $qtyPerPack;
                $product->stock = $product->exists ? $product->stock + $qtyTotal : $qtyTotal;
                $product->save();
            }

            $code = $request->code ?? 'IN-' . date('Ymd-His') . '-' . strtoupper(substr(uniqid(), -4));

            $stockIn = new StockIn();
            $stockIn->code             = $code;
            $stockIn->user_id          = Auth::id();
            $stockIn->subtotal         = $subtotal;
            $stockIn->other_cost_total = 0;
            $stockIn->total            = $subtotal;
            $stockIn->save();

            $otherCost = 0;
            foreach ($request->other_costs ?? [] as $cost) {
                $desc   = $cost['description'] ?? '';
                $amount = isset($cost['amount']) && $cost['amount'] !== '' ? (float) $cost['amount'] : 0;

                if ($desc !== '') {
                    $otherCost += $amount;

                    $other = new StockInOther();
                    $other->stock_in_id = $stockIn->id;
                    $other->description = $desc;
                    $other->amount      = $amount;
                    $other->save();
                }
            }



            foreach ($request->details as $prod) {
                $qtyPack     = $prod['qty_pack'] ?? 0;
                $qtyPerPack  = $prod['qty_per_pack'] ?? 1;
                $qtyTotal    = $qtyPack * $qtyPerPack;

                $detail = new StockInDetail();
                $detail->stock_in_id  = $stockIn->id;
                $detail->product_name = $prod['product_id'];
                $detail->qty_pack     = $qtyPack;
                $detail->qty_per_pack = $qtyPerPack;
                $detail->qty          = $qtyTotal; // total pcs
                $detail->buy_price    = $prod['buy_price'];
                $detail->save();
            }

            $stockIn->other_cost_total = $otherCost;
            $stockIn->total = $subtotal + $otherCost;
            $stockIn->save();
        });

        return redirect('gudang')->with('success', 'Stok masuk berhasil disimpan');
    }




    public function transfer($id)
    {
        $product = WerehouseProduct::with('product')->findOrFail($id);

        return view('werehouse.transfer', compact('product'));
    }


    public function transferStore(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $code = 'STF-' . date('Ymd-His');

            $warehouse = WerehouseProduct::findOrFail($id);

            if ($warehouse->stock < $request->qty) {
                throw new \Exception('Stok gudang tidak cukup');
            }

            $warehouse->stock -= $request->qty;
            $warehouse->save();

            $storeProduct = StockInProduct::where('product_id', $warehouse->product_id)
                ->where('stock_in_id', 0)
                ->first();

            if ($storeProduct) {
                $storeProduct->qty += $request->qty;
                $storeProduct->price = $request->price;
                $storeProduct->total = $storeProduct->qty * $request->price;
            } else {
                $storeProduct = new StockInProduct();
                $storeProduct->stock_in_id = 0;
                $storeProduct->product_id  = $warehouse->product_id;
                $storeProduct->qty         = $request->qty;
                $storeProduct->price       = $request->price;
                $storeProduct->total       = $request->qty * $request->price;
            }
            $storeProduct->save();

            $product = Product::findOrFail($warehouse->product_id);
            $product->stock = $product->stock + $request->qty;
            $product->save();

            $st = new StoreTransfer();
            $st->code       = $code;
            $st->product_id = $warehouse->product_id;
            $st->qty        = $request->qty;
            $st->price      = $request->price;
            $st->total      = $request->qty * $request->price;
            $st->description = $request->description;
            $st->user_id    = Auth::id();
            $st->save();
        });


        return redirect('gudang')->with('success', 'Stok berhasil dipindahkan ke toko');
    }

    public function showTransfer(Request $request)
    {
        $startDate = $request->start_date ?? now()->toDateString();
        $endDate   = $request->end_date ?? now()->toDateString();

        $query = StoreTransfer::with(['product', 'user'])
            ->latest()
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);

        $transfers = $query->paginate(10);

        return view('werehouse.laporan-pindah', compact('transfers', 'startDate', 'endDate'));
    }


    public function destroy($id)
    {
        $warehouse = WerehouseProduct::findOrFail($id);

        $warehouse->delete();

        return redirect('gudang')->with('success', 'Data berhasil dihapus ');
    }


    public function downloadPdf(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $date   = $request->get('date');
        $month  = $request->get('month');

        $query = StockInDetail::with(['stockIn.user', 'product'])
            ->orderByDesc('id');

        if ($filter === 'day' && $date) {
            $query->whereDate('created_at', $date);
        }

        if ($filter === 'month' && $month) {
            $query->whereMonth('created_at', date('m', strtotime($month)))
                ->whereYear('created_at', date('Y', strtotime($month)));
        }

        $details = $query->get();

        $pdf = Pdf::loadView('werehouse.laporan_pdf', compact('details', 'filter', 'date', 'month'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Gudang.pdf');
    }

    public function downloadTransferPdf(Request $request)
    {
        $startDate = $request->start_date ?? now()->toDateString();
        $endDate   = $request->end_date ?? now()->toDateString();

        $transfers = StoreTransfer::with(['product', 'user'])
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('werehouse.laporan-pindah_pdf', compact('transfers', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Pindah-Toko.pdf');
    }
}