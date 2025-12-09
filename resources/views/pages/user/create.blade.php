@extends('layouts.app')

@section('title', 'Tambah User Baru')
@section('subtitle', 'Tambahkan pengguna baru ke sistem')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('user.index') }}">Data User</a></li>
<li class="breadcrumb-item active">Tambah User</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Form Tambah User Baru</h5>
                    <div>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        <i class="fas fa-user-plus me-2"></i> Informasi User
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
                                                   value="{{ old('name') }}"
                                                   placeholder="Masukkan nama lengkap"
                                                   required minlength="3" maxlength="100" autofocus>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}"
                                                   placeholder="contoh@email.com" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Email harus valid dan belum terdaftar</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Role <span class="text-danger">*</span>
                                            </label>
                                            <select name="role" class="form-select @error('role') is-invalid @enderror"
                                                    required id="roleSelect">
                                                <option value="">Pilih Role</option>
                                                @foreach($roles as $role)
                                                    @php
                                                        $roleColors = [
                                                            'Super Admin' => 'danger',
                                                            'Administrator' => 'primary',
                                                            'Pelanggan' => 'success',
                                                            'Mitra' => 'warning'
                                                        ];
                                                        $color = $roleColors[$role] ?? 'secondary';
                                                    @endphp
                                                    <option value="{{ $role }}"
                                                            {{ old('role') == $role ? 'selected' : '' }}
                                                            data-color="{{ $color }}">
                                                        {{ $role }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Pilih peran pengguna dalam sistem</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Status Akun <span class="text-danger">*</span>
                                            </label>
                                            <select name="is_active" class="form-select @error('is_active') is-invalid @enderror"
                                                    required>
                                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                                                    Aktif
                                                </option>
                                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                                    Nonaktif
                                                </option>
                                            </select>
                                            @error('is_active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Status akun pengguna</small>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       placeholder="Masukkan password"
                                                       required minlength="8" id="passwordInput">
                                                <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('passwordInput', this)"
                                                        data-bs-toggle="tooltip" title="Tampilkan/Sembunyikan Password">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="password-requirements mt-2">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-info-circle me-1"></i> Password harus mengandung:
                                                </small>
                                                <small class="text-muted d-block">
                                                    • Minimal 8 karakter
                                                </small>
                                                <small class="text-muted d-block">
                                                    • Huruf besar dan kecil
                                                </small>
                                                <small class="text-muted d-block">
                                                    • Angka dan simbol (disarankan)
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Konfirmasi Password <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="password_confirmation"
                                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                                       placeholder="Konfirmasi password"
                                                       required id="confirmPasswordInput">
                                                <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('confirmPasswordInput', this)"
                                                        data-bs-toggle="tooltip" title="Tampilkan/Sembunyikan Password">
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
                                            Upload Foto (Opsional)
                                        </label>
                                        <input type="file" name="foto_profil"
                                               class="form-control @error('foto_profil') is-invalid @enderror"
                                               accept=".jpg,.jpeg,.png,.gif"
                                               id="fotoInput" onchange="previewImage(this)">
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
                                                     alt="Preview Foto">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                        onclick="removeImage()" style="transform: translate(50%, -50%);"
                                                        data-bs-toggle="tooltip" title="Hapus Preview">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <p class="text-muted small mt-2">
                                                <i class="fas fa-image me-1"></i> Preview Foto
                                            </p>
                                        </div>

                                        <!-- Default avatar jika tidak ada foto -->
                                        <div id="defaultAvatar" class="mb-3">
                                            <div class="avatar-lg rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                                                 style="width: 180px; height: 180px; border: 2px dashed #6c757d;">
                                                <div class="text-center">
                                                    <img src="{{ asset('img/placeholder-user.jpg') }}" alt="Placeholder User"
                                                         class="img-fluid rounded-circle"
                                                         style="width: 160px; height: 160px; object-fit: cover; opacity: 0.8;">
                                                    <p class="text-muted small mt-2">Placeholder Default</p>
                                                </div>
                                            </div>
                                            <p class="text-muted small mt-2">
                                                <i class="fas fa-user me-1"></i> Foto default akan menggunakan placeholder
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="use_default_avatar"
                                                   id="useDefaultAvatar" checked>
                                            <label class="form-check-label small" for="useDefaultAvatar">
                                                <i class="fas fa-check me-1"></i> Gunakan foto default jika tidak diupload
                                            </label>
                                        </div>
                                        <small class="text-muted">
                                            Jika tidak upload foto, sistem akan menggunakan gambar placeholder
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan User
                        </button>
                        <button type="reset" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-undo me-1"></i> Reset Form
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
    const defaultAvatar = document.getElementById('defaultAvatar');
    const passwordInput = document.getElementById('passwordInput');
    const confirmPasswordInput = document.getElementById('confirmPasswordInput');
    const passwordMatch = document.querySelector('.password-match');
    const passwordNotMatch = document.querySelector('.password-not-match');
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
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                input.value = '';
                return;
            }

            // Check file type
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
                defaultAvatar.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
            defaultAvatar.style.display = 'block';
        }
    };

    // Remove image function
    window.removeImage = function() {
        fotoInput.value = '';
        imagePreview.style.display = 'none';
        defaultAvatar.style.display = 'block';
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
            roleSelect.style.borderColor = '';
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

    // Form validation
    const form = document.getElementById('userForm');
    form.addEventListener('submit', function(e) {
        if (passwordInput.value !== confirmPasswordInput.value) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak cocok!');
            passwordInput.focus();
            return false;
        }

        if (passwordInput.value.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter!');
            passwordInput.focus();
            return false;
        }

        return true;
    });

    // Initialize
    checkPasswordMatch();

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush

@push('styles')
<style>
.password-requirements {
    background-color: var(--light-color);
    border-radius: 5px;
    padding: 8px 12px;
    margin-top: 5px;
}

.password-requirements small {
    line-height: 1.4;
}

.avatar-lg {
    transition: all 0.3s ease;
}

.avatar-lg:hover {
    transform: scale(1.02);
}

#imagePreview {
    transition: all 0.3s ease;
}

.position-absolute button {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}
</style>
@endpush
