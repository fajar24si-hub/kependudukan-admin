<!-- Navbar -->
<nav class="top-navbar">
    <div class="navbar-inner">
        <!-- Left Section: Menu Toggle & Brand -->
        <div class="navbar-left d-flex align-items-center">
            <button class="sidebar-toggler me-3" type="button">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Logo Kecil untuk Navbar -->
            <div class="navbar-brand d-none d-lg-flex align-items-center me-4">
                <div class="logo-small me-2"
                    style="width: 35px; height: 35px; background: linear-gradient(135deg, #2563eb, #3b82f6); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-home text-white" style="font-size: 18px;"></i>
                </div>
                <span
                    style="font-family: 'Poppins', sans-serif; font-weight: 600; color: var(--dark-color); font-size: 18px;">
                    DesaKu
                </span>
            </div>

            <!-- Breadcrumb untuk Mobile -->
            <div class="d-lg-none">
                <div style="font-weight: 600; color: var(--dark-color); font-size: 16px;">
                    @yield('mobile-title', 'Dashboard')
                </div>
            </div>
        </div>

        <!-- Center: Page Title -->
        <div class="navbar-center d-none d-lg-flex align-items-center">
            <div class="page-header-nav">
                <h1 style="font-size: 22px; font-weight: 700; color: var(--dark-color); margin: 0; text-align: center;">
                    @if (request()->routeIs('dashboard*'))
                        Dashboard
                    @elseif(request()->routeIs('user.*'))
                        @if (request()->routeIs('user.create'))
                            Tambah Pengguna
                        @elseif(request()->routeIs('user.edit'))
                            Edit Pengguna
                        @elseif(request()->routeIs('user.show'))
                            Detail Pengguna
                        @else
                            Data Pengguna
                        @endif
                    @elseif(request()->routeIs('warga.*'))
                        @if (request()->routeIs('warga.create'))
                            Tambah Warga
                        @elseif(request()->routeIs('warga.edit'))
                            Edit Warga
                        @elseif(request()->routeIs('warga.show'))
                            Detail Warga
                        @else
                            Data Warga
                        @endif
                    @elseif(request()->routeIs('penduduk.*'))
                        @if (request()->routeIs('penduduk.create'))
                            Tambah Penduduk
                        @elseif(request()->routeIs('penduduk.edit'))
                            Edit Penduduk
                        @elseif(request()->routeIs('penduduk.show'))
                            Detail Penduduk
                        @else
                            Data Penduduk
                        @endif
                    @elseif(request()->routeIs('keluargakk.*'))
                        @if (request()->routeIs('keluargakk.create'))
                            Tambah Keluarga
                        @elseif(request()->routeIs('keluargakk.edit'))
                            Edit Keluarga
                        @elseif(request()->routeIs('keluargakk.show'))
                            Detail Keluarga
                        @else
                            Data Keluarga
                        @endif
                    @elseif(request()->routeIs('peristiwa-kelahiran.*'))
                        Data Kelahiran
                    @elseif(request()->routeIs('peristiwa-kematian.*'))
                        Data Kematian
                    @elseif(request()->routeIs('pindah.*'))
                        Data Pindah
                    @elseif(request()->routeIs('uploads'))
                        Multiple Uploads
                    @elseif(request()->routeIs('identitas-pengembang'))
                        Identitas Pengembang
                    @else
                        Dashboard
                    @endif
                </h1>
            </div>
        </div>

        <!-- Right Section: User Menu & Actions -->
        <div class="navbar-right d-flex align-items-center">
            <!-- Action Buttons -->
            <div class="action-buttons d-flex align-items-center me-3">
                <button class="action-btn me-2" type="button" title="Refresh" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt"></i>
                </button>

                <button class="action-btn me-2" type="button" title="Print" onclick="window.print()">
                    <i class="fas fa-print"></i>
                </button>

                {{-- Setting menggunakan Auth::user()->id --}}
                <a href="{{ route('user.edit', Auth::user()->id) }}" class="action-btn" title="Settings">
                    <i class="fas fa-cog"></i>
                </a>
            </div>

            <!-- User Profile Dropdown -->
            <div class="user-dropdown dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false" id="userDropdown">
                    <div class="user-avatar me-2">
                        @if (Auth::check())
                            <img src="{{ Auth::user()->foto_profil_url ?? asset('asset-admin/img/user.jpg') }}"
                                alt="{{ Auth::user()->name }}"
                                onerror="this.src='{{ asset('asset-admin/img/user.jpg') }}'">
                        @else
                            <img src="{{ asset('asset-admin/img/user.jpg') }}" alt="Guest">
                        @endif
                    </div>
                    <div class="user-info d-none d-md-block">
                        @if (Auth::check())
                            <div style="font-weight: 600; color: var(--dark-color); font-size: 14px;">
                                {{ Auth::user()->name }}
                            </div>
                            <div style="color: var(--text-light); font-size: 12px; margin-top: -2px;">
                                {{ Auth::user()->role_display ?? 'Administrator' }}
                            </div>
                        @endif
                    </div>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown"
                    style="min-width: 220px; border-radius: 12px; border: 1px solid var(--gray-color);">

                    <!-- Dropdown Header -->
                    <li class="dropdown-header p-3"
                        style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 12px 12px 0 0;">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3">
                                @if (Auth::check())
                                    <img src="{{ Auth::user()->foto_profil_url ?? asset('asset-admin/img/user.jpg') }}"
                                        alt="{{ Auth::user()->name }}"
                                        onerror="this.src='{{ asset('asset-admin/img/user.jpg') }}'">
                                @endif
                            </div>
                            <div>
                                @if (Auth::check())
                                    <h6 class="text-white mb-0">{{ Auth::user()->name }}</h6>
                                    <small
                                        class="text-white-50">{{ Auth::user()->role_display ?? 'Administrator' }}</small>
                                @endif
                            </div>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider my-2">
                    </li>

                    <!-- Menu Items sesuai format Anda -->
                    @if (Auth::check())
                        <!-- Profile -->
                        <li>
                            <a href="{{ route('user.show', Auth::user()->id) }}" class="dropdown-item">
                                <i class="fas fa-user-circle me-2"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <!-- Settings -->
                        <li>
                            <a href="{{ route('user.edit', Auth::user()->id) }}" class="dropdown-item">
                                <i class="fas fa-cog me-2"></i>
                                <span>Settings</span>
                            </a>
                        </li>

                        <!-- Last Login -->
                        @if (session('last_login'))
                            <li>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-clock me-2"></i>
                                    <span>Last Login:
                                        {{ \Carbon\Carbon::parse(session('last_login'))->format('d/m/Y H:i') }}</span>
                                </a>
                            </li>
                        @elseif(Auth::user()->last_login)
                            <li>
                                <a href="#" class="dropdown-item">
                                    <i class="fas fa-clock me-2"></i>
                                    <span>Last Login: {{ Auth::user()->last_login->format('d/m/Y H:i') }}</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>
                    @endif

                    <!-- Logout -->
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
</nav>

<!-- CSS untuk Navbar -->
<style>
    /* Action Buttons */
    .action-buttons {
        gap: 10px;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--light-color);
        border: 1px solid var(--gray-color);
        color: var(--text-color);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
    }

    .action-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    /* User Dropdown */
    .user-dropdown .dropdown-toggle {
        padding: 8px 15px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .user-dropdown .dropdown-toggle:hover {
        background: var(--light-color);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .navbar-center {
            display: none !important;
        }

        .action-buttons {
            margin-right: 10px;
        }

        .action-btn {
            width: 35px;
            height: 35px;
        }
    }

    @media (max-width: 768px) {
        .user-info {
            display: none !important;
        }

        .action-buttons .me-2 {
            margin-right: 8px !important;
        }
    }
</style>

<!-- JavaScript untuk Navbar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Active state untuk dropdown
        const userDropdown = document.getElementById('userDropdown');
        if (userDropdown) {
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Auto-close dropdown ketika klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-dropdown')) {
                const dropdown = document.querySelector('.user-dropdown .dropdown-menu');
                if (dropdown && dropdown.classList.contains('show')) {
                    const dropdownInstance = bootstrap.Dropdown.getInstance(userDropdown);
                    if (dropdownInstance) {
                        dropdownInstance.hide();
                    }
                }
            }
        });
    });
</script>
