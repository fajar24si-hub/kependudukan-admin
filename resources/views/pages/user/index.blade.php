@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="mb-1 text-white">Manajemen User</h5>
                <p class="text-muted mb-0 small">Kelola akses dan data pengguna sistem</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-info btn-sm">
                    <i class="fa fa-download me-1"></i>Export
                </button>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus me-1"></i>Tambah Data
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

        @component('components.filter-card', ['action' => route('user.index')])
    <div class="col-md-4">
        <label class="form-label text-white">Cari User</label>
        <div class="input-group">
            <span class="input-group-text bg-dark border-dark">
                <i class="fa fa-search text-muted"></i>
            </span>
            <input type="text" class="form-control bg-dark border-dark text-white"
                   name="search" value="{{ request('search') }}"
                   placeholder="Nama, email...">
        </div>
    </div>

    <div class="col-md-3">
        <label class="form-label text-white">Tanggal Dibuat</label>
        <input type="date" class="form-control bg-dark border-dark text-white"
               name="start_date" value="{{ request('start_date') }}">
    </div>

    <div class="col-md-3">
        <label class="form-label text-white">Sampai</label>
        <input type="date" class="form-control bg-dark border-dark text-white"
               name="end_date" value="{{ request('end_date') }}">
    </div>
@endcomponent

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-success bg-opacity-10 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h4 class="mb-0">{{ $users->total() }}</h4>
                                <small class="text-muted">Total User</small>
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
                                <h4 class="mb-0">{{ $users->count() }}</h4>
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
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
               class="text-white text-decoration-none d-flex align-items-center">
                Nama User
                <i class="fa fa-sort ms-1 small"></i>
            </a>
        </th>
        <th>Email</th>
        <th width="15%">Tanggal Dibuat</th>
        <th width="12%" class="text-center">Aksi</th>
    @endslot

    @slot('body')
        @forelse($users as $user)
        <tr>
            <td class="text-center">
                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                    <small class="text-primary fw-bold">{{ $loop->iteration }}</small>
                </div>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3">
                        <i class="fa fa-user text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-white">{{ $user->name }}</h6>
                        <small class="text-muted">ID: {{ $user->id }}</small>
                    </div>
                </div>
            </td>
            <td>
                <span class="text-white">{{ $user->email }}</span>
                @if($user->email_verified_at)
                <br><small class="text-success"><i class="fa fa-check-circle"></i> Terverifikasi</small>
                @else
                <br><small class="text-warning"><i class="fa fa-clock"></i> Belum verifikasi</small>
                @endif
            </td>
            <td>
                <span class="text-white">{{ $user->created_at->format('d/m/Y') }}</span>
                <br><small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning"
                       data-bs-toggle="tooltip" title="Edit User">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-info"
                            data-bs-toggle="tooltip" title="Detail User">
                        <i class="fa fa-eye"></i>
                    </button>
                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                data-bs-toggle="tooltip" title="Hapus User">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
            @slot('empty', true)
            @slot('emptyMessage', 'Belum ada data user yang tersedia')
            @slot('emptyAction', route('user.create'))
        @endforelse
    @endslot
@endcomponent

        <!-- Pagination dengan info -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Menampilkan <strong>{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $users->total() }}</strong> user
            </div>
            <div>
                {{ $users->links() }}
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
