@extends('layouts.app')

@section('title', 'Data User')
@section('subtitle', 'Kelola data pengguna sistem')

@section('breadcrumb')
<li class="breadcrumb-item active">Data User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-0">Data User</h5>
                        <p class="text-muted mb-0">Kelola data pengguna sistem</p>
                    </div>
                    <div>
                        <a href="{{ route('user.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Tambah User
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
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
                        <form action="{{ route('user.index') }}" method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Cari User</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control"
                                           name="search" value="{{ request('search') }}"
                                           placeholder="Nama, email, role...">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Filter Role</label>
                                <select name="role" class="form-select">
                                    <option value="">Semua Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" class="form-control"
                                       name="start_date" value="{{ request('start_date') }}">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" class="form-control"
                                       name="end_date" value="{{ request('end_date') }}">
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                    <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="card bg-primary bg-opacity-10 border-primary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-0">{{ $users->total() }}</h4>
                                        <small class="text-muted">Total User</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-users fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($roles as $role)
                    @php
                        $roleCount = $users->where('role', $role)->count();
                    @endphp
                    <div class="col-md-2">
                        <div class="card bg-info bg-opacity-10 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-0">{{ $roleCount }}</h4>
                                        <small class="text-muted">{{ $role }}</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-md-2">
                        <div class="card bg-success bg-opacity-10 border-success">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        @php
                                            $withPhoto = $users->whereNotNull('foto_profil')->count();
                                        @endphp
                                        <h4 class="mb-0">{{ $withPhoto }}</h4>
                                        <small class="text-muted">Dengan Foto</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-camera fa-2x text-success"></i>
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
                                <th width="15%">Foto Profil</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => request('direction', 'desc') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none d-flex align-items-center">
                                        Nama User
                                        <i class="fas fa-sort ms-1 small"></i>
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'email', 'direction' => request('direction', 'desc') == 'asc' ? 'desc' : 'asc']) }}"
                                       class="text-decoration-none d-flex align-items-center">
                                        Email
                                        <i class="fas fa-sort ms-1 small"></i>
                                    </a>
                                </th>
                                <th>Role</th>
                                <th width="12%">Tanggal Dibuat</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td class="text-center">
                                    <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                        <small class="text-primary fw-bold">
                                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                        </small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="avatar-frame position-relative" style="width: 70px; height: 70px;">
                                            @php
                                                $hasPhoto = false;
                                                $photoUrl = null;

                                                if ($user->foto_profil) {
                                                    // Cek apakah file ada di storage
                                                    if (Storage::disk('public')->exists($user->foto_profil)) {
                                                        $hasPhoto = true;
                                                        $photoUrl = asset('storage/' . $user->foto_profil);
                                                    }
                                                    // Jika format hanya nama file (kompatibilitas lama)
                                                    elseif (Storage::disk('public')->exists('foto-profil/' . $user->foto_profil)) {
                                                        $hasPhoto = true;
                                                        $photoUrl = asset('storage/foto-profil/' . $user->foto_profil);
                                                    }
                                                    // Jika file ada di path publik langsung
                                                    elseif (file_exists(public_path('storage/' . $user->foto_profil))) {
                                                        $hasPhoto = true;
                                                        $photoUrl = asset('storage/' . $user->foto_profil);
                                                    }
                                                }
                                            @endphp

                                            @if($hasPhoto && $photoUrl)
                                                <img src="{{ $photoUrl }}"
                                                     alt="Foto Profil {{ $user->name }}"
                                                     class="img-fluid rounded-circle w-100 h-100"
                                                     style="object-fit: cover; border: 2px solid #28a745;"
                                                     onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/placeholder-user.jpg') }}'">
                                                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                                                    <i class="fas fa-camera fa-xs text-white"></i>
                                                </span>
                                            @else
                                                <img src="{{ asset('asset-admin/img/placeholder-user.jpg') }}"
                                                     alt="Foto Profil {{ $user->name }}"
                                                     class="img-fluid rounded-circle w-100 h-100"
                                                     style="object-fit: cover; border: 2px dashed #6c757d; opacity: 0.8;">
                                                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-secondary border border-light rounded-circle">
                                                    <i class="fas fa-user fa-xs text-white"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <div class="d-flex align-items-center mt-1 gap-2">
                                                @php
                                                    $hasPhoto = false;
                                                    if ($user->foto_profil) {
                                                        if (Storage::disk('public')->exists($user->foto_profil) ||
                                                            Storage::disk('public')->exists('foto-profil/' . $user->foto_profil) ||
                                                            file_exists(public_path('storage/' . $user->foto_profil))) {
                                                            $hasPhoto = true;
                                                        }
                                                    }
                                                @endphp

                                                @if($hasPhoto)
                                                    <span class="badge bg-success bg-opacity-25 text-success border border-success">
                                                        <i class="fas fa-camera me-1 fa-xs"></i> Foto
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary">
                                                        <i class="fas fa-user me-1 fa-xs"></i> Default
                                                    </span>
                                                @endif
                                                @if($user->is_active)
                                                    <span class="badge bg-success bg-opacity-25 text-success border border-success">
                                                        <i class="fas fa-circle me-1 fa-xs"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-25 text-danger border border-danger">
                                                        <i class="fas fa-circle me-1 fa-xs"></i> Nonaktif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-envelope text-muted me-2 fa-xs"></i>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                    @if($user->email_verified_at)
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1 fa-xs"></i> Terverifikasi
                                        </small>
                                    @else
                                        <small class="text-warning">
                                            <i class="fas fa-clock me-1 fa-xs"></i> Belum verifikasi
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $roleColors = [
                                                'Super Admin' => 'danger',
                                                'Administrator' => 'primary',
                                                'Pelanggan' => 'success',
                                                'Mitra' => 'warning'
                                            ];
                                            $color = $roleColors[$user->role] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }} bg-opacity-25 text-{{ $color }} border border-{{ $color }} px-3 py-2">
                                            <i class="fas fa-user-tag me-1 fa-xs"></i> {{ $user->role }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">{{ $user->created_at->format('d/m/Y') }}</small>
                                        <small>{{ $user->created_at->format('H:i') }}</small>
                                        @if($user->created_at->diffInDays(now()) <= 7)
                                            <small class="text-success">
                                                <i class="fas fa-star fa-xs me-1"></i> Baru
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-info"
                                           data-bs-toggle="tooltip" title="Detail User">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning"
                                           data-bs-toggle="tooltip" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->id != Auth::id())
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirmDelete('{{ $user->name }}')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip" title="Hapus User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="btn btn-sm btn-danger disabled"
                                                data-bs-toggle="tooltip" title="Tidak dapat menghapus diri sendiri">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <img src="{{ asset('asset-admin/img/placeholder-user.jpg') }}"
                                             alt="No Users"
                                             class="rounded-circle mb-3"
                                             style="width: 80px; height: 80px; object-fit: cover; opacity: 0.5;">
                                        <h5>Belum ada data user</h5>
                                        <p class="mb-0">Silahkan tambah user baru untuk memulai</p>
                                        <a href="{{ route('user.create') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-plus me-1"></i> Tambah User Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan
                        <strong>{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $users->total() }}</strong> user

                        @if(request()->has('search') && !empty(request('search')))
                            <span class="ms-2">
                                <i class="fas fa-search me-1"></i> Filter: "{{ request('search') }}"
                            </span>
                        @endif
                        @if(request()->has('role') && !empty(request('role')))
                            <span class="ms-2">
                                <i class="fas fa-filter me-1"></i> Role: {{ request('role') }}
                            </span>
                        @endif
                    </div>
                    <div>
                        {{ $users->appends(request()->query())->links() }}
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

.avatar-frame {
    transition: all 0.3s ease;
    border-radius: 50%;
    overflow: hidden;
}

.avatar-frame:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(0, 123, 255, 0.3);
}

.table > thead {
    background-color: var(--light-color);
}

.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,0.02);
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

.position-absolute {
    font-size: 10px;
    padding: 2px 4px;
}

.img-thumbnail {
    transition: all 0.3s ease;
}

.img-thumbnail:hover {
    transform: scale(1.1);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
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
function confirmDelete(userName) {
    return confirm('Apakah Anda yakin ingin menghapus user "' + userName + '"?');
}

// Image error handling with fallback
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    const placeholderUrl = '{{ asset("asset-admin/img/placeholder-user.jpg") }}';

    images.forEach(img => {
        // Jika gambar gagal load
        img.addEventListener('error', function() {
            if (!this.src.includes('placeholder-user.jpg')) {
                console.log('Image failed to load:', this.src);
                this.src = placeholderUrl;
                this.style.opacity = '0.8';
                this.style.borderStyle = 'dashed';
                this.style.borderColor = '#6c757d';

                // Update badge jika ada
                const parentRow = this.closest('tr');
                if (parentRow) {
                    const photoBadge = parentRow.querySelector('.badge');
                    if (photoBadge && photoBadge.innerHTML.includes('Foto')) {
                        photoBadge.innerHTML = '<i class="fas fa-user me-1 fa-xs"></i> Default';
                        photoBadge.className = 'badge bg-secondary bg-opacity-25 text-secondary border border-secondary';
                    }
                }
            }
        });

        // Cek gambar yang sudah selesai load tapi mungkin gagal
        if (img.complete) {
            if (img.naturalHeight === 0 || img.naturalWidth === 0) {
                if (!img.src.includes('placeholder-user.jpg')) {
                    console.log('Image loaded but zero dimensions:', img.src);
                    img.src = placeholderUrl;
                }
            }
        }
    });
});

// Debug function untuk cek foto
function debugUserPhoto(userId) {
    fetch(`/api/debug-user-photo/${userId}`)
        .then(response => response.json())
        .then(data => {
            console.log('Photo debug info:', data);
            if (data.exists && data.url) {
                alert(`Foto ditemukan:\nPath: ${data.path}\nURL: ${data.url}`);
            } else {
                alert('Foto tidak ditemukan atau path tidak valid.');
            }
        })
        .catch(error => console.error('Debug error:', error));
}
</script>
@endpush
