<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\User;
use App\Models\KeluargaKK;
use App\Models\PeristiwaKematian;
use App\Models\PeristiwaPindah;
use App\Models\PeristiwaKelahiran;
use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display dashboard with all statistics
     */
    public function index()
    {
        // 1. DATA UTAMA
        $totalWarga = Warga::count();
        $totalKeluarga = KeluargaKK::count();
        $totalUser = User::count();

        // 2. STATISTIK GENDER
        $totalLaki = Warga::where('jenis_kelamin', 'L')->count();
        $totalPerempuan = Warga::where('jenis_kelamin', 'P')->count();

        // 3. DATA PERISTIWA
        $totalKematian = PeristiwaKematian::count();
        $totalPindah = PeristiwaPindah::where('status', 'approved')->count();
        $totalKelahiran = PeristiwaKelahiran::count();

        // 4. DATA BULAN INI
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $wargaBaruBulanIni = Warga::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $keluargaBaruBulanIni = KeluargaKK::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $kelahiranBulanIni = PeristiwaKelahiran::whereMonth('tgl_lahir', $bulanIni)
            ->whereYear('tgl_lahir', $tahunIni)
            ->count();

        $kematianBulanIni = PeristiwaKematian::whereMonth('tgl_meninggal', $bulanIni)
            ->whereYear('tgl_meninggal', $tahunIni)
            ->count();

        $pindahBulanIni = PeristiwaPindah::whereMonth('tgl_pindah', $bulanIni)
            ->whereYear('tgl_pindah', $tahunIni)
            ->where('status', 'approved')
            ->count();

        // 5. RATA-RATA WARGA PER KELUARGA
        $avgWargaPerKeluarga = $this->calculateAvgWargaPerKeluarga();

        // 6. STATISTIK AGAMA
        $agamaStats = $this->getAgamaStats();

        // 7. STATISTIK PENDIDIKAN
        $pendidikanStats = $this->getPendidikanStats();

        // 8. STATISTIK PEKERJAAN
        $pekerjaanStats = $this->getPekerjaanStats();

        // 9. STATISTIK STATUS PERKAWINAN
        $perkawinanStats = $this->getPerkawinanStats();

        // 10. STATISTIK 3 BULAN TERAKHIR
        $monthlyStats = $this->getMonthlyStats();

        // 11. AKTIVITAS TERBARU
        $recentActivities = $this->getRecentActivities();

        // 12. DATA PER RT/RW
        $rtRwStats = $this->getRtRwStats();

        // 13. STATISTIK USIA
        $usiaStats = $this->getUsiaStats();

        // 14. TOP 5 PEKERJAAN
        $topPekerjaan = $this->getTopPekerjaan();

        // 15. DATA KEPALA KELUARGA
        $kepalaKeluargaStats = $this->getKepalaKeluargaStats();

        // 16. STATUS VERIFIKASI EMAIL USER
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = User::whereNull('email_verified_at')->count();

        return view('pages.dashboard.index', compact(
            // Data utama
            'totalWarga',
            'totalKeluarga',
            'totalUser',

            // Gender
            'totalLaki',
            'totalPerempuan',

            // Peristiwa
            'totalKematian',
            'totalPindah',
            'totalKelahiran',

            // Bulan ini
            'wargaBaruBulanIni',
            'keluargaBaruBulanIni',
            'kelahiranBulanIni',
            'kematianBulanIni',
            'pindahBulanIni',

            // Rata-rata
            'avgWargaPerKeluarga',

            // Statistik
            'agamaStats',
            'pendidikanStats',
            'pekerjaanStats',
            'perkawinanStats',

            // Monthly
            'monthlyStats',

            // Activities
            'recentActivities',

            // RT/RW
            'rtRwStats',

            // Usia
            'usiaStats',

            // Top pekerjaan
            'topPekerjaan',

            // Kepala keluarga
            'kepalaKeluargaStats',

            // User verification
            'verifiedUsers',
            'unverifiedUsers'
        ));
    }

    /**
     * Calculate average warga per keluarga
     */
    private function calculateAvgWargaPerKeluarga()
    {
        $totalWarga = Warga::count();
        $totalKeluarga = KeluargaKK::count();

        if ($totalKeluarga > 0) {
            return round($totalWarga / $totalKeluarga, 1);
        }

        return 0;
    }

    /**
     * Get agama statistics
     */
    private function getAgamaStats()
    {
        return Warga::select('agama', DB::raw('count(*) as total'))
            ->whereNotNull('agama')
            ->groupBy('agama')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->agama ?: 'Tidak Diketahui',
                    'total' => $item->total,
                    'percentage' => round(($item->total / Warga::count()) * 100, 1)
                ];
            })
            ->take(6); // Ambil 6 agama teratas
    }

    /**
     * Get pendidikan statistics
     */
    private function getPendidikanStats()
    {
        return Warga::select('pendidikan', DB::raw('count(*) as total'))
            ->whereNotNull('pendidikan')
            ->groupBy('pendidikan')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->pendidikan ?: 'Tidak Diketahui',
                    'total' => $item->total,
                    'percentage' => round(($item->total / Warga::count()) * 100, 1)
                ];
            });
    }

    /**
     * Get pekerjaan statistics
     */
    private function getPekerjaanStats()
    {
        return Warga::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->pekerjaan ?: 'Tidak Bekerja',
                    'total' => $item->total
                ];
            });
    }

    /**
     * Get status perkawinan statistics
     */
    private function getPerkawinanStats()
    {
        return Warga::select('status_perkawinan', DB::raw('count(*) as total'))
            ->whereNotNull('status_perkawinan')
            ->groupBy('status_perkawinan')
            ->orderBy('total', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->status_perkawinan ?: 'Tidak Diketahui',
                    'total' => $item->total,
                    'percentage' => round(($item->total / Warga::count()) * 100, 1)
                ];
            });
    }

    /**
     * Get monthly statistics for last 3 months
     */
    private function getMonthlyStats()
    {
        $months = [];
        $keluargaStats = [];
        $wargaStats = [];
        $kelahiranStats = [];
        $kematianStats = [];
        $pindahStats = [];
        $labels = [];

        for ($i = 2; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            $monthName = $date->translatedFormat('M Y');

            $keluargaCount = KeluargaKK::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();

            $wargaCount = Warga::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();

            $kelahiranCount = PeristiwaKelahiran::whereMonth('tgl_lahir', $month)
                ->whereYear('tgl_lahir', $year)
                ->count();

            $kematianCount = PeristiwaKematian::whereMonth('tgl_meninggal', $month)
                ->whereYear('tgl_meninggal', $year)
                ->count();

            $pindahCount = PeristiwaPindah::whereMonth('tgl_pindah', $month)
                ->whereYear('tgl_pindah', $year)
                ->where('status', 'approved')
                ->count();

            $labels[] = $monthName;
            $keluargaStats[] = $keluargaCount;
            $wargaStats[] = $wargaCount;
            $kelahiranStats[] = $kelahiranCount;
            $kematianStats[] = $kematianCount;
            $pindahStats[] = $pindahCount;
        }

        return [
            'labels' => $labels,
            'keluarga' => $keluargaStats,
            'warga' => $wargaStats,
            'kelahiran' => $kelahiranStats,
            'kematian' => $kematianStats,
            'pindah' => $pindahStats
        ];
    }

    /**
     * Get recent activities from all tables
     */
    private function getRecentActivities()
    {
        $activities = [];
        $now = Carbon::now();

        // 1. Kelahiran terbaru (3 terbaru)
        $recentKelahiran = PeristiwaKelahiran::with('warga')
            ->latest('created_at')
            ->take(3)
            ->get();

        foreach ($recentKelahiran as $kelahiran) {
            $timeDiff = $now->diffForHumans($kelahiran->created_at, true);
            $namaWarga = $kelahiran->warga ? $kelahiran->warga->nama : 'Warga baru';
            $activities[] = [
                'title' => 'Kelahiran Baru',
                'description' => $namaWarga . ' lahir pada ' . ($kelahiran->tgl_lahir ? $kelahiran->tgl_lahir->format('d/m/Y') : '-'),
                'time' => $timeDiff . ' yang lalu',
                'icon' => 'fas fa-baby',
                'color' => 'warning',
                'type' => 'kelahiran',
                'url' => '#'
            ];
        }

        // 2. Pindah terbaru (yang disetujui) - 2 terbaru
        $recentPindah = PeristiwaPindah::with('warga')
            ->where('status', 'approved')
            ->latest('created_at')
            ->take(2)
            ->get();

        foreach ($recentPindah as $pindah) {
            $timeDiff = $now->diffForHumans($pindah->created_at, true);
            $activities[] = [
                'title' => 'Perpindahan Warga',
                'description' => ($pindah->warga ? $pindah->warga->nama : 'Warga') . ' pindah ke ' . ($pindah->kabupaten_tujuan ?? '-'),
                'time' => $timeDiff . ' yang lalu',
                'icon' => 'fas fa-truck-moving',
                'color' => 'info',
                'type' => 'pindah',
                'url' => '#'
            ];
        }

        // 3. Kematian terbaru - 2 terbaru
        $recentKematian = PeristiwaKematian::with('warga')
            ->latest('created_at')
            ->take(2)
            ->get();

        foreach ($recentKematian as $kematian) {
            $timeDiff = $now->diffForHumans($kematian->created_at, true);
            $activities[] = [
                'title' => 'Data Kematian',
                'description' => $kematian->warga ? $kematian->warga->nama : 'Warga',
                'time' => $timeDiff . ' yang lalu',
                'icon' => 'fas fa-cross',
                'color' => 'secondary',
                'type' => 'kematian',
                'url' => '#'
            ];
        }

        // 4. User terdaftar baru - 2 terbaru
        $recentUsers = User::latest('created_at')
            ->take(2)
            ->get();

        foreach ($recentUsers as $user) {
            $timeDiff = $now->diffForHumans($user->created_at, true);
            $activities[] = [
                'title' => 'Pengguna Baru',
                'description' => $user->name . ' (' . ($user->role ?? 'User') . ')',
                'time' => $timeDiff . ' yang lalu',
                'icon' => 'fas fa-user-plus',
                'color' => 'success',
                'type' => 'user',
                'url' => '#'
            ];
        }
        /*
        // 5. User login terbaru - 2 terbaru (DENGAN ERROR HANDLING)
        try {
            // Gunakan try-catch untuk menghindari error jika kolom tidak ada
            $recentLogin = User::whereNotNull('last_login')
                ->latest('last_login')
                ->take(2)
                ->get();

            foreach ($recentLogin as $user) {
                $timeDiff = $now->diffForHumans($user->last_login, true);
                $activities[] = [
                    'title' => 'Login Pengguna',
                    'description' => $user->name,
                    'time' => $timeDiff . ' yang lalu',
                    'icon' => 'fas fa-sign-in-alt',
                    'color' => 'primary',
                    'type' => 'login',
                    'url' => '#'
                ];
            }
        } catch (\Exception $e) {
            // Jika error, skip saja bagian ini
            \Log::error('Error getting recent login: ' . $e->getMessage());
        }*/

        // 6. Keluarga baru - 2 terbaru
        $recentKeluarga = KeluargaKK::with('kepalaKeluarga')
            ->latest('created_at')
            ->take(2)
            ->get();

        foreach ($recentKeluarga as $keluarga) {
            $timeDiff = $now->diffForHumans($keluarga->created_at, true);
            $activities[] = [
                'title' => 'Keluarga Baru',
                'description' => 'KK: ' . ($keluarga->kk_nomor ?? '-') . ' - ' . ($keluarga->kepalaKeluarga->nama ?? 'Tidak diketahui'),
                'time' => $timeDiff . ' yang lalu',
                'icon' => 'fas fa-home',
                'color' => 'danger',
                'type' => 'keluarga',
                'url' => '#'
            ];
        }

        // Acak aktivitas untuk variasi
        shuffle($activities);

        // Ambil 8 aktivitas terbaru
        return array_slice($activities, 0, 8);
    }

    /**
     * Get RT/RW statistics
     */
    private function getRtRwStats()
    {
        return KeluargaKK::select(
            'rt',
            'rw',
            DB::raw('count(*) as total_keluarga'),
            DB::raw('(SELECT COUNT(*) FROM anggota_keluarga ak
                         JOIN keluarga_kk kk ON ak.kk_id = kk.kk_id
                         WHERE kk.rt = keluarga_kk.rt AND kk.rw = keluarga_kk.rw) as total_warga')
        )
            ->whereNotNull('rt')
            ->whereNotNull('rw')
            ->groupBy('rt', 'rw')
            ->orderBy('rw')
            ->orderBy('rt')
            ->get()
            ->map(function ($item) {
                return [
                    'rt' => $item->rt,
                    'rw' => $item->rw,
                    'total_keluarga' => $item->total_keluarga,
                    'total_warga' => $item->total_warga
                ];
            });
    }

    /**
     * Get usia statistics (kategori usia)
     */
    private function getUsiaStats()
    {
        $warga = Warga::whereNotNull('tanggal_lahir')->get();

        $categories = [
            'Anak-anak (0-12)' => 0,
            'Remaja (13-17)' => 0,
            'Dewasa (18-40)' => 0,
            'Paruh Baya (41-60)' => 0,
            'Lansia (61+)' => 0
        ];

        foreach ($warga as $w) {
            $usia = $w->usia ?? Carbon::parse($w->tanggal_lahir)->age;

            if ($usia <= 12) {
                $categories['Anak-anak (0-12)']++;
            } elseif ($usia <= 17) {
                $categories['Remaja (13-17)']++;
            } elseif ($usia <= 40) {
                $categories['Dewasa (18-40)']++;
            } elseif ($usia <= 60) {
                $categories['Paruh Baya (41-60)']++;
            } else {
                $categories['Lansia (61+)']++;
            }
        }

        return $categories;
    }

    /**
     * Get top 5 pekerjaan
     */
    private function getTopPekerjaan()
    {
        return Warga::select('pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('pekerjaan')
            ->where('pekerjaan', '!=', '')
            ->groupBy('pekerjaan')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->pekerjaan,
                    'total' => $item->total
                ];
            });
    }

    /**
     * Get kepala keluarga statistics
     */
    private function getKepalaKeluargaStats()
    {
        $total = Warga::has('keluargaKK')->count();
        $laki = Warga::has('keluargaKK')->where('jenis_kelamin', 'L')->count();
        $perempuan = Warga::has('keluargaKK')->where('jenis_kelamin', 'P')->count();

        return [
            'total' => $total,
            'laki' => $laki,
            'perempuan' => $perempuan,
            'percentage_laki' => $total > 0 ? round(($laki / $total) * 100, 1) : 0,
            'percentage_perempuan' => $total > 0 ? round(($perempuan / $total) * 100, 1) : 0
        ];
    }

    /**
     * API untuk mendapatkan data statistik real-time
     */
    public function getStats()
    {
        $stats = Warga::getStatistik();

        // Tambahkan statistik tambahan
        $stats['total_keluarga'] = KeluargaKK::count();
        $stats['total_user'] = User::count();
        $stats['total_kelahiran'] = PeristiwaKelahiran::count();
        $stats['total_pindah'] = PeristiwaPindah::where('status', 'approved')->count();
        $stats['total_kematian'] = PeristiwaKematian::count();

        // Data bulan ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $stats['warga_bulan_ini'] = Warga::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $stats['keluarga_bulan_ini'] = KeluargaKK::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        return response()->json([
            'success' => true,
            'data' => $stats,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * API untuk mendapatkan chart data
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'monthly');

        if ($type === 'gender') {
            $data = [
                'labels' => ['Laki-laki', 'Perempuan'],
                'data' => [
                    Warga::where('jenis_kelamin', 'L')->count(),
                    Warga::where('jenis_kelamin', 'P')->count()
                ]
            ];
        } elseif ($type === 'agama') {
            $agamaStats = $this->getAgamaStats();
            $data = [
                'labels' => $agamaStats->pluck('name')->toArray(),
                'data' => $agamaStats->pluck('total')->toArray()
            ];
        } else {
            // Default: monthly stats
            $monthlyStats = $this->getMonthlyStats();
            $data = $monthlyStats;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
