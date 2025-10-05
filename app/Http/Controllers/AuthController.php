<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('login-form');
    }

    // Memproses data login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => ['required','min:3','regex:/[A-Z]/'], // minimal 3 karakter + 1 huruf kapital
        ],[
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 3 karakter',
            'password.regex' => 'Password harus mengandung huruf kapital',
        ]);

        // Cek username & password sederhana (dummy)
        if($request->username === "admin" && $request->password === "Admin123"){
            return redirect('/dashboard')->with('success', 'Selamat datang, login berhasil!');
        } else {
            return redirect('/auth')->with('error', 'Username atau password salah!');
        }
    }
}
