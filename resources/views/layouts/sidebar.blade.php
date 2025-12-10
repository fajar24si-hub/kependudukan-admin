<!-- Sidebar -->
<div class="sidebar">
    <!-- Logo Section dengan Logo Panjang -->
    <div class="sidebar-logo">
        <div class="logo-container">
            <!-- Logo Panjang -->
            <img src="{{ asset('asset-admin/img/LogoPanjang.png') }}" alt="DesaKu Management System" class="logo-image"
                onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/logo.png') }}'; this.alt='Logo DesaKu'; this.style.filter='brightness(0) invert(1)';">

            <!-- Nama Aplikasi -->
            <p class="logo-text">DesaKu</p>

            <!-- Tagline -->
            <p class="logo-tagline">Sistem Pengelolaan Data Desa Terpadu</p>
        </div>
    </div>

    <!-- User Profile -->
    <div class="user-profile">
        <div class="user-avatar">
            @php
                $user = Auth::user();
                $hasFoto = $user && $user->hasFotoProfil();
            @endphp

            @if ($hasFoto)
                <img src="{{ $user->foto_profil_url }}" alt="{{ $user->name ?? 'Admin' }}"
                    onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/placeholder-user.jpg') }}';">
            @else
                <img src="{{ asset('asset-admin/img/placeholder-user.jpg') }}" alt="{{ $user->name ?? 'Admin' }}"
                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'Admin') }}&background=2563eb&color=fff&size=50';">
            @endif
            <div class="user-online"></div>
        </div>
        <div class="user-info">
            <h6>{{ $user->name ?? 'Admin' }}</h6>
            <span>{{ $user->role_display ?? 'Administrator' }}</span>

            @if (session('last_login'))
                <div class="last-login">
                    <i class="fas fa-clock"></i>
                    <small>{{ \Carbon\Carbon::parse(session('last_login'))->format('d/m/Y H:i') }}</small>
                </div>
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <div class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Data Kependudukan -->
        <div class="nav-item dropdown">
            <a href="#"
                class="nav-link dropdown-toggle {{ request()->is('keluargakk*') || request()->is('warga*') || request()->is('penduduk*') ? 'active' : '' }}"
                data-bs-toggle="dropdown">
                <i class="fas fa-users"></i>
                <span>Data Kependudukan</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="dropdown-menu">
                <a href="{{ url('/keluargakk') }}"
                    class="dropdown-item {{ request()->is('keluargakk*') ? 'active' : '' }}">
                    <i class="fas fa-home me-2"></i> Keluarga KK
                </a>
                <a href="{{ url('/warga') }}" class="dropdown-item {{ request()->is('warga*') ? 'active' : '' }}">
                    <i class="fas fa-user me-2"></i> Data Warga
                </a>
            </div>
        </div>

        <!-- Peristiwa Vital -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle {{ request()->is('peristiwa*') ? 'active' : '' }}"
                data-bs-toggle="dropdown">
                <i class="fas fa-calendar-alt"></i>
                <span>Peristiwa Vital</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="dropdown-menu">
                <a href="{{ route('peristiwa-kelahiran.index') }}"
                    class="dropdown-item {{ request()->is('peristiwa-kelahiran*') ? 'active' : '' }}">
                    <i class="fas fa-baby me-2"></i> Kelahiran
                </a>
                <!-- Add more events here -->
            </div>
        </div>

        <!-- Administrasi -->
        <div class="nav-item dropdown">
            <a href="#"
                class="nav-link dropdown-toggle {{ request()->is('user*') || request()->is('multipleuploads*') ? 'active' : '' }}"
                data-bs-toggle="dropdown">
                <i class="fas fa-cogs"></i>
                <span>Administrasi</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="dropdown-menu">
                <a href="{{ route('user.index') }}"
                    class="dropdown-item {{ request()->is('user*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog me-2"></i> Manajemen User
                </a>
                <a href="{{ route('uploads') }}"
                    class="dropdown-item {{ request()->is('multipleuploads*') ? 'active' : '' }}">
                    <i class="fas fa-upload me-2"></i> Upload Files
                </a>
            </div>
        </div>

        <!-- Identitas Pengembang -->
        <div class="nav-item">
            <a href="{{ route('identitas-pengembang') }}"
                class="nav-link {{ request()->is('identitas-pengembang') ? 'active' : '' }}">
                <i class="fas fa-user-tie"></i>
                <span>Identitas Pengembang</span>
            </a>
        </div>

        <!-- Logout -->
        <div class="nav-item mt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </div>
</div>
