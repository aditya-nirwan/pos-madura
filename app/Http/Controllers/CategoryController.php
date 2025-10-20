<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function show()
    {
        $show = Category::get();

        return view('categori.show', compact('show'));
    }

    public function create()
    {
        return view('categori.create');
    }

    public function store(Request $request)
    {

        $category = new Category();
        $category->code = $request->code;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();


        return redirect('categori')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $cate = Category::find($id);
        return view('categori.edit', compact('cate'));
    }

    public function update(Request $request)
    {
        $category = Category::find($request->id);

        $category->code = $request->code;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return redirect('categori')->with('success', 'Berhasil Edit Data');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();
        return redirect('categori')->with('success', 'Berhasil Hapus Data');
    }

    /**
     * API FUNCTION
     */
    public function get_all()
    {
        $data = Category::get();

        return response()->json($data);
    }
}
