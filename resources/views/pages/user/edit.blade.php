@extends('layouts.app')

@section('title', 'Edit User')
@section('subtitle', 'Perbarui informasi pengguna')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data User</a></li>
    <li class="breadcrumb-item active">Edit User</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">Edit Data User</h5>
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
                    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                        id="userForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card border mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-user-edit me-2"></i> Informasi User
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Nama Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $user->name) }}" required minlength="3"
                                                    maxlength="100">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Role <span class="text-danger">*</span>
                                                </label>
                                                <select name="role"
                                                    class="form-select @error('role') is-invalid @enderror" required
                                                    id="roleSelect">
                                                    @foreach ($roles as $role)
                                                        @php
                                                            $roleColors = [
                                                                'Super Admin' => 'danger',
                                                                'Administrator' => 'primary',
                                                                'Pelanggan' => 'success',
                                                                'Mitra' => 'warning',
                                                            ];
                                                            $color = $roleColors[$role] ?? 'secondary';
                                                        @endphp
                                                        <option value="{{ $role }}"
                                                            {{ old('role', $user->role) == $role ? 'selected' : '' }}
                                                            data-color="{{ $color }}">
                                                            {{ $role }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Status Akun
                                                </label>
                                                <select name="is_active"
                                                    class="form-select @error('is_active') is-invalid @enderror">
                                                    <option value="1"
                                                        {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>
                                                        Aktif
                                                    </option>
                                                    <option value="0"
                                                        {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>
                                                        Nonaktif
                                                    </option>
                                                </select>
                                                @error('is_active')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Password Baru
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Kosongkan jika tidak ingin mengubah" minlength="8"
                                                        id="passwordInput">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('passwordInput', this)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">
                                                    Kosongkan jika tidak ingin mengubah password
                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    Konfirmasi Password
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        placeholder="Konfirmasi password baru" id="confirmPasswordInput">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('confirmPasswordInput', this)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                <div class="password-match mt-2" style="display: none;">
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i> Password cocok
                                                    </small>
                                                </div>
                                                <div class="password-not-match mt-2" style="display: none;">
                                                    <small class="text-danger">
                                                        <i class="fas fa-times-circle me-1"></i> Password tidak cocok
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <h6 class="card-title">Informasi Sistem</h6>
                                                        <div class="mb-2">
                                                            <small class="text-muted">Dibuat:</small>
                                                            <div>{{ $user->created_at->format('d/m/Y H:i') }}</div>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Diperbarui:</small>
                                                            <div>{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="mb-3">
                                            <label class="form-label">
                                                Upload Foto Baru
                                            </label>
                                            <input type="file" name="foto_profil"
                                                class="form-control @error('foto_profil') is-invalid @enderror"
                                                accept="image/*" id="fotoInput" onchange="previewImage(this)">
                                            @error('foto_profil')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.
                                            </small>
                                        </div>

                                        <div class="text-center">
                                            <!-- Preview untuk foto baru -->
                                            <div id="imagePreview" class="mb-3" style="display: none;">
                                                <div class="position-relative d-inline-block">
                                                    <img id="previewImg" class="img-thumbnail rounded-circle"
                                                        style="width: 180px; height: 180px; object-fit: cover; border: 3px solid #6c757d;"
                                                        alt="Preview Foto Baru">
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                        onclick="removeImage()" style="transform: translate(50%, -50%);">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <p class="text-muted small mt-2">
                                                    <i class="fas fa-image me-1"></i> Preview Foto Baru
                                                </p>
                                            </div>

                                            <!-- Foto saat ini -->
                                            <div id="currentPhoto" class="mb-3">
                                                @php
                                                    $currentPhotoUrl = null;
                                                    $currentPhotoExists = false;

                                                    if ($user->foto_profil) {
                                                        if (Storage::disk('public')->exists($user->foto_profil)) {
                                                            $currentPhotoUrl = asset('storage/' . $user->foto_profil);
                                                            $currentPhotoExists = true;
                                                        } elseif (
                                                            Storage::disk('public')->exists(
                                                                'foto-profil/' . $user->foto_profil,
                                                            )
                                                        ) {
                                                            $currentPhotoUrl = asset(
                                                                'storage/foto-profil/' . $user->foto_profil,
                                                            );
                                                            $currentPhotoExists = true;
                                                        }
                                                    }
                                                @endphp

                                                @if ($currentPhotoExists && $currentPhotoUrl)
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ $currentPhotoUrl }}" alt="Foto Profil Saat Ini"
                                                            class="img-thumbnail rounded-circle"
                                                            style="width: 180px; height: 180px; object-fit: cover; border: 3px solid #28a745;"
                                                            id="currentImg"
                                                            onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/placeholder-user.jpg') }}'">
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    </div>
                                                    <p class="text-muted small mt-2">
                                                        <i class="fas fa-image me-1"></i> Foto saat ini
                                                    </p>
                                                    <div class="mt-2">
                                                        <small class="text-info d-block">
                                                            <i class="fas fa-file-image me-1"></i>
                                                            File: {{ basename($user->foto_profil) }}
                                                        </small>
                                                        @if ($user->foto_profil_size)
                                                            <small class="text-info d-block">
                                                                <i class="fas fa-hdd me-1"></i>
                                                                Size: {{ $user->foto_profil_size }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="avatar-lg rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                                                        style="width: 180px; height: 180px; border: 2px dashed #6c757d;">
                                                        <div class="text-center">
                                                            <img src="{{ asset('asset-admin/img/placeholder-user.jpg') }}"
                                                                alt="Placeholder User" class="img-fluid rounded-circle"
                                                                style="width: 160px; height: 160px; object-fit: cover;">
                                                            
                                                        </div>
                                                    </div>
                                                    <p class="text-muted small mt-2">
                                                        <i class="fas fa-user me-1"></i> Menggunakan placeholder
                                                    </p>
                                                @endif
                                            </div>

                                            @if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil))
                                                <div class="mt-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="remove_photo" id="removePhoto">
                                                        <label class="form-check-label small" for="removePhoto">
                                                            Hapus foto saat ini
                                                        </label>
                                                    </div>
                                                    <small class="text-muted">
                                                        Jika dicentang, foto akan dihapus dan diganti dengan placeholder
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Perbarui User
                            </button>
                            <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo me-1"></i> Reset Perubahan
                            </button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fotoInput = document.getElementById('fotoInput');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const currentPhoto = document.getElementById('currentPhoto');
            const currentImg = document.getElementById('currentImg');
            const passwordInput = document.getElementById('passwordInput');
            const confirmPasswordInput = document.getElementById('confirmPasswordInput');
            const passwordMatch = document.querySelector('.password-match');
            const passwordNotMatch = document.querySelector('.password-not-match');
            const removePhotoCheckbox = document.getElementById('removePhoto');
            const roleSelect = document.getElementById('roleSelect');

            // Password confirmation validation
            function checkPasswordMatch() {
                if (passwordInput.value && confirmPasswordInput.value) {
                    if (passwordInput.value === confirmPasswordInput.value) {
                        passwordMatch.style.display = 'block';
                        passwordNotMatch.style.display = 'none';
                    } else {
                        passwordMatch.style.display = 'none';
                        passwordNotMatch.style.display = 'block';
                    }
                } else {
                    passwordMatch.style.display = 'none';
                    passwordNotMatch.style.display = 'none';
                }
            }

            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);

            // Image preview function
            window.previewImage = function(input) {
                const file = input.files[0];

                if (file) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB.');
                        input.value = '';
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak didukung! Gunakan JPEG, PNG, JPG, atau GIF.');
                        input.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                        currentPhoto.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                    currentPhoto.style.display = 'block';
                }
            };

            // Remove image function
            window.removeImage = function() {
                fotoInput.value = '';
                imagePreview.style.display = 'none';
                currentPhoto.style.display = 'block';

                if (removePhotoCheckbox) {
                    removePhotoCheckbox.checked = false;
                }
            };

            // Toggle password visibility
            window.togglePassword = function(inputId, button) {
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            };

            // Reset form function
            window.resetForm = function() {
                document.getElementById('userForm').reset();
                removeImage();
                checkPasswordMatch();

                // Reset role select border color
                if (roleSelect) {
                    const selectedOption = roleSelect.options[roleSelect.selectedIndex];
                    const color = selectedOption.getAttribute('data-color');
                    if (color && roleSelect.value) {
                        roleSelect.style.borderColor = `var(--bs-${color})`;
                        roleSelect.style.borderWidth = '2px';
                    } else {
                        roleSelect.style.borderColor = '';
                        roleSelect.style.borderWidth = '';
                    }
                }

                // Uncheck remove photo checkbox
                if (removePhotoCheckbox) {
                    removePhotoCheckbox.checked = false;
                }
            };

            // Change role select border color
            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const color = selectedOption.getAttribute('data-color');

                    if (color) {
                        this.style.borderColor = `var(--bs-${color})`;
                        this.style.borderWidth = '2px';
                    } else {
                        this.style.borderColor = '';
                        this.style.borderWidth = '';
                    }
                });

                // Initialize border color
                const selectedOption = roleSelect.options[roleSelect.selectedIndex];
                const color = selectedOption.getAttribute('data-color');
                if (color && roleSelect.value) {
                    roleSelect.style.borderColor = `var(--bs-${color})`;
                    roleSelect.style.borderWidth = '2px';
                }
            }

            // Handle remove photo checkbox
            if (removePhotoCheckbox) {
                removePhotoCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        currentPhoto.style.opacity = '0.5';
                        if (fotoInput) {
                            fotoInput.disabled = true;
                        }
                    } else {
                        currentPhoto.style.opacity = '1';
                        if (fotoInput) {
                            fotoInput.disabled = false;
                        }
                    }
                });
            }

            // Form validation
            const form = document.getElementById('userForm');
            form.addEventListener('submit', function(e) {
                if (passwordInput.value || confirmPasswordInput.value) {
                    if (passwordInput.value !== confirmPasswordInput.value) {
                        e.preventDefault();
                        alert('Password dan Konfirmasi Password tidak cocok!');
                        passwordInput.focus();
                        return false;
                    }

                    if (passwordInput.value && passwordInput.value.length < 8) {
                        e.preventDefault();
                        alert('Password minimal 8 karakter!');
                        passwordInput.focus();
                        return false;
                    }
                }

                return true;
            });

            // Initialize
            checkPasswordMatch();

            // Handle image error for current photo
            if (currentImg) {
                currentImg.addEventListener('error', function() {
                    this.src = '{{ asset('asset-admin/img/placeholder-user.jpg') }}';
                });
            }
        });
    </script>
@endpush
