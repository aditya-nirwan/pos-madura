<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $jabatans = Position::get();
        return view('position.index', compact('jabatans'));
    }

    public function create()
    {
        return view('position.create');
    }

    public function store(Request $request)
    {
        $row = new Position();
        $row->code = $request->code;
        $row->name = $request->name;
        $row->base_salary = $request->base_salary;
        $row->save();

        return redirect('jabatan')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jabatan = Position::findOrFail($id);
        return view('position.edit', compact('jabatan'));
    }

    public function update(Request $request, $id)
    {

        $jabatan = Position::findOrFail($id);
        $jabatan->code = $request->code;
        $jabatan->name = $request->name;
        $jabatan->base_salary = $request->base_salary;
        $jabatan->update();

        return redirect('jabatan')->with('success', 'Jabatan berhasil diupdate.');
    }

    public function destroy($id)
    {
        $jabatan = Position::findOrFail($id);

        $jabatan->delete();
        return redirect('jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }
}
