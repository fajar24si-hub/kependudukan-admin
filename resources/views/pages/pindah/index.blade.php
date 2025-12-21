{{-- resources/views/pages/pindah/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Perpindahan')
@section('subtitle', 'Kelola data peristiwa pindah')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Perpindahan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Data Perpindahan</h5>
                            <p class="text-muted mb-0">Kelola data peristiwa pindah</p>
                        </div>
                        <div>
                            <a href="{{ route('pindah.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Pindah
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
                            <form action="{{ route('pindah.index') }}" method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Cari Perpindahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}" placeholder="No. Surat, alasan, alamat tujuan...">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Filter Bulan Pindah</label>
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
                                        <a href="{{ route('pindah.index') }}"
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
                            $withFiles = $peristiwaPindah
                                ->where(function ($item) {
                                    return $item->media->count() > 0;
                                })
                                ->count();

                            foreach ($peristiwaPindah as $item) {
                                if ($item->tgl_pindah) {
                                    $tglPindah = Carbon::parse($item->tgl_pindah);
                                    if ($tglPindah->year == $currentYear) {
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
                                            <h4 class="mb-0">{{ $peristiwaPindah->count() }}</h4>
                                            <small class="text-muted">Total Perpindahan</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-truck-moving fa-2x text-primary"></i>
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
                                            <h4 class="mb-0">{{ $peristiwaPindah->count() - $withFiles }}</h4>
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
                                    <th>Tanggal Pindah</th>
                                    <th>Alasan</th>
                                    <th width="15%">Alamat Tujuan</th>
                                    <th width="10%">No. Surat</th>
                                    <th width="15%" style="text-align: center;">Dokumen</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peristiwaPindah as $index => $item)
                                    @php
                                        $hasFiles = $item->media->count() > 0;
                                        $isNew = $item->created_at->diffInDays(now()) <= 7;
                                        $currentMonth = false;

                                        if ($item->tgl_pindah) {
                                            $tglPindah = Carbon::parse($item->tgl_pindah);
                                            $currentMonth = $tglPindah->month == date('n');
                                            $lamaPindah = $tglPindah->diffForHumans(null, true);
                                        }

                                        // Hitung urutan pindah untuk warga ini
                                        $urutanPindah = App\Models\PeristiwaPindah::where('warga_id', $item->warga_id)
                                            ->where('tgl_pindah', '<=', $item->tgl_pindah)
                                            ->count();
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
                                                            {{ $item->warga->nama }}
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
                                                        @if ($urutanPindah > 1)
                                                            <span
                                                                class="badge bg-warning bg-opacity-25 text-warning border border-warning">
                                                                <i class="fas fa-redo me-1 fa-xs"></i> Pindah ke-{{ $urutanPindah }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($item->warga)
                                                    <small class="text-muted">
                                                        NIK: {{ $item->warga->nik }}
                                                    </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt text-muted me-2 fa-xs"></i>
                                                <span>
                                                    @if ($item->tgl_pindah)
                                                        {{ Carbon::parse($item->tgl_pindah)->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </div>
                                            @if ($item->tgl_pindah)
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1 fa-xs"></i>
                                                    {{ Carbon::parse($item->tgl_pindah)->diffForHumans() }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                                {{ $item->alasan }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-map-marker-alt text-muted me-2 fa-xs"></i>
                                                <span>{{ \Illuminate\Support\Str::limit($item->alamat_tujuan, 30) }}</span>
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
                                                <a href="{{ route('pindah.show', $item->pindah_id) }}"
                                                    class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    title="Detail Pindah">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('pindah.edit', $item->pindah_id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    title="Edit Pindah">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form
                                                    action="{{ route('pindah.destroy', $item->pindah_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirmDelete('{{ $item->no_surat }}', '{{ $item->warga->nama ?? '' }}')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus Pindah">
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
                                                <i class="fas fa-truck-moving fa-3x mb-3" style="opacity: 0.5;"></i>
                                                <h5>Belum ada data perpindahan</h5>
                                                <p class="mb-0">Silahkan tambah data perpindahan baru untuk memulai</p>
                                                <a href="{{ route('pindah.create') }}"
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
            var message = 'Apakah Anda yakin ingin menghapus data perpindahan?';
            if (namaWarga) {
                message = 'Apakah Anda yakin ingin menghapus data perpindahan untuk "' + namaWarga + '" dengan nomor surat "' + noSurat + '"?';
            }
            return confirm(message);
        }
    </script>
@endpush
