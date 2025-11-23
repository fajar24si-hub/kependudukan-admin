@extends('layouts.app')

@section('title', 'Data Warga')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-1 text-white">Data Warga</h5>
                <p class="text-muted mb-0 small">Kelola data seluruh warga dengan lengkap</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-info btn-sm">
                    <i class="fa fa-download me-1"></i>Export
                </button>
                <a href="{{ route('warga.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i>Tambah Warga
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

        @component('components.filter-card', ['action' => route('warga.index')])
            <div class="col-md-3">
                <label class="form-label text-white">Cari Warga</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-dark">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control bg-dark border-dark text-white"
                           name="search" value="{{ request('search') }}"
                           placeholder="NIK, nama, alamat...">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label text-white">Jenis Kelamin</label>
                <select class="form-select bg-dark border-dark text-white" name="jenis_kelamin">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label text-white">Agama</label>
                <select class="form-select bg-dark border-dark text-white" name="agama">
                    <option value="">Semua Agama</option>
                    @foreach($agamaList as $agama)
                        <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>
                            {{ $agama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label text-white">Pendidikan</label>
                <select class="form-select bg-dark border-dark text-white" name="pendidikan">
                    <option value="">Semua Pendidikan</option>
                    @foreach($pendidikanList as $pendidikan)
                        <option value="{{ $pendidikan }}" {{ request('pendidikan') == $pendidikan ? 'selected' : '' }}>
                            {{ $pendidikan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label text-white">Tanggal Lahir Mulai</label>
                <input type="date" class="form-control bg-dark border-dark text-white"
                       name="start_date" value="{{ request('start_date') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label text-white">Tanggal Lahir Akhir</label>
                <input type="date" class="form-control bg-dark border-dark text-white"
                       name="end_date" value="{{ request('end_date') }}">
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
                                <small class="text-muted">Total Warga</small>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fa fa-users fa-2x text-primary"></i>
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
                                    $lakiCount = $data->total() > 0 ?
                                        \App\Models\Warga::when(request('search'), function($q) {
                                            $q->where('nama', 'like', '%'.request('search').'%')
                                              ->orWhere('nik', 'like', '%'.request('search').'%');
                                        })->where('jenis_kelamin', 'L')->count() : 0;
                                @endphp
                                <h4 class="mb-0">{{ $lakiCount }}</h4>
                                <small class="text-muted">Laki-laki</small>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fa fa-male fa-2x text-success"></i>
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
                                    $perempuanCount = $data->total() > 0 ?
                                        \App\Models\Warga::when(request('search'), function($q) {
                                            $q->where('nama', 'like', '%'.request('search').'%')
                                              ->orWhere('nik', 'like', '%'.request('search').'%');
                                        })->where('jenis_kelamin', 'P')->count() : 0;
                                @endphp
                                <h4 class="mb-0">{{ $perempuanCount }}</h4>
                                <small class="text-muted">Perempuan</small>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fa fa-female fa-2x text-danger"></i>
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
        </div>

        @component('components.data-table')
            @slot('header')
                <th width="5%" class="text-center">#</th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nik', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                       class="text-white text-decoration-none d-flex align-items-center">
                        NIK
                        <i class="fa fa-sort ms-1 small"></i>
                    </a>
                </th>
                <th>
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                       class="text-white text-decoration-none d-flex align-items-center">
                        Nama
                        <i class="fa fa-sort ms-1 small"></i>
                    </a>
                </th>
                <th>Jenis Kelamin</th>
                <th>Tempat/Tgl Lahir</th>
                <th>Agama</th>
                <th>Pendidikan</th>
                <th>Pekerjaan</th>
                <th width="10%" class="text-center">Aksi</th>
            @endslot

            @slot('body')
                @forelse($data as $item)
                <tr>
                    <td class="text-center">
                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                            <small class="text-primary fw-bold">{{ $loop->iteration }}</small>
                        </div>
                    </td>
                    <td>
                        <span class="text-white font-monospace">{{ $item->nik }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                                <i class="fa fa-user text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white">{{ $item->nama }}</h6>
                                <small class="text-muted">ID: {{ $item->warga_id }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($item->jenis_kelamin == 'L')
                            <span class="badge bg-success">Laki-laki</span>
                        @else
                            <span class="badge bg-danger">Perempuan</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-white">{{ $item->tempat_lahir }}</span>
                        <br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d/m/Y') }}</small>
                    </td>
                    <td>
                        <span class="text-white">{{ $item->agama }}</span>
                    </td>
                    <td>
                        <span class="text-white">{{ $item->pendidikan }}</span>
                    </td>
                    <td>
                        <span class="text-white">{{ $item->pekerjaan }}</span>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('warga.edit', $item->warga_id) }}" class="btn btn-warning"
                               data-bs-toggle="tooltip" title="Edit Warga">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST"
                                  onsubmit="return confirm('Hapus data warga {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                        data-bs-toggle="tooltip" title="Hapus Warga">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    @slot('empty', true)
                    @slot('emptyMessage', 'Belum ada data warga yang tersedia')
                    @slot('emptyAction', route('warga.create'))
                @endforelse
            @endslot
        @endcomponent

        <!-- Pagination dengan info -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Menampilkan <strong>{{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $data->total() }}</strong> warga
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
