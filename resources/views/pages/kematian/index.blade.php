{{-- resources/views/pages/kematian/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Kematian')
@section('subtitle', 'Kelola data peristiwa kematian')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Kematian</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Data Kematian</h5>
                            <p class="text-muted mb-0">Kelola data peristiwa kematian</p>
                        </div>
                        <div>
                            <a href="{{ route('peristiwa-kematian.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Kematian
                            </a>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="card border mb-4">
                        <div class="card-body">
                            <form action="{{ route('peristiwa-kematian.index') }}" method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Cari Kematian</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}" placeholder="No. Surat, sebab, lokasi...">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Filter Bulan Meninggal</label>
                                    <select name="month" class="form-select">
                                        <option value="">Semua Bulan</option>
                                        @php
                                            $months = [
                                                1 => 'Januari',
                                                2 => 'Februari',
                                                3 => 'Maret',
                                                4 => 'April',
                                                5 => 'Mei',
                                                6 => 'Juni',
                                                7 => 'Juli',
                                                8 => 'Agustus',
                                                9 => 'September',
                                                10 => 'Oktober',
                                                11 => 'November',
                                                12 => 'Desember',
                                            ];
                                        @endphp
                                        @foreach ($months as $num => $month)
                                            <option value="{{ $num }}"
                                                {{ request('month') == $num ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Tahun</label>
                                    <input type="number" class="form-control" name="year"
                                        value="{{ request('year', date('Y')) }}" min="2000" max="{{ date('Y') }}">
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Urutkan</label>
                                    <select name="sort" class="form-select">
                                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>
                                            Terbaru
                                        </option>
                                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>
                                            Terlama
                                        </option>
                                        <option value="no_surat_asc"
                                            {{ request('sort') == 'no_surat_asc' ? 'selected' : '' }}>
                                            No. Surat A-Z
                                        </option>
                                        <option value="no_surat_desc"
                                            {{ request('sort') == 'no_surat_desc' ? 'selected' : '' }}>
                                            No. Surat Z-A
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-1 d-flex align-items-end">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter me-1"></i> Filter
                                        </button>
                                        <a href="{{ route('peristiwa-kematian.index') }}"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-redo me-1"></i> Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        @php
                            use Carbon\Carbon;
                            $currentYear = date('Y');
                            $thisYearCount = 0;
                            $withFiles = $kematian
                                ->where(function ($item) {
                                    return $item->media->count() > 0;
                                })
                                ->count();

                            foreach ($kematian as $item) {
                                if ($item->tgl_meninggal) {
                                    $tglMeninggal = Carbon::parse($item->tgl_meninggal);
                                    if ($tglMeninggal->year == $currentYear) {
                                        $thisYearCount++;
                                    }
                                }
                            }
                        @endphp

                        <div class="col-md-3">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $kematian->count() }}</h4>
                                            <small class="text-muted">Total Kematian</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-cross fa-2x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-success bg-opacity-10 border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $thisYearCount }}</h4>
                                            <small class="text-muted">Tahun {{ $currentYear }}</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-calendar-alt fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-info bg-opacity-10 border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $withFiles }}</h4>
                                            <small class="text-muted">Dengan Dokumen</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-file-alt fa-2x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-warning bg-opacity-10 border-warning">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0">{{ $kematian->count() - $withFiles }}</h4>
                                            <small class="text-muted">Tanpa Dokumen</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-file-excel fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th>Warga</th>
                                    <th>Tanggal Meninggal</th>
                                    <th>Sebab</th>
                                    <th width="10%">Lokasi</th>
                                    <th width="10%">No. Surat</th>
                                    <th width="15%" style="text-align: center;">Dokumen</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kematian as $index => $item)
                                    @php
                                        $hasFiles = $item->media->count() > 0;
                                        $isNew = $item->created_at->diffInDays(now()) <= 7;
                                        $currentMonth = false;

                                        if ($item->tgl_meninggal) {
                                            $tglMeninggal = Carbon::parse($item->tgl_meninggal);
                                            $currentMonth = $tglMeninggal->month == date('n');
                                            $usiaMeninggal = $tglMeninggal->age;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <div
                                                class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <small class="text-primary fw-bold">
                                                    {{ $loop->iteration }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">
                                                        @if($item->warga)
                                                            {{ $item->warga->nama_lengkap ?? 'Tidak ada data' }}
                                                        @else
                                                            Warga tidak ditemukan
                                                        @endif
                                                    </h6>
                                                    <div class="d-flex align-items-center mt-1 gap-2">
                                                        @if ($isNew)
                                                            <span
                                                                class="badge bg-success bg-opacity-25 text-success border border-success">
                                                                <i class="fas fa-star me-1 fa-xs"></i> Baru
                                                            </span>
                                                        @endif
                                                        @if ($currentMonth)
                                                            <span
                                                                class="badge bg-info bg-opacity-25 text-info border border-info">
                                                                <i class="fas fa-calendar-alt me-1 fa-xs"></i> Bulan Ini
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt text-muted me-2 fa-xs"></i>
                                                <span>
                                                    @if ($item->tgl_meninggal)
                                                        {{ Carbon::parse($item->tgl_meninggal)->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                            @if ($item->tgl_meninggal)
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1 fa-xs"></i>
                                                    {{ Carbon::parse($item->tgl_meninggal)->diffForHumans() }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                                {{ $item->sebab }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt text-muted me-2 fa-xs"></i>
                                                <span>{{ $item->lokasi ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <code>{{ $item->no_surat }}</code>
                                        </td>
                                        <td class="text-center">
                                            @if ($hasFiles)
                                                <div class="d-flex flex-column align-items-center">
                                                    <span
                                                        class="badge bg-info bg-opacity-25 text-info border border-info px-3 py-2"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $item->media->count() }} dokumen">
                                                        <i class="fas fa-file-alt me-1"></i>
                                                        {{ $item->media->count() }}
                                                    </span>
                                                    <small class="text-muted mt-1">
                                                        @foreach ($item->media->take(2) as $media)
                                                            {{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}
                                                            @if (!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                        @if ($item->media->count() > 2)
                                                            +{{ $item->media->count() - 2 }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @else
                                                <span
                                                    class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary px-3 py-2"
                                                    data-bs-toggle="tooltip" title="Tidak ada dokumen">
                                                    <i class="fas fa-file-excel me-1"></i> 0
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('peristiwa-kematian.show', $item->kematian_id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    title="Detail Kematian">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('peristiwa-kematian.edit', $item->kematian_id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    title="Edit Kematian">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('peristiwa-kematian.destroy', $item->kematian_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirmDelete('{{ $item->no_surat }}', '{{ $item->warga->nama_lengkap ?? '' }}')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus Kematian">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-cross fa-3x mb-3" style="opacity: 0.5;"></i>
                                                <h5>Belum ada data kematian</h5>
                                                <p class="mb-0">Silahkan tambah data kematian baru untuk memulai</p>
                                                <a href="{{ route('peristiwa-kematian.create') }}"
                                                    class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus me-1"></i> Tambah Data Pertama
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .avatar-sm {
            width: 36px;
            height: 36px;
        }

        .table>thead {
            background-color: var(--light-color);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--primary-color-rgb), 0.05);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .badge {
            font-size: 0.75em;
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        code {
            background-color: rgba(var(--bs-dark-rgb), 0.1);
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-size: 0.9em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Auto-dismiss alerts
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Confirm delete function
        function confirmDelete(noSurat, namaWarga) {
            var message = 'Apakah Anda yakin ingin menghapus data kematian?';
            if (namaWarga) {
                message = 'Apakah Anda yakin ingin menghapus data kematian untuk "' + namaWarga + '" dengan nomor surat "' + noSurat + '"?';
            }
            return confirm(message);
        }
    </script>
@endpush
