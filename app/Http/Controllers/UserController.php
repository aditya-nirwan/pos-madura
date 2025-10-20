<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah, silakan cek kembali']);
        }

        $request->session()->regenerate();
        return redirect()->intended('home')->with('success', 'Selamat datang!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah keluar');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function index()
    {
        $users = User::get();
        return view('users.show', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $row = new User();
        $row->username = $request->nama;
        $row->email = $request->email;
        $row->password = Hash::make($request->password);
        $row->role = $request->role;
        $row->save();

        return redirect('users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {


        $row = User::findOrFail($id);
        $row->username = $request->name;
        $row->email = $request->email;
        $row->role = $request->role;
        $row->save();

        return redirect('users')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('users')->with('success', 'User berhasil dihapus.');
    }
}