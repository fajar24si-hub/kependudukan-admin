@extends('layouts.auth-layout')

@section('title', 'Sign Up - Kependudukan')

@section('auth-header')
    <h2>Buat Akun Baru</h2>
    <p>Sign up untuk mengakses sistem kependudukan</p>
@endsection

@section('content')
    <form class="auth-form" action="{{ route('signup.post') }}" method="POST" id="signupForm">
        @csrf

        <!-- Nama Lengkap -->
        <div class="form-group">
            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-user input-icon"></i>
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name"
                       name="name"
                       placeholder="Masukkan nama lengkap"
                       value="{{ old('name') }}"
                       required>
            </div>
            @error('name')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email">Alamat Email <span class="text-danger">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       placeholder="nama@contoh.com"
                       value="{{ old('email') }}"
                       required>
            </div>
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password">Password <span class="text-danger">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Minimal 8 karakter"
                       required>
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Ulangi password"
                       required>
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Role Selection -->
        <div class="form-group">
            <label for="role">Jenis Akun <span class="text-danger">*</span></label>
            <select class="form-control @error('role') is-invalid @enderror"
                    id="role"
                    name="role"
                    required>
                <option value="" disabled selected>Pilih jenis akun</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna Biasa</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator Data</option>
            </select>
            @error('role')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Terms & Conditions -->
        <div class="form-check mb-4">
            <input class="form-check-input @error('terms') is-invalid @enderror"
                   type="checkbox"
                   name="terms"
                   id="terms"
                   {{ old('terms') ? 'checked' : '' }}
                   required>
            <label class="form-check-label" for="terms">
                Saya menyetujui <a href="#" class="auth-link">Syarat & Ketentuan</a> dan
                <a href="#" class="auth-link">Kebijakan Privasi</a>
            </label>
            @error('terms')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="auth-btn">
            <span class="spinner"></span>
            <span>Sign Up</span>
            <i class="fas fa-user-plus"></i>
        </button>
    </form>
@endsection

@section('auth-links')
    <p>Sudah memiliki akun? <a href="{{ route('login') }}" class="auth-link">Login di sini</a></p>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        const toggleButtons = document.querySelectorAll('.password-toggle');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password match validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword === '') return;

            if (password === confirmPassword) {
                confirmPasswordInput.classList.remove('is-invalid');
                confirmPasswordInput.classList.add('is-valid');
            } else {
                confirmPasswordInput.classList.add('is-invalid');
                confirmPasswordInput.classList.remove('is-valid');
            }
        }

        confirmPasswordInput.addEventListener('input', checkPasswordMatch);

        // Form submission loading state
        const signupForm = document.getElementById('signupForm');
        signupForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('.auth-btn');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        });
    });
</script>
@endpush
