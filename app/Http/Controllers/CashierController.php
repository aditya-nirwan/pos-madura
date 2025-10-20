<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CashierController extends Controller
{
    public function show()
    {
        $show = Cashier::get();
        return view('cashier.show', compact('show'));
    }

    public function create()
    {
        return view('cashier.create');
    }

    public function store(Request $request)
    {

        $cashier = new Cashier();
        $cashier->username = $request->username;
        $cashier->name = $request->name;
        $cashier->password = Hash::make($request->password);
        $cashier->save();

        return redirect('cashier')->with('success', 'Kasir berhasil ditambahkan');
    }

    public function edit($id)
    {
        $cashier = Cashier::find($id);

        return view('cashier.edit', compact('cashier'));
    }

    public function update(Request $request)
    {

        $cashier = Cashier::find($request->id);

        $cashier->username = $request->username;
        $cashier->name = $request->name;

        if ($request->password) {
            $cashier->password = Hash::make($request->password);
        }

        $cashier->update();

        return redirect('cashier')->with('success', 'Kasir berhasil diperbarui');
    }

    public function destroy($id)
    {
        $cashier = Cashier::find($id);

        $cashier->delete();
        return redirect('cashier')->with('success', 'Kasir berhasil dihapus');
    }

    /**
     * API FUNCTION
     */
    public function get_all()
    {
        $data = Cashier::get();

        return response()->json($data);
    }
}
