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
        </div>
    </div>

    <!-- Quick Stats Row -->
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
                        {{ $wargaBaruBulanIni ?? 0 }} baru
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
                    <p class="text-muted mb-0">Kelahiran</p>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $kelahiranBulanIni ?? 0 }} bulan ini
                    </small>
                </div>
            </div>
        </div>

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
                            <small class="text-muted">Laki</small>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-0 text-danger">{{ $totalPerempuan ?? 0 }}</h4>
                            <small class="text-muted">Perempuan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Additional Stats -->
    <div class="row g-3 mb-4">
        <!-- Statistik Sederhana -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik 3 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    @if(!empty($monthlyStats['labels']))
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th class="text-end">Keluarga Baru</th>
                                        <th class="text-end">Warga Baru</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i < count($monthlyStats['labels']); $i++)
                                        <tr>
                                            <td>{{ $monthlyStats['labels'][$i] }}</td>
                                            <td class="text-end">{{ number_format($monthlyStats['keluarga'][$i] ?? 0) }}</td>
                                            <td class="text-end">{{ number_format($monthlyStats['warga'][$i] ?? 0) }}</td>
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

        <!-- Aktivitas Terbaru -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($recentActivities ?? [] as $activity)
                            <div class="list-group-item border-0 px-0 py-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-{{ $activity['color'] ?? 'primary' }} rounded-circle p-2">
                                            <i class="{{ $activity['icon'] ?? 'fas fa-info' }} text-white"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $activity['title'] ?? 'Aktivitas' }}</h6>
                                        <small class="text-muted">{{ $activity['description'] ?? '' }}</small>
                                        <br>
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>{{ $activity['time'] ?? 'Baru saja' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
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

    <!-- Row 3: Additional Info -->
    <div class="row g-3">
        <!-- Info Tambahan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center p-2 bg-light rounded">
                                <h4 class="mb-0">{{ number_format($totalKematian ?? 0) }}</h4>
                                <small class="text-muted">Kematian</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center p-2 bg-light rounded">
                                <h4 class="mb-0">{{ number_format($totalPindah ?? 0) }}</h4>
                                <small class="text-muted">Pindah</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <h4 class="mb-0">{{ number_format($totalUser ?? 0) }}</h4>
                                <small class="text-muted">Pengguna</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <h4 class="mb-0">{{ $avgWargaPerKeluarga ?? 0 }}</h4>
                                <small class="text-muted">Rata²/Keluarga</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Info -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3"><i class="fas fa-cogs me-2"></i>Status Sistem</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-database fa-2x text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">{{ number_format($totalWarga + $totalKeluarga) }}</h5>
                                    <small class="text-muted">Total Data</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-server fa-2x text-success"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0">Online</h5>
                                    <small class="text-muted">Status Server</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-clock fa-2x text-info"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-0" id="currentTime">{{ date('H:i:s') }}</h5>
                                    <small class="text-muted">Waktu Server</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-sync-alt me-1"></i>
                            Terakhir diperbarui: {{ now()->translatedFormat('d F Y H:i:s') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .list-group-item {
        background: transparent;
    }

    .badge.rounded-circle {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
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

    // Simple refresh button (optional)
    const refreshBtn = document.createElement('button');
    refreshBtn.className = 'btn btn-sm btn-outline-primary ms-2';
    refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i>';
    refreshBtn.onclick = function() {
        window.location.reload();
    };

    const pageTitle = document.querySelector('.page-header h1');
    if (pageTitle) {
        pageTitle.parentNode.appendChild(refreshBtn);
    }
});
</script>
@endpush
