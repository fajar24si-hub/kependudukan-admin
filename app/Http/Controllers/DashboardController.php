<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\KeluargaKK;
use App\Models\PeristiwaKelahiran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ========== DEFINE SEMUA VARIABLE YANG DIPERLUKAN ==========

        // 1. Data Keluarga
        $totalKeluarga = KeluargaKK::count(); // ✅ PASTIKAN INI ADA

        // 2. Data Warga/Marga (cek apakah ini 'Marga' atau 'Warga')
        $totalMarga = Warga::count(); // atau Marga::count() jika ada model Marga

        // 3. Data User
        $totalUser = User::count();

        // 4. Keluarga baru bulan ini
        $keluargaBaruBulanIni = KeluargaKK::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 5. Rata-rata marga per keluarga
        $avgMargaPerKeluarga = $totalKeluarga > 0 ? round($totalMarga / $totalKeluarga, 1) : 0;

        // 6. User aktif
        $activeUsers = User::where('is_active', 1)->count();

        // 7. Total kelahiran
        $totalKelahiran = PeristiwaKelahiran::count();

        // 8. Kelahiran lalu (sederhana saja)
        $kelahiranLalu = PeristiwaKelahiran::whereMonth('tgl_lahir', now()->subMonth()->month)
            ->whereYear('tgl_lahir', now()->subMonth()->year)
            ->count();

        // 9. Statistik 12 bulan (KOSONGKAN untuk sementara biar ringan)
        $statistik12Bulan = [];
        // $statistik12Bulan = $this->getStatistik12Bulan(); // COMMENT JIKA BERAT

        // 10. Data untuk gender chart
        $totalLaki = Warga::where('jenis_kelamin', 'L')->count(); // atau 'Laki-laki'
        $totalPerempuan = Warga::where('jenis_kelamin', 'P')->count(); // atau 'Perempuan'

        $genderChartData = [
            'laki' => $totalLaki,
            'perempuan' => $totalPerempuan
        ];

        // ========== RETURN KE VIEW ==========
        return view('pages.dashboard.index', compact(
            'totalKeluarga',      // ✅ SEKARANG SUDAH TERDEFINISI
            'totalMarga',         // Perhatikan: di compact() tulis 'totalMarga' bukan 'totalNarga'
            'totalUser',
            'keluargaBaruBulanIni',
            'avgMargaPerKeluarga',
            'activeUsers',
            'totalKelahiran',
            'kelahiranLalu',
            'statistik12Bulan',
            'totalLaki',          // ✅ TAMBAHKAN
            'totalPerempuan',     // ✅ TAMBAHKAN
            'genderChartData'
        ));
    }

    // Jika ada method getStatistik12Bulan(), bisa dikosongkan dulu
    private function getStatistik12Bulan()
    {
        return []; // Kembalikan array kosong sementara
    }
}
