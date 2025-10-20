<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function show()
    {
        $show = Unit::get();

        return view('units.show', compact('show'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {

        $category = new unit();
        $category->code = $request->code;
        $category->name = $request->name;
        $category->save();


        return redirect('units')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $unit = unit::find($id);
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request)
    {
        $category = Unit::find($request->id);

        $category->code = $request->code;
        $category->name = $request->name;
        $category->save();

        return redirect('units')->with('success', 'Berhasil Edit Data');
    }

    public function destroy($id)
    {
        $category = Unit::find($id);

        $category->delete();
        return redirect('units')->with('success', 'Berhasil Hapus Data');
    }

    /**
     * API FUNCTION
     */
    public function get_all()
    {
        $data = Unit::get();

        return response()->json($data);
    }
}