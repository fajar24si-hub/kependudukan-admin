@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">

        <!-- Kartu Total Keluarga -->
        <div class="col-sm-6 col-xl-4">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Total Keluarga</p>
                    <h6 class="mb-0">{{ $totalKeluarga ?? 0 }}</h6>
                </div>
            </div>
        </div>

        <!-- Kartu Total Warga -->
        <div class="col-sm-6 col-xl-4">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-user-friends fa-3x text-success"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Total Warga</p>
                    <h6 class="mb-0">{{ $totalWarga ?? 0 }}</h6>
                </div>
            </div>
        </div>

        <!-- Kartu Total Pengguna -->
        <div class="col-sm-6 col-xl-4">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-user-shield fa-3x text-info"></i>
                <div class="ms-3 text-end">
                    <p class="mb-2">Total Pengguna</p>
                    <h6 class="mb-0">{{ $totalUser ?? 0 }}</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="bg-secondary rounded mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Statistik Data</h6>
            <small class="text-muted">Data terkini sistem</small>
        </div>
        <canvas id="dataChart" width="400" height="150"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const totalKeluarga = @json($totalKeluarga ?? 0);
        const totalWarga = @json($totalWarga ?? 0);
        const totalUser = @json($totalUser ?? 0);

        const ctx = document.getElementById('dataChart');
        if (!ctx) return;

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Keluarga', 'Warga', 'Pengguna'],
                datasets: [{
                    label: 'Jumlah Data',
                    data: [totalKeluarga, totalWarga, totalUser],
                    borderWidth: 1,
                    backgroundColor: [
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(23, 162, 184, 0.8)'
                    ],
                    borderColor: [
                        'rgba(0, 123, 255, 1)',
                        'rgba(40, 167, 69, 1)',
                        'rgba(23, 162, 184, 1)'
                    ],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush
