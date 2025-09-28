<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $dataPenduduk = [
            ['id' => 1, 'nik' => '140101010001', 'nama' => 'Andi Saputra', 'umur' => 25, 'alamat' => 'Jl. Sudirman, Pekanbaru'],
            ['id' => 2, 'nik' => '140101010002', 'nama' => 'Budi Santoso', 'umur' => 30, 'alamat' => 'Jl. Hang Tuah, Pekanbaru'],
            ['id' => 3, 'nik' => '140101010003', 'nama' => 'Citra Lestari', 'umur' => 27, 'alamat' => 'Jl. Riau, Pekanbaru'],
            ['id' => 4, 'nik' => '140101010004', 'nama' => 'Dewi Anggraini', 'umur' => 32, 'alamat' => 'Jl. Soekarno Hatta, Pekanbaru'],
            ['id' => 5, 'nik' => '140101010005', 'nama' => 'Eko Prasetyo', 'umur' => 29, 'alamat' => 'Jl. Imam Munandar, Pekanbaru'],
        ];

        $search = $request->input('search');
        if ($search) {
            $dataPenduduk = array_filter($dataPenduduk, function ($item) use ($search) {
                return stripos($item['nama'], $search) !== false || stripos($item['alamat'], $search) !== false;
            });
        }

        // Reset array keys agar foreach di blade tetap urut
        $dataPenduduk = array_values($dataPenduduk);

        return view('pendudukview', compact('dataPenduduk'));
    }
}
