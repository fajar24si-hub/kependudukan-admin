@extends('layouts.app')

@section('title', 'Data Warga')
@section('subtitle', 'Kelola data seluruh warga dengan lengkap')

@section('breadcrumb')
    <li class="breadcrumb-item active">Data Warga</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Data Warga</h5>
                            <p class="text-muted mb-0">Kelola data seluruh warga dengan lengkap</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-info">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                            <a href="{{ route('warga.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Tambah Warga
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
                            <form action="{{ route('warga.index') }}" method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Cari Warga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request('search') }}" placeholder="NIK, nama, alamat...">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" name="jenis_kelamin">
                                        <option value="">Semua</option>
                                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Agama</label>
                                    <select class="form-select" name="agama">
                                        <option value="">Semua Agama</option>
                                        @foreach ($agamaList as $agama)
                                            <option value="{{ $agama }}"
                                                {{ request('agama') == $agama ? 'selected' : '' }}>
                                                {{ $agama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Pendidikan</label>
                                    <select class="form-select" name="pendidikan">
                                        <option value="">Semua Pendidikan</option>
                                        @foreach ($pendidikanList as $pendidikan)
                                            <option value="{{ $pendidikan }}"
                                                {{ request('pendidikan') == $pendidikan ? 'selected' : '' }}>
                                                {{ $pendidikan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Lahir Mulai</label>
                                    <input type="date" class="form-control" name="start_date"
                                        value="{{ request('start_date') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Lahir Akhir</label>
                                    <input type="date" class="form-control" name="end_date"
                                        value="{{ request('end_date') }}">
                                </div>

                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('warga.index') }}" class="btn btn-outline-secondary">
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
                                            <h4 class="mb-0">{{ $data->total() }}</h4>
                                            <small class="text-muted">Total Warga</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-users fa-2x text-primary"></i>
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
                                                $lakiCount =
                                                    $data->total() > 0
                                                        ? \App\Models\Warga::when(request('search'), function ($q) {
                                                            $q->where(
                                                                'nama',
                                                                'like',
                                                                '%' . request('search') . '%',
                                                            )->orWhere('nik', 'like', '%' . request('search') . '%');
                                                        })
                                                            ->where('jenis_kelamin', 'L')
                                                            ->count()
                                                        : 0;
                                            @endphp
                                            <h4 class="mb-0">{{ $lakiCount }}</h4>
                                            <small class="text-muted">Laki-laki</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-male fa-2x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger bg-opacity-10 border-danger">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            @php
                                                $perempuanCount =
                                                    $data->total() > 0
                                                        ? \App\Models\Warga::when(request('search'), function ($q) {
                                                            $q->where(
                                                                'nama',
                                                                'like',
                                                                '%' . request('search') . '%',
                                                            )->orWhere('nik', 'like', '%' . request('search') . '%');
                                                        })
                                                            ->where('jenis_kelamin', 'P')
                                                            ->count()
                                                        : 0;
                                            @endphp
                                            <h4 class="mb-0">{{ $perempuanCount }}</h4>
                                            <small class="text-muted">Perempuan</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-female fa-2x text-danger"></i>
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
                                            <h4 class="mb-0">{{ $data->count() }}</h4>
                                            <small class="text-muted">Ditampilkan</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-eye fa-2x text-info"></i>
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
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nik', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                            class="text-decoration-none d-flex align-items-center">
                                            NIK
                                            <i class="fas fa-sort ms-1 small"></i>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                                            class="text-decoration-none d-flex align-items-center">
                                            Nama
                                            <i class="fas fa-sort ms-1 small"></i>
                                        </a>
                                    </th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat/Tgl Lahir</th>
                                    <th>Agama</th>
                                    <th>Pendidikan</th>
                                    <th>Pekerjaan</th>
                                    <th width="12%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-center">
                                            <div
                                                class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                <small
                                                    class="text-primary fw-bold">{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="font-monospace fw-bold">{{ $item->nik }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div
                                                    class="avatar-sm bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                                    <i class="fas fa-user text-info"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $item->nama }}</h6>
                                                    <small class="text-muted">ID: {{ $item->warga_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->jenis_kelamin == 'L')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-male me-1"></i> Laki-laki
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-female me-1"></i> Perempuan
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <span>{{ $item->tempat_lahir }}</span>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}
                                                    ({{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} tahun)
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->agama }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->pendidikan }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $item->pekerjaan }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('warga.edit', $item->warga_id) }}"
                                                    class="btn btn-sm btn-warning" data-bs-toggle="tooltip"
                                                    title="Edit Warga">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="#" class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                    title="Detail Warga">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('warga.destroy', $item->warga_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Hapus data warga {{ $item->nama }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="tooltip" title="Hapus Warga">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-user-slash fa-3x mb-3"></i>
                                                <h5>Belum ada data warga yang tersedia</h5>
                                                <p class="mb-0">Mulai dengan menambahkan data warga baru</p>
                                                <a href="{{ route('warga.create') }}" class="btn btn-primary mt-3">
                                                    <i class="fas fa-plus me-1"></i> Tambah Warga
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
                                dari <strong>{{ $data->total() }}</strong> warga
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
