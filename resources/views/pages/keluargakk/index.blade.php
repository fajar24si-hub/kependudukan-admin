@extends('layouts.app')

@section('title', 'Data Keluarga KK')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-1 text-white">Data Keluarga & KK</h5>
                <p class="text-muted mb-0 small">Kelola data kartu keluarga dan anggota keluarga</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-info btn-sm">
                    <i class="fa fa-download me-1"></i>Export
                </button>
                <a href="{{ route('keluargakk.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i>Tambah KK
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @component('components.filter-card', ['action' => route('keluargakk.index')])
            <div class="col-md-4">
                <label class="form-label text-white">Cari KK</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-dark">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-dark text-white"
                           name="search" value="{{ request('search') }}"
                           placeholder="Nomor KK, alamat, nama kepala keluarga...">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label text-white">RT</label>
                <select class="form-select bg-dark border-dark text-white" name="rt">
                    <option value="">Semua RT</option>
                    @foreach($rtList as $rt)
                        <option value="{{ $rt }}" {{ request('rt') == $rt ? 'selected' : '' }}>
                            {{ $rt }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label text-white">RW</label>
                <select class="form-select bg-dark border-dark text-white" name="rw">
                    <option value="">Semua RW</option>
                    @foreach($rwList as $rw)
                        <option value="{{ $rw }}" {{ request('rw') == $rw ? 'selected' : '' }}>
                            {{ $rw }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endcomponent

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary bg-opacity-10 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $data->total() }}</h4>
                                <small class="text-muted">Total KK</small>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fa fa-home fa-2x text-primary"></i>
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
                                    foreach($data as $kk) {
                                        $totalAnggota += $kk->anggotaKeluarga->count();
                                    }
                                @endphp
                                <h4 class="mb-0">{{ $totalAnggota }}</h4>
                                <small class="text-muted">Total Anggota</small>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fa fa-users fa-2x text-success"></i>
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
                                <i class="fa fa-eye fa-2x text-info"></i>
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
                                    $avgAnggota = $data->total() > 0 ? round($totalAnggota / $data->total(), 1) : 0;
                                @endphp
                                <h4 class="mb-0">{{ $avgAnggota }}</h4>
                                <small class="text-muted">Rata-rata Anggota</small>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fa fa-chart-bar fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @component('components.data-table')
            @slot('header')
                <th width="5%" class="text-center">#</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'kk_nomor', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                       class="text-white text-decoration-none d-flex align-items-center">
                        Nomor KK
                        <i class="fa fa-sort ms-1 small"></i>
                    </a>
                </th>
                <th>Kepala Keluarga</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'alamat', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                       class="text-white text-decoration-none d-flex align-items-center">
                        Alamat
                        <i class="fa fa-sort ms-1 small"></i>
                    </a>
                </th>
                <th>RT/RW</th>
                <th>Jumlah Anggota</th>
                <th width="12%" class="text-center">Aksi</th>
            @endslot

            @slot('body')
                @forelse($data as $kk)
                <tr>
                    <td class="text-center">
                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <small class="text-primary fw-bold">{{ $loop->iteration }}</small>
                        </div>
                    </td>
                    <td>
                        <span class="text-white font-monospace">{{ $kk->kk_nomor }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa fa-user-tie text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white">
                                    @if($kk->kepalaKeluarga)
                                        {{ $kk->kepalaKeluarga->nama }}
                                    @else
                                        <span class="text-danger">Data tidak ditemukan</span>
                                    @endif
                                </h6>
                                <small class="text-muted">
                                    @if($kk->kepalaKeluarga)
                                        NIK: {{ $kk->kepalaKeluarga->nik }}
                                    @else
                                        ID: {{ $kk->kepala_keluarga_warga_id }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-white">{{ Str::limit($kk->alamat, 50) }}</span>
                    </td>
                    <td>
                        <span class="badge bg-dark">RT {{ $kk->rt }}</span>
                        <span class="badge bg-secondary">RW {{ $kk->rw }}</span>
                    </td>
                    <td>
                        <div class="text-center">
                            <h5 class="mb-0 text-white">{{ $kk->anggotaKeluarga->count() }}</h5>
                            <small class="text-muted">anggota</small>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('keluargakk.edit', $kk->kk_id) }}" class="btn btn-warning"
                               data-bs-toggle="tooltip" title="Edit KK">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-info"
                                    data-bs-toggle="tooltip" title="Detail Anggota">
                                <i class="fa fa-users"></i>
                            </button>
                            <form action="{{ route('keluargakk.destroy', $kk->kk_id) }}" method="POST"
                                  onsubmit="return confirm('Hapus data KK {{ $kk->kk_nomor }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        data-bs-toggle="tooltip" title="Hapus KK">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    @slot('empty', true)
                    @slot('emptyMessage', 'Belum ada data keluarga yang tersedia')
                    @slot('emptyAction', route('keluargakk.create'))
                @endforelse
            @endslot
        @endcomponent

        <!-- Pagination dengan info -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Menampilkan <strong>{{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $data->total() }}</strong> keluarga
            </div>
            <div>
                {{ $data->links() }}
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

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255,255,255,0.02);
}

.table-hover tbody tr:hover {
    background-color: rgba(255,255,255,0.05);
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin: 0 2px;
}

.font-monospace {
    font-family: 'Courier New', monospace;
}
</style>
@endpush

@push('scripts')
<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
@endpush
