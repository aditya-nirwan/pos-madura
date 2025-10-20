<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::all();
        return view('carousel.index', compact('carousels'));
    }

    public function create()
    {
        return view('carousel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $row = new Carousel();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = 'landing-' . date("YmdHis") . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $row->image = $imageName;
        }
        $row->title = $request->title;

        $row->save();

        return redirect()->route('carousel.index')->with('success', 'Carousel berhasil ditambahkan');
    }

    public function edit($id)
    {
        $row = Carousel::findOrFail($id);
        return view('carousel.edit', compact('row'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $row = Carousel::findOrFail($id);
        $row->title = $request->title;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = 'landing-' . date("YmdHis") . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);

            // hapus file lama
            if ($row->image && file_exists(public_path('images/' . $row->image))) {
                unlink(public_path('images/' . $row->image));
            }

            $row->image = $imageName;
        }

        $row->save();

        return redirect()->route('carousel.index')->with('success', 'Carousel berhasil diperbarui');
    }

    public function destroy($id)
    {
        $row = Carousel::findOrFail($id);

        if ($row->image && file_exists(public_path('images/' . $row->image))) {
            unlink(public_path('images/' . $row->image));
        }

        $row->delete();

        return redirect()->route('carousel.index')->with('success', 'Carousel berhasil dihapus');
    }
}
