@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Alert Session -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Dashboard Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard
                            </h1>
                            <p class="text-muted mb-0">
                                Sistem Informasi Kependudukan - {{ now()->translatedFormat('l, d F Y') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-outline-primary btn-sm" onclick="refreshDashboard()">
                                <i class="fas fa-sync-alt me-1"></i> Refresh
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="exportDashboard()">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK STATS ROW -->
    <div class="row g-3 mb-4">
        <!-- Kartu Total Keluarga -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-home fa-2x text-primary"></i>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalKeluarga ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Keluarga</p>
                    <small class="text-muted">
                        <i class="fas fa-plus me-1"></i>
                        {{ $keluargaBaruBulanIni ?? 0 }} baru bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Total Warga -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalWarga ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Warga</p>
                    <small class="text-muted">
                        <i class="fas fa-user-plus me-1"></i>
                        {{ $wargaBaruBulanIni ?? 0 }} baru bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Kelahiran -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-baby fa-2x text-warning"></i>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalKelahiran ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Kelahiran</p>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $kelahiranBulanIni ?? 0 }} bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Kematian -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-cross fa-2x text-secondary"></i>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalKematian ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Kematian</p>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $kematianBulanIni ?? 0 }} bulan ini
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: GENDER & STATUS -->
    <div class="row g-3 mb-4">
        <!-- Kartu Gender -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-venus-mars fa-2x text-info"></i>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h4 class="mb-0 text-primary">{{ $totalLaki ?? 0 }}</h4>
                            <small class="text-muted">Laki-laki</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-0 text-danger">{{ $totalPerempuan ?? 0 }}</h4>
                            <small class="text-muted">Perempuan</small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            {{ $totalLaki > 0 ? round(($totalLaki / $totalWarga) * 100, 1) : 0 }}% Laki-laki
                            | {{ $totalPerempuan > 0 ? round(($totalPerempuan / $totalWarga) * 100, 1) : 0 }}% Perempuan
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Pindah -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-truck-moving fa-2x text-info"></i>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalPindah ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Pindah</p>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $pindahBulanIni ?? 0 }} bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu User -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users-cog fa-2x text-purple"></i>
                    </div>
                    <h2 class="mb-1">{{ number_format($totalUser ?? 0) }}</h2>
                    <p class="text-muted mb-0">Total Pengguna</p>
                    <small class="text-muted">
                        <i class="fas fa-check-circle me-1 text-success"></i>
                        {{ $verifiedUsers ?? 0 }} terverifikasi
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Rata-rata -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-chart-bar fa-2x text-warning"></i>
                    </div>
                    <h2 class="mb-1">{{ $avgWargaPerKeluarga ?? 0 }}</h2>
                    <p class="text-muted mb-0">Rata-rata/Keluarga</p>
                    <small class="text-muted">
                        <i class="fas fa-home me-1"></i>
                        {{ $totalKeluarga ?? 0 }} keluarga
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3: STATISTIK DETAIL -->
    <div class="row g-3 mb-4">
        <!-- Statistik Agama -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-pray me-2"></i>Statistik Agama</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Agama</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agamaStats ?? [] as $agama)
                                    <tr>
                                        <td>{{ $agama['name'] }}</td>
                                        <td class="text-end">{{ number_format($agama['total']) }}</td>
                                        <td class="text-end">{{ $agama['percentage'] }}%</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Data agama belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pendidikan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Statistik Pendidikan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Pendidikan</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendidikanStats ?? [] as $pendidikan)
                                    <tr>
                                        <td>{{ $pendidikan['name'] }}</td>
                                        <td class="text-end">{{ number_format($pendidikan['total']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Data pendidikan belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Usia -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-birthday-cake me-2"></i>Distribusi Usia</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Kategori Usia</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($usiaStats && count($usiaStats) > 0)
                                    @foreach($usiaStats as $kategori => $jumlah)
                                        <tr>
                                            <td>{{ $kategori }}</td>
                                            <td class="text-end">{{ number_format($jumlah) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Data usia belum tersedia</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 4: STATISTIK BULANAN & AKTIVITAS -->
    <div class="row g-3 mb-4">
        <!-- Statistik 3 Bulan Terakhir -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Statistik 3 Bulan Terakhir</h5>
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-primary active" onclick="changeChartType('monthly')">
                            Bulanan
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="changeChartType('gender')">
                            Gender
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="changeChartType('agama')">
                            Agama
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="chartContainer">
                        @if(!empty($monthlyStats['labels']))
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th class="text-end">Keluarga</th>
                                            <th class="text-end">Warga</th>
                                            <th class="text-end">Kelahiran</th>
                                            <th class="text-end">Kematian</th>
                                            <th class="text-end">Pindah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for($i = 0; $i < count($monthlyStats['labels']); $i++)
                                            <tr>
                                                <td>{{ $monthlyStats['labels'][$i] }}</td>
                                                <td class="text-end">{{ number_format($monthlyStats['keluarga'][$i] ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($monthlyStats['warga'][$i] ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($monthlyStats['kelahiran'][$i] ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($monthlyStats['kematian'][$i] ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($monthlyStats['pindah'][$i] ?? 0) }}</td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-chart-bar fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Data statistik belum tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                        @forelse($recentActivities ?? [] as $activity)
                            <a href="{{ $activity['url'] ?? '#' }}" class="list-group-item list-group-item-action border-0 px-3 py-3">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-{{ $activity['color'] ?? 'primary' }} rounded-circle p-2">
                                            <i class="{{ $activity['icon'] ?? 'fas fa-info' }} text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h6 class="mb-1">{{ $activity['title'] ?? 'Aktivitas' }}</h6>
                                            <small class="text-muted">{{ $activity['time'] ?? 'Baru saja' }}</small>
                                        </div>
                                        <p class="mb-0 text-muted small">{{ $activity['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Belum ada aktivitas</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 5: DATA RT/RW DAN TOP PEKERJAAN -->
    <div class="row g-3">
        <!-- Data RT/RW -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Data per RT/RW</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th class="text-end">Keluarga</th>
                                    <th class="text-end">Warga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rtRwStats ?? [] as $stat)
                                    <tr>
                                        <td>{{ $stat['rt'] }}</td>
                                        <td>{{ $stat['rw'] }}</td>
                                        <td class="text-end">{{ number_format($stat['total_keluarga']) }}</td>
                                        <td class="text-end">{{ number_format($stat['total_warga']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Data RT/RW belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($rtRwStats && count($rtRwStats) > 0)
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="2"><strong>Total</strong></td>
                                        <td class="text-end">
                                            <strong>{{ number_format($rtRwStats->sum('total_keluarga')) }}</strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ number_format($rtRwStats->sum('total_warga')) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 Pekerjaan & Status Perkawinan -->
        <div class="col-lg-6">
            <div class="row g-3">
                <!-- Top 5 Pekerjaan -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Top 5 Pekerjaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <th class="text-end">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topPekerjaan ?? [] as $pekerjaan)
                                            <tr>
                                                <td>{{ $pekerjaan['name'] }}</td>
                                                <td class="text-end">{{ number_format($pekerjaan['total']) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">Data pekerjaan belum tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik Status Perkawinan -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Status Perkawinan</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th class="text-end">Jumlah</th>
                                            <th class="text-end">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($perkawinanStats ?? [] as $status)
                                            <tr>
                                                <td>{{ $status['name'] }}</td>
                                                <td class="text-end">{{ number_format($status['total']) }}</td>
                                                <td class="text-end">{{ $status['percentage'] }}%</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">Data status perkawinan belum tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    :root {
        --primary-color: #4361ee;
        --success-color: #00b894;
        --warning-color: #fdcb6e;
        --danger-color: #e17055;
        --info-color: #00cec9;
        --purple-color: #6c5ce7;
    }

    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid #eef2f7;
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important;
    }

    .list-group-item {
        background: transparent;
        border-left: none;
        border-right: none;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .badge.rounded-circle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table th {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
        text-transform: uppercase;
    }

    .table td {
        vertical-align: middle;
    }

    .text-purple {
        color: var(--purple-color) !important;
    }

    .card-header {
        border-bottom: 1px solid #eef2f7;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .btn-group .btn.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Auto-dismiss alerts
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    // Update current time
    function updateCurrentTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }

    setInterval(updateCurrentTime, 1000);
    updateCurrentTime();

    // Initialize Chart
    initDashboardChart();
});

// Function to refresh dashboard data
function refreshDashboard() {
    showLoading();
    fetch('{{ route("dashboard.stats") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update all elements with data-stat attribute
                document.querySelectorAll('[data-stat]').forEach(element => {
                    const stat = element.getAttribute('data-stat');
                    if (data.data[stat] !== undefined) {
                        element.textContent = data.data[stat];
                    }
                });

                showToast('Data berhasil diperbarui', 'success');
            }
        })
        .catch(error => {
            console.error('Error updating stats:', error);
            showToast('Gagal memperbarui data', 'error');
        })
        .finally(() => {
            hideLoading();
        });
}

// Function to change chart type
function changeChartType(type) {
    showLoading();
    fetch(`/api/dashboard/chart-data?type=${type}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateChartDisplay(data.data, type);
                updateActiveButton(type);
            }
        })
        .catch(error => {
            console.error('Error loading chart data:', error);
        })
        .finally(() => {
            hideLoading();
        });
}

// Function to initialize chart
function initDashboardChart() {
    // You can implement Chart.js here for better visualization
    console.log('Chart initialized');
}

// Function to update chart display
function updateChartDisplay(data, type) {
    const container = document.getElementById('chartContainer');

    if (type === 'monthly') {
        let html = `
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th class="text-end">Keluarga</th>
                            <th class="text-end">Warga</th>
                            <th class="text-end">Kelahiran</th>
                            <th class="text-end">Kematian</th>
                            <th class="text-end">Pindah</th>
                        </tr>
                    </thead>
                    <tbody>`;

        for (let i = 0; i < data.labels.length; i++) {
            html += `
                <tr>
                    <td>${data.labels[i]}</td>
                    <td class="text-end">${data.keluarga[i]}</td>
                    <td class="text-end">${data.warga[i]}</td>
                    <td class="text-end">${data.kelahiran[i]}</td>
                    <td class="text-end">${data.kematian[i]}</td>
                    <td class="text-end">${data.pindah[i]}</td>
                </tr>`;
        }

        html += `</tbody></table></div>`;
        container.innerHTML = html;
    } else if (type === 'gender') {
        let html = `
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Gender</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-end">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>`;

        for (let i = 0; i < data.labels.length; i++) {
            const total = data.data.reduce((a, b) => a + b, 0);
            const percentage = total > 0 ? ((data.data[i] / total) * 100).toFixed(1) : 0;

            html += `
                <tr>
                    <td>${data.labels[i]}</td>
                    <td class="text-end">${data.data[i]}</td>
                    <td class="text-end">${percentage}%</td>
                </tr>`;
        }

        html += `</tbody></table></div>`;
        container.innerHTML = html;
    } else if (type === 'agama') {
        let html = `
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Agama</th>
                            <th class="text-end">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>`;

        for (let i = 0; i < data.labels.length; i++) {
            html += `
                <tr>
                    <td>${data.labels[i]}</td>
                    <td class="text-end">${data.data[i]}</td>
                </tr>`;
        }

        html += `</tbody></table></div>`;
        container.innerHTML = html;
    }
}

// Function to update active button
function updateActiveButton(type) {
    const buttons = document.querySelectorAll('.btn-group .btn');
    buttons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.textContent.trim().toLowerCase() === type) {
            btn.classList.add('active');
        }
    });
}

// Function to show loading
function showLoading() {
    // Implement loading indicator
    const spinner = document.createElement('div');
    spinner.id = 'loadingSpinner';
    spinner.className = 'text-center py-4';
    spinner.innerHTML = `
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Memuat data...</p>
    `;

    const container = document.getElementById('chartContainer');
    if (container) {
        container.innerHTML = '';
        container.appendChild(spinner);
    }
}

// Function to hide loading
function hideLoading() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.remove();
    }
}

// Function to show toast notification
function showToast(message, type = 'info') {
    const toastContainer = document.createElement('div');
    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
    toastContainer.style.zIndex = '11';

    const toastId = 'toast-' + Date.now();
    const bgColor = type === 'success' ? 'bg-success' :
                    type === 'error' ? 'bg-danger' :
                    type === 'warning' ? 'bg-warning' : 'bg-info';

    toastContainer.innerHTML = `
        <div id="${toastId}" class="toast align-items-center text-white ${bgColor} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;

    document.body.appendChild(toastContainer);

    const toastEl = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();

    // Remove toast after it's hidden
    toastEl.addEventListener('hidden.bs.toast', function () {
        toastContainer.remove();
    });
}

// Function to export dashboard data
function exportDashboard() {
    // Implement export functionality (PDF/Excel)
    showToast('Fitur export sedang dalam pengembangan', 'info');
}

// Auto-refresh dashboard every 60 seconds
setInterval(refreshDashboard, 60000);
</script>
@endpush
