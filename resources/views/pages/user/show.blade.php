@extends('layouts.app')

@section('title', 'Detail User')
@section('subtitle', 'Informasi lengkap pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data User</a></li>
    <li class="breadcrumb-item active">Detail User</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Detail Data User</h5>
                            <div class="badge bg-primary mt-1">
                                ID: {{ $user->id }}
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user me-2"></i> Informasi User
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $user->name }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $user->email }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Role</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                @php
                                                    $roleColors = [
                                                        'Super Admin' => 'danger',
                                                        'Administrator' => 'primary',
                                                        'Pelanggan' => 'success',
                                                        'Mitra' => 'warning',
                                                    ];
                                                    $color = $roleColors[$user->role] ?? 'secondary';
                                                @endphp
                                                <span class="text-{{ $color }} fw-bold">
                                                    {{ $user->role }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Status Akun</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                @if ($user->is_active)
                                                    <span class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="text-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Nonaktif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Dibuat</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $user->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Terakhir Diupdate</label>
                                            <div class="form-control bg-light" style="cursor: not-allowed;">
                                                {{ $user->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>

                                    @if ($user->last_login_at)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Terakhir Login</label>
                                                <div class="form-control bg-light" style="cursor: not-allowed;">
                                                    {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-camera me-2"></i> Foto Profil
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        @php
                                            $photoUrl = null;
                                            $fileExists = false;

                                            if ($user->foto_profil) {
                                                // Cek di storage public
                                                if (Storage::disk('public')->exists($user->foto_profil)) {
                                                    $photoUrl = asset('storage/' . $user->foto_profil);
                                                    $fileExists = true;
                                                }
                                                // Kompatibilitas dengan format lama
                                                elseif (
                                                    Storage::disk('public')->exists('foto-profil/' . $user->foto_profil)
                                                ) {
                                                    $photoUrl = asset('storage/foto-profil/' . $user->foto_profil);
                                                    $fileExists = true;
                                                }
                                            }
                                        @endphp

                                        @if ($fileExists && $photoUrl)
                                            <div class="position-relative d-inline-block mb-3">
                                                <img src="{{ $photoUrl }}" alt="Foto Profil"
                                                    class="img-thumbnail rounded-circle"
                                                    style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #28a745;"
                                                    onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/placeholder-user.jpg') }}'">
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            </div>
                                            <div class="file-info mb-3">
                                                <small class="text-info d-block">
                                                    <i class="fas fa-file-image me-1"></i>
                                                    {{ basename($user->foto_profil) }}
                                                </small>
                                                @if ($user->foto_profil_size)
                                                    <small class="text-info d-block">
                                                        <i class="fas fa-hdd me-1"></i>
                                                        {{ $user->foto_profil_size }}
                                                    </small>
                                                @endif
                                                <small class="text-info d-block">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Diupload:
                                                    {{ \Carbon\Carbon::parse($user->foto_profil_updated_at ?? $user->updated_at)->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        @else
                                            <div class="mb-3">
                                                <div class="avatar-lg rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                                                    style="width: 200px; height: 200px; border: 2px dashed #6c757d;">
                                                    <div class="text-center">
                                                        <img src="{{ asset('asset-admin/img/placeholder-user.jpg') }}"
                                                            alt="Placeholder User" class="img-fluid rounded-circle"
                                                            style="width: 180px; height: 180px; object-fit: cover;">
                                                    </div>
                                                </div>
                                                <p class="text-muted small mt-2">
                                                    <i class="fas fa-user me-1"></i> Menggunakan placeholder
                                                </p>
                                            </div>
                                        @endif

                                        @if ($fileExists && $photoUrl)
                                            <div class="mt-3">
                                                <a href="{{ $photoUrl }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> Lihat Full
                                                </a>
                                                <a href="{{ $photoUrl }}" download
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Edit User
                        </a>
                        @if ($user->id != Auth::id())
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i> Hapus User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus user ini? Aksi ini tidak dapat dibatalkan!');
        }
    </script>
@endpush

@push('styles')
    <style>
        .form-control[style*="cursor: not-allowed"] {
            background-color: var(--light-color) !important;
            border-color: #dee2e6 !important;
        }

        .avatar-lg {
            transition: all 0.3s ease;
        }

        .avatar-lg:hover {
            transform: scale(1.02);
        }

        .position-absolute .badge {
            font-size: 10px;
            padding: 2px 6px;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
            box-shadow: 0 0 15px rgba(40, 167, 69, 0.3);
        }

        /* Role color styling */
        .text-danger {
            color: var(--bs-danger) !important;
        }

        .text-primary {
            color: var(--bs-primary) !important;
        }

        .text-success {
            color: var(--bs-success) !important;
        }

        .text-warning {
            color: var(--bs-warning) !important;
        }
    </style>
@endpush
