<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KeluargaKK;
use App\Models\Warga;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKeluarga = KeluargaKK::count();
        $totalWarga = Warga::count();
        $totalUser = User::count();

        return view('pages.dashboard.index', compact('totalKeluarga', 'totalWarga', 'totalUser'));
    }
}
