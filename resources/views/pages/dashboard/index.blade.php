@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <!-- Header Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </h4>
                <div class="page-title-right">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        <span class="ms-2">
                            <i class="fas fa-clock me-1"></i>
                            <span id="currentTime">{{ date('H:i:s') }}</span>
                        </span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Session -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Quick Stats Row -->
    <div class="row g-4 mb-4">
        <!-- Kartu Total Keluarga -->
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100 dashboard-card" data-bs-toggle="tooltip" title="Jumlah keluarga terdaftar">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Total Keluarga</h6>
                            <h2 class="mb-0" id="totalKeluarga">{{ number_format($totalKeluarga ?? 0) }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-primary bg-opacity-25 text-primary">
                                    <i class="fas fa-home me-1"></i> Terdaftar
                                </span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-chart-line me-1"></i>
                            <span id="keluargaBulanIni">{{ $keluargaBaruBulanIni ?? 0 }}</span> keluarga baru bulan ini
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Total Warga -->
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100 dashboard-card" data-bs-toggle="tooltip" title="Jumlah warga terdaftar">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Total Warga</h6>
                            <h2 class="mb-0" id="totalWarga">{{ number_format($totalWarga ?? 0) }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-success bg-opacity-25 text-success">
                                    <i class="fas fa-user me-1"></i> Individu
                                </span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-lg bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-friends fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-calculator me-1"></i>
                            Rata-rata {{ $avgWargaPerKeluarga ?? 0 }} warga per keluarga
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Total Pengguna -->
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100 dashboard-card" data-bs-toggle="tooltip" title="Jumlah pengguna sistem">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Total Pengguna</h6>
                            <h2 class="mb-0" id="totalUser">{{ number_format($totalUser ?? 0) }}</h2>
                            <div class="mt-2">
                                <span class="badge bg-info bg-opacity-25 text-info">
                                    <i class="fas fa-user-shield me-1"></i> Sistem
                                </span>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-lg bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-shield fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-user-check me-1"></i>
                            {{ $activeUsers ?? 0 }} pengguna aktif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Vital Statistics -->
    <div class="row g-4 mb-4" id="vitalStatsRow">
        <!-- Kartu Kelahiran -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Kelahiran</h6>
                            <h4 class="mb-0">{{ number_format($totalKelahiran ?? 0) }}</h4>
                            <small class="text-muted">
                                <i class="fas fa-baby me-1"></i> Tahun {{ date('Y') }}
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-md bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-baby fa-lg text-warning"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                             style="width: {{ min(($kelahiranBulanIni ?? 0) * 20, 100) }}%;"
                             aria-valuenow="{{ $kelahiranBulanIni ?? 0 }}"
                             aria-valuemin="0"
                             aria-valuemax="5"></div>
                    </div>
                    <small class="text-muted d-block mt-1">
                        {{ $kelahiranBulanIni ?? 0 }} kelahiran bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Kematian -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Kematian</h6>
                            <h4 class="mb-0">{{ number_format($totalKematian ?? 0) }}</h4>
                            <small class="text-muted">
                                <i class="fas fa-cross me-1"></i> Tahun {{ date('Y') }}
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-md bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-cross fa-lg text-danger"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-danger" role="progressbar"
                             style="width: {{ min(($kematianBulanIni ?? 0) * 20, 100) }}%;"
                             aria-valuenow="{{ $kematianBulanIni ?? 0 }}"
                             aria-valuemin="0"
                             aria-valuemax="5"></div>
                    </div>
                    <small class="text-muted d-block mt-1">
                        {{ $kematianBulanIni ?? 0 }} kematian bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Pindah -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Pindah</h6>
                            <h4 class="mb-0">{{ number_format($totalPindah ?? 0) }}</h4>
                            <small class="text-muted">
                                <i class="fas fa-truck-moving me-1"></i> Tahun {{ date('Y') }}
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-md bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-truck-moving fa-lg text-secondary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-secondary" role="progressbar"
                             style="width: {{ min(($pindahBulanIni ?? 0) * 20, 100) }}%;"
                             aria-valuenow="{{ $pindahBulanIni ?? 0 }}"
                             aria-valuemin="0"
                             aria-valuemax="5"></div>
                    </div>
                    <small class="text-muted d-block mt-1">
                        {{ $pindahBulanIni ?? 0 }} pindah bulan ini
                    </small>
                </div>
            </div>
        </div>

        <!-- Kartu Warga Baru -->
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2">Warga Baru</h6>
                            <h4 class="mb-0">{{ number_format($datangBulanIni ?? 0) }}</h4>
                            <small class="text-muted">
                                <i class="fas fa-user-plus me-1"></i> Bulan {{ date('F') }}
                            </small>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-md bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-plus fa-lg text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: {{ min(($datangBulanIni ?? 0) * 10, 100) }}%;"
                             aria-valuenow="{{ $datangBulanIni ?? 0 }}"
                             aria-valuemin="0"
                             aria-valuemax="10"></div>
                    </div>
                    <small class="text-muted d-block mt-1">
                        Warga baru bulan ini
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Charts -->
    <div class="row g-4">
        <!-- Main Chart -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i> Statistik Data 12 Bulan Terakhir
                        </h6>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="changeChartType('bar')">
                                    <i class="fas fa-chart-bar me-2"></i> Bar Chart
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="changeChartType('line')">
                                    <i class="fas fa-chart-line me-2"></i> Line Chart
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="toggleDataset('keluarga')">
                                    <i class="fas fa-users me-2"></i> Toggle Keluarga
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="toggleDataset('warga')">
                                    <i class="fas fa-user-friends me-2"></i> Toggle Warga
                                </a></li>
                                <li><a class="dropdown-item" href="#" onclick="toggleDataset('kelahiran')">
                                    <i class="fas fa-baby me-2"></i> Toggle Kelahiran
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="mainChart" height="300"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Klik pada legenda chart untuk menampilkan/sembunyikan data
                    </small>
                </div>
            </div>
        </div>

        <!-- Right Side: Gender Chart & Recent Activity -->
        <div class="col-xl-4">
            <!-- Gender Chart -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-pie me-2"></i> Distribusi Jenis Kelamin
                        </h6>
                        <div class="badge bg-info">
                            {{ number_format($totalLaki + $totalPerempuan) }} Total
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" height="200"></canvas>
                    <div class="row mt-3 text-center">
                        <div class="col-6">
                            <div class="bg-primary bg-opacity-10 rounded p-2">
                                <h5 class="mb-0 text-primary">{{ $totalLaki }}</h5>
                                <small class="text-muted">Laki-laki</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-danger bg-opacity-10 rounded p-2">
                                <h5 class="mb-0 text-danger">{{ $totalPerempuan }}</h5>
                                <small class="text-muted">Perempuan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-history me-2"></i> Aktivitas Terbaru
                        </h6>
                        <span class="badge bg-primary">{{ count($recentActivities ?? []) }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        @forelse($recentActivities ?? [] as $activity)
                        <div class="activity-item d-flex mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="{{ $activity['icon'] ?? 'fas fa-info-circle' }} text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $activity['title'] ?? 'Aktivitas' }}</h6>
                                <p class="text-muted mb-1">{{ $activity['description'] ?? '' }}</p>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $activity['time'] ?? 'Baru saja' }}
                                </small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-3">
                            <i class="fas fa-history fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">Tidak ada aktivitas terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 text-center">
                    <small class="text-muted">
                        <i class="fas fa-sync-alt me-1"></i>
                        Data diperbarui otomatis setiap 5 menit
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard-card {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

.dashboard-card:nth-child(1):hover {
    border-left-color: var(--bs-primary);
}

.dashboard-card:nth-child(2):hover {
    border-left-color: var(--bs-success);
}

.dashboard-card:nth-child(3):hover {
    border-left-color: var(--bs-info);
}

.avatar-lg {
    width: 60px;
    height: 60px;
}

.avatar-md {
    width: 45px;
    height: 45px;
}

.avatar-sm {
    width: 36px;
    height: 36px;
}

.page-title-box {
    padding: 10px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.activity-item {
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.activity-item:last-child {
    border-bottom: none;
}

.progress {
    border-radius: 10px;
    background-color: rgba(0,0,0,0.05);
}

.badge {
    font-weight: 500;
    font-size: 0.8em;
}

.chart-container {
    position: relative;
    height: 300px;
}
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // ==================== DATA DARI CONTROLLER ====================
    // Ambil data statistik bulanan dari controller
    const monthlyStats = @json($monthlyStats ?? []);

    // Main Chart Data
    const months = monthlyStats.labels || ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const keluargaData = monthlyStats.keluarga || Array(12).fill(0);
    const wargaData = monthlyStats.warga || Array(12).fill(0);
    const kelahiranData = monthlyStats.kelahiran || Array(12).fill(0);
    const kematianData = monthlyStats.kematian || Array(12).fill(0);
    const pindahData = monthlyStats.pindah || Array(12).fill(0);

    // Data untuk chart utama
    let datasets = [
        {
            label: 'Keluarga',
            data: keluargaData,
            borderColor: 'rgba(0, 123, 255, 1)',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(0, 123, 255, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        },
        {
            label: 'Warga',
            data: wargaData,
            borderColor: 'rgba(40, 167, 69, 1)',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgba(40, 167, 69, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        },
        {
            label: 'Kelahiran',
            data: kelahiranData,
            borderColor: 'rgba(255, 193, 7, 1)',
            backgroundColor: 'rgba(255, 193, 7, 0.1)',
            borderWidth: 2,
            fill: false,
            tension: 0.4,
            pointBackgroundColor: 'rgba(255, 193, 7, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 3,
            pointHoverRadius: 5,
            hidden: true
        },
        {
            label: 'Kematian',
            data: kematianData,
            borderColor: 'rgba(220, 53, 69, 1)',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            borderWidth: 2,
            fill: false,
            tension: 0.4,
            pointBackgroundColor: 'rgba(220, 53, 69, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 3,
            pointHoverRadius: 5,
            hidden: true
        }
    ];
    // ==================== END DATA DARI CONTROLLER ====================

    // Main Chart
    const mainCtx = document.getElementById('mainChart');
    let mainChart = null;

    if (mainCtx) {
        mainChart = new Chart(mainCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('id-ID');
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Chart Functions
        window.changeChartType = function(type) {
            if (mainChart) {
                mainChart.config.type = type;
                mainChart.update();
            }
        };

        window.toggleDataset = function(datasetName) {
            if (mainChart) {
                const dataset = mainChart.data.datasets.find(ds =>
                    ds.label.toLowerCase().includes(datasetName.toLowerCase())
                );
                if (dataset) {
                    dataset.hidden = !dataset.hidden;
                    mainChart.update();
                }
            }
        };
    }

    // Gender Pie Chart
    const genderCtx = document.getElementById('genderChart');
    if (genderCtx) {
        const totalLaki = {{ $totalLaki ?? 0 }};
        const totalPerempuan = {{ $totalPerempuan ?? 0 }};
        const totalGender = totalLaki + totalPerempuan;

        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [totalLaki, totalPerempuan],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const percentage = totalGender > 0 ?
                                    Math.round((context.parsed / totalGender) * 100) : 0;
                                return `${context.label}: ${context.parsed.toLocaleString('id-ID')} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Update current time every second
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
    updateCurrentTime(); // Initial call

    // Auto-refresh stats every 5 minutes
    function refreshDashboardStats() {
        fetch('/dashboard/quick-stats')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const stats = data.data;

                    // Update main cards
                    document.getElementById('totalKeluarga').textContent = stats.totalKeluarga.toLocaleString('id-ID');
                    document.getElementById('totalWarga').textContent = stats.totalWarga.toLocaleString('id-ID');
                    document.getElementById('totalUser').textContent = stats.totalUser.toLocaleString('id-ID');
                    document.getElementById('keluargaBulanIni').textContent = stats.keluargaBaruBulanIni;

                    // Show update notification
                    const timeElement = document.querySelector('.page-title-right small');
                    if (timeElement) {
                        timeElement.innerHTML = `<i class="fas fa-sync-alt me-1"></i> Diperbarui: ${stats.server_time}`;

                        // Revert after 10 seconds
                        setTimeout(() => {
                            const now = new Date();
                            const options = {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            };
                            timeElement.innerHTML = `<i class="fas fa-calendar-alt me-1"></i> ${now.toLocaleDateString('id-ID', options)}`;
                        }, 10000);
                    }

                    console.log('Dashboard stats refreshed at:', stats.timestamp);
                }
            })
            .catch(error => {
                console.error('Error refreshing dashboard stats:', error);
            });
    }

    // Refresh every 5 minutes (300000 ms)
    setInterval(refreshDashboardStats, 300000);

    // Also refresh when tab becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            refreshDashboardStats();
        }
    });

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endpush
