<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\KeluargaKK;
use App\Models\PeristiwaKelahiran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ========== STATISTIK UTAMA - OPTIMIZED ==========

        // Gunakan cache untuk data yang tidak sering berubah
        $cacheTime = 60; // 1 menit cache

        // 1-3. Hitung semuanya dalam batch
        $totalKeluarga = cache()->remember('total_keluarga', $cacheTime, function() {
            return KeluargaKK::count();
        });

        $totalWarga = cache()->remember('total_warga', $cacheTime, function() {
            return Warga::count();
        });

        $totalUser = cache()->remember('total_user', $cacheTime, function() {
            return User::count();
        });

        // 4. Keluarga baru bulan ini
        $keluargaBaruBulanIni = cache()->remember('keluarga_baru_bulan_ini', $cacheTime, function() {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            return KeluargaKK::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        });

        // 5. Warga baru bulan ini
        $wargaBaruBulanIni = cache()->remember('warga_baru_bulan_ini', $cacheTime, function() {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            return Warga::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        });

        // 6. Rata-rata warga per keluarga
        $avgWargaPerKeluarga = $totalKeluarga > 0 ? round($totalWarga / $totalKeluarga, 1) : 0;

        // 7. User aktif - SIMPLIFIED VERSION
        $activeUsers = $totalUser; // Anggap semua user aktif

        // 8-9. Kelahiran - simplified
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $totalKelahiran = cache()->remember('total_kelahiran_' . $currentYear, $cacheTime * 5, function() use ($currentYear) {
            return PeristiwaKelahiran::whereYear('tgl_lahir', $currentYear)->count();
        });

        $kelahiranBulanIni = cache()->remember('kelahiran_bulan_ini_' . $currentYear . '_' . $currentMonth, $cacheTime, function() use ($currentYear, $currentMonth) {
            return PeristiwaKelahiran::whereYear('tgl_lahir', $currentYear)
                ->whereMonth('tgl_lahir', $currentMonth)
                ->count();
        });

        // 10-11. Kematian - simplified
        $totalKematian = 0;
        $kematianBulanIni = 0;

        // Cek kolom status_warga secara aman
        try {
            $totalKematian = Warga::where('status_warga', 'Meninggal')
                ->whereYear('updated_at', $currentYear)
                ->count();

            $kematianBulanIni = Warga::where('status_warga', 'Meninggal')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $currentMonth)
                ->count();
        } catch (\Exception $e) {
            // Jika error, skip saja
        }

        // 12-13. Pindah - simplified
        $totalPindah = 0;
        $pindahBulanIni = 0;

        try {
            $totalPindah = Warga::where('status_warga', 'Pindah')
                ->whereYear('updated_at', $currentYear)
                ->count();

            $pindahBulanIni = Warga::where('status_warga', 'Pindah')
                ->whereYear('updated_at', $currentYear)
                ->whereMonth('updated_at', $currentMonth)
                ->count();
        } catch (\Exception $e) {
            // Jika error, skip saja
        }

        // 14. Data gender - cached
        $totalLaki = cache()->remember('total_laki', $cacheTime * 10, function() {
            return Warga::where('jenis_kelamin', 'L')->count();
        });

        $totalPerempuan = cache()->remember('total_perempuan', $cacheTime * 10, function() {
            return Warga::where('jenis_kelamin', 'P')->count();
        });

        // 15. Statistik sederhana - hanya 3 bulan terakhir
        $monthlyStats = $this->getLightMonthlyStats();

        // 16. Aktivitas terbaru - simplified
        $recentActivities = $this->getLightRecentActivities();

        // ========== RETURN KE VIEW ==========
        return view('pages.dashboard.index', compact(
            'totalKeluarga',
            'totalWarga',
            'totalUser',
            'keluargaBaruBulanIni',
            'wargaBaruBulanIni',
            'avgWargaPerKeluarga',
            'activeUsers',
            'totalKelahiran',
            'kelahiranBulanIni',
            'totalKematian',
            'kematianBulanIni',
            'totalPindah',
            'pindahBulanIni',
            'totalLaki',
            'totalPerempuan',
            'monthlyStats',
            'recentActivities'
        ));
    }

    private function getLightMonthlyStats()
    {
        // Hanya 3 bulan terakhir untuk mengurangi beban
        $months = [];
        $keluargaData = [];
        $wargaData = [];

        for ($i = 2; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M');
            $months[] = $monthName;

            $month = $date->month;
            $year = $date->year;

            // Gunakan cache untuk tiap bulan
            $cacheKeyKeluarga = "keluarga_stats_{$year}_{$month}";
            $keluargaData[] = cache()->remember($cacheKeyKeluarga, 3600, function() use ($month, $year) {
                return KeluargaKK::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->count();
            });

            $cacheKeyWarga = "warga_stats_{$year}_{$month}";
            $wargaData[] = cache()->remember($cacheKeyWarga, 3600, function() use ($month, $year) {
                return Warga::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->count();
            });
        }

        return [
            'labels' => $months,
            'keluarga' => $keluargaData,
            'warga' => $wargaData
        ];
    }

    private function getLightRecentActivities()
    {
        // Hanya 3 aktivitas terbaru
        $activities = [];

        try {
            // Keluarga baru
            $keluargaBaru = KeluargaKK::select('kk_nomor', 'created_at')
                ->orderBy('created_at', 'desc')
                ->take(1)
                ->first();

            if ($keluargaBaru) {
                $activities[] = [
                    'icon' => 'fas fa-home',
                    'title' => 'Keluarga Baru',
                    'description' => "KK {$keluargaBaru->kk_nomor} ditambahkan",
                    'time' => $keluargaBaru->created_at->diffForHumans(),
                    'color' => 'primary'
                ];
            }

            // Warga baru
            $wargaBaru = Warga::select('nama', 'nik', 'created_at')
                ->orderBy('created_at', 'desc')
                ->take(1)
                ->first();

            if ($wargaBaru) {
                $activities[] = [
                    'icon' => 'fas fa-user-plus',
                    'title' => 'Warga Baru',
                    'description' => "{$wargaBaru->nama} terdaftar",
                    'time' => $wargaBaru->created_at->diffForHumans(),
                    'color' => 'success'
                ];
            }

            // Kelahiran baru
            $kelahiranBaru = PeristiwaKelahiran::select('nama_bayi', 'created_at')
                ->orderBy('created_at', 'desc')
                ->take(1)
                ->first();

            if ($kelahiranBaru) {
                $activities[] = [
                    'icon' => 'fas fa-baby',
                    'title' => 'Kelahiran Baru',
                    'description' => "{$kelahiranBaru->nama_bayi} lahir",
                    'time' => $kelahiranBaru->created_at->diffForHumans(),
                    'color' => 'warning'
                ];
            }

        } catch (\Exception $e) {
            // Jika error, beri placeholder
            $activities[] = [
                'icon' => 'fas fa-check-circle',
                'title' => 'Sistem Berjalan',
                'description' => 'Dashboard siap digunakan',
                'time' => 'Baru saja',
                'color' => 'info'
            ];
        }

        return $activities;
    }

    /**
     * API yang lebih ringan - tanpa chart.js
     */
    public function quickStats()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'totalKeluarga' => cache()->get('total_keluarga', 0),
                    'totalWarga' => cache()->get('total_warga', 0),
                    'totalUser' => cache()->get('total_user', 0),
                    'keluargaBaruBulanIni' => cache()->get('keluarga_baru_bulan_ini', 0),
                    'server_time' => now()->format('H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching stats'
            ]);
        }
    }
}
