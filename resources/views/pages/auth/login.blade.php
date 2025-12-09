@extends('layouts.auth-layout')

@section('title', 'Login - Kependudukan')

@section('auth-header')
    <h2>Selamat Datang Kembali</h2>
    <p>Silakan masuk ke akun Anda untuk melanjutkan</p>
@endsection

@section('content')
    <form class="auth-form" action="{{ route('login.post') }}" method="POST" id="loginForm">
        @csrf

        <div class="form-group">
            <label for="email">Alamat Email</label>
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
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
                <i class="fas fa-lock input-icon"></i>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Masukkan password"
                       required>
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="remember"
                   id="remember"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                Ingat saya di perangkat ini
            </label>
        </div>

        <button type="submit" class="auth-btn">
            <span class="spinner"></span>
            <span>Masuk ke Sistem</span>
            <i class="fas fa-sign-in-alt"></i>
        </button>

        @if(Route::has('password.request'))
        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="auth-link">
                Lupa password?
            </a>
        </div>
        @endif
    </form>

    @if(config('services.google.active') || config('services.facebook.active'))
    <div class="divider">
        <span>atau masuk dengan</span>
    </div>

    <div class="social-login">
        @if(config('services.google.active'))
        <button type="button" class="social-btn google" onclick="window.location.href='{{ route('login.google') }}'">
            <i class="fab fa-google"></i>
            <span>Google</span>
        </button>
        @endif

        @if(config('services.facebook.active'))
        <button type="button" class="social-btn facebook" onclick="window.location.href='{{ route('login.facebook') }}'">
            <i class="fab fa-facebook-f"></i>
            <span>Facebook</span>
        </button>
        @endif
    </div>
    @endif
@endsection

@section('auth-links')
    <p>Belum memiliki akun? <a href="{{ route('signup') }}" class="auth-link">Sign Up sekarang</a></p>
@endsection

@push('scripts')
<script>
    // Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            e.preventDefault();
            alert('Harap isi semua field yang diperlukan');
        }
    });
</script>
@endpush
