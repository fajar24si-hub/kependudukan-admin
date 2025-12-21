@extends('layouts.app')

@section('title', 'Data Keluarga KK')
@section('subtitle', 'Kelola data kartu keluarga dan anggota keluarga')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Keluarga KK</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Data Keluarga & KK</h5>
                            <p class="text-muted mb-0">Kelola data kartu keluarga dan anggota keluarga</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                            <a href="{{ route('keluargakk.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah KK
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

                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="card border mb-4">
                        <div class="card-body">
                            <form action="{{ route('keluargakk.index') }}" method="GET" class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Cari KK</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Nomor KK, alamat, nama kepala keluarga...">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">RT</label>
                                    <select class="form-select" name="rt">
                                        <option value="">Semua RT</option>
                                        @foreach ($rtList as $rt)
                                            <option value="{{ $rt }}"
                                                {{ request('rt') == $rt ? 'selected' : '' }}>
                                                {{ $rt }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">RW</label>
                                    <select class="form-select" name="rw">
                                        <option value="">Semua RW</option>
                                        @foreach ($rwList as $rw)
                                            <option value="{{ $rw }}"
                                                {{ request('rw') == $rw ? 'selected' : '' }}>
                                                {{ $rw }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('keluargakk.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary bg-opacity-10 border-primary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 text-center">{{ $data->total() }}</h4>
                                            <small class="text-muted d-block text-center">Total KK</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-home fa-2x text-primary"></i>
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
                                            @php
                                                $totalAnggota = 0;
                                                foreach ($data as $kk) {
                                                    $totalAnggota += $kk->anggotaKeluarga->count();
                                                }
                                            @endphp
                                            <h4 class="mb-0 text-center">{{ $totalAnggota }}</h4>
                                            <small class="text-muted d-block text-center">Total Anggota</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-users fa-2x text-success"></i>
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
                                            <h4 class="mb-0 text-center">{{ $data->count() }}</h4>
                                            <small class="text-muted d-block text-center">Ditampilkan</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-eye fa-2x text-info"></i>
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
                                            @php
                                                $avgAnggota =
                                                    $data->total() > 0 ? round($totalAnggota / $data->total(), 1) : 0;
                                            @endphp
                                            <h4 class="mb-0 text-center">{{ $avgAnggota }}</h4>
                                            <small class="text-muted d-block text-center">Rata-rata Anggota</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-chart-bar fa-2x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive">
                        <table class="table table-hover" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'kk_nomor', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                            class="text-decoration-none d-flex align-items-center justify-content-center">
                                            Nomor KK
                                            <i class="fas fa-sort ms-1 small"></i>
                                        </a>
                                    </th>
                                    <th>Kepala Keluarga</th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'alamat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                            class="text-decoration-none d-flex align-items-center justify-content-center">
                                            Alamat
                                            <i class="fas fa-sort ms-1 small"></i>
                                        </a>
                                    </th>
                                    <th>RT/RW</th>
                                    <th>Jumlah Anggota</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $kk)
                                    <tr>
                                        <td>
                                            <div
                                                class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                                <small class="text-primary fw-bold">{{ $loop->iteration }}</small>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="font-monospace fw-bold">{{ $kk->kk_nomor }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div
                                                    class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user-tie text-success"></i>
                                                </div>
                                                <div class="text-start">
                                                    <h6 class="mb-0">
                                                        @if ($kk->kepalaKeluarga)
                                                            {{ $kk->kepalaKeluarga->nama }}
                                                        @else
                                                            <span class="text-danger">Data tidak ditemukan</span>
                                                        @endif
                                                    </h6>
                                                    <small class="text-muted">
                                                        @if ($kk->kepalaKeluarga)
                                                            NIK: {{ $kk->kepalaKeluarga->nik }}
                                                        @else
                                                            ID: {{ $kk->kepala_keluarga_warga_id }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span>{{ Str::limit($kk->alamat, 50) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center gap-1">
                                                <span class="badge bg-primary">RT {{ $kk->rt }}</span>
                                                <span class="badge bg-secondary">RW {{ $kk->rw }}</span>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <h5 class="mb-0">{{ $kk->anggotaKeluarga->count() }}</h5>
                                            <small class="text-muted">anggota</small>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="{{ route('keluargakk.edit', $kk->kk_id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    title="Edit KK">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('keluargakk.destroy', $kk->kk_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus data KK {{ $kk->kk_nomor }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus KK">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                                <h5>Belum ada data keluarga yang tersedia</h5>
                                                <p class="mb-0">Mulai dengan menambahkan data keluarga baru</p>
                                                <a href="{{ route('keluargakk.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus me-1"></i> Tambah KK
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($data->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Menampilkan <strong>{{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}</strong>
                                dari <strong>{{ $data->total() }}</strong> keluarga
                            </div>
                            <div>
                                {{ $data->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Tabel center alignment */
        .table {
            text-align: center !important;
        }

        .table th {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .table td {
            text-align: center !important;
            vertical-align: middle !important;
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
        }

        .table>thead {
            background-color: var(--light-color);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(var(--primary-color-rgb), 0.05);
        }

        .font-monospace {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        /* Center align untuk header sorting */
        .table th a {
            justify-content: center;
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

            // Auto-hide alerts
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
