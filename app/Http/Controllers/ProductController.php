<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\ProductPriceHistory;
use App\Models\Setting;
use App\Models\WerehouseProduct;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Milon\Barcode\Facades\DNS1DFacade;
use Milon\Barcode\PDF417;
use Picqer\Barcode\BarcodeGeneratorJPG;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductController extends Controller
{
    public function show()
    {
        $show = Product::with('category')->get();
        return view('product.show', compact('show'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240'
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = 'product-' . date("YmdHis") . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
        }

        $product = new Product();
        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->buy_price = $request->buy_price;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->discount_type = $request->discount_type;
        $product->discount_percent = $request->discount_percent ?? 0;
        $product->discount_amount = $request->discount_amount ?? 0;
        $product->tax_type = $request->tax_type;
        $product->tax_percent = $request->tax_percent ?? 0;
        $product->tax_amount = $request->tax_amount ?? 0;
        $product->image = $imageName;
        $product->save();

        return redirect('product')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::get();
        return view('product.edit', compact('product', 'categories'));
    }


    public function update(Request $request)
    {
        $product = Product::find($request->id);

        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = 'product-' . date("YmdHis") . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);

            if ($product->image && file_exists(public_path('images/' . $product->image))) {
                unlink(public_path('images/' . $product->image));
            }

            $product->image = $imageName;
        }

        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->buy_price = $request->buy_price;
        $product->sell_price = $request->sell_price;
        $product->stock = $request->stock;
        $product->discount_type = $request->discount_type;
        $product->discount_percent = $request->discount_percent ?? 0;
        $product->discount_amount = $request->discount_amount ?? 0;
        $product->tax_type = $request->tax_type;
        $product->tax_percent = $request->tax_percent ?? 0;
        $product->tax_amount = $request->tax_amount ?? 0;
        $product->update();

        return redirect('product')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect('product')->with('success', 'Produk berhasil dihapus.');
    }

    public function formUpdatePrice($id)
    {
        $product = Product::findOrFail($id);
        $werehouse = WerehouseProduct::where('product_id', $id)->first();
        return view('product.update-price', compact('product', 'werehouse'));
    }

    public function updatePrice(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $history = new ProductPriceHistory();
        $history->product_id     = $product->id;
        $history->purchase_price = $request->purchase_price;
        $history->selling_price  = $request->selling_price;
        $history->effective_date = Carbon::now();
        $history->save();

        $product->buy_price  = $request->purchase_price;
        $product->sell_price = $request->selling_price;
        $product->save();

        return redirect('product')->with('success', 'Berhasil update harga produk.');
    }


    public function priceHistory($id)
    {
        $product = Product::findOrFail($id);

        $histories = ProductPriceHistory::where('product_id', $id)
            ->orderBy('effective_date', 'desc')
            ->get();

        return view('product.price-history', compact('product', 'histories'));
    }


    public function landing(Request $request)
    {
        $query = Product::with('category');

        // Filter kategori kalau ada
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(12);
        $categories = Category::all();
        $setting    = Setting::firstOrCreate([]);
        $carousels = Carousel::all();

        return view('landing.landing', compact('products', 'categories', 'setting', 'carousels'));
    }

    public function showDetail($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $setting    = Setting::firstOrCreate([]);
        $carousels = Carousel::all();

        return view('landing.show', compact('product', 'setting', 'carousels'));
    }

    public function getProducts($id)
    {
        $products = Product::where('category_id', $id)->get();
        return response()->json($products);
    }


    public function barcode($id)
    {
        $product = Product::findOrFail($id);

        $barcode = new \Milon\Barcode\DNS1D();
        $barcodeBase64 = $barcode->getBarcodePNG($product->code, 'C39', 2, 50);

        return view('product.barcode', compact('product', 'barcodeBase64'));
    }


    /**
     * API FUNCTION
     */
    public function get_all()
    {
        $data = Product::get();

        return response()->json($data);
    }
}