<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function show()
    {
        $show = Setting::get();
        return view('landing.setting', compact('show'));
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('landing.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $row = Setting::findOrFail($id);

        $row->brand_name      = $request->brand_name;
        $row->brand_highlight = $request->brand_highlight;
        $row->address         = $request->address;
        $row->email           = $request->email;
        $row->facebook        = $request->facebook;
        $row->twitter         = $request->twitter;
        $row->linkedin        = $request->linkedin;
        $row->instagram       = $request->instagram;

        $row->save();

        return redirect('setting')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function barcodeLanding()
    {
        $landingUrl = route('landing');

        return view('landing.barcode', compact('landingUrl'));
    }
}