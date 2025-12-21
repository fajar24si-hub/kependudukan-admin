<!-- Top Navbar -->
<nav class="top-navbar">
    <div class="navbar-inner">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggler -->
            <button class="sidebar-toggler">
                <i class="fas fa-bars"></i>
            </button>


        </div>

        <!-- Right Section -->
        <div class="user-menu">
            <!-- Notifications -->
            <div class="notification-icon dropdown">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
                <div class="dropdown-menu dropdown-menu-end" style="min-width: 300px;">
                    <div class="dropdown-header">
                        <h6 class="mb-0">Notifications</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary p-2 me-2">
                                <i class="fas fa-user-plus text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-0 fw-medium">New user registered</p>
                            <small class="text-muted">5 minutes ago</small>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item text-center text-primary">
                        View all notifications
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="dropdown">
                @php
                    $user = Auth::user();
                    $hasFoto = $user && $user->hasFotoProfil();
                    $avatarUrl = $hasFoto ? $user->foto_profil_url : asset('asset-admin/img/placeholder-user.jpg');
                @endphp

                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        <img src="{{ $avatarUrl }}" alt="{{ $user->name ?? 'Admin' }}"
                            style="width: 100%; height: 100%; object-fit: cover;"
                            onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/placeholder-user.jpg') }}';">
                    </div>
                    <div class="ms-2 d-none d-md-block">
                        <span class="fw-medium">{{ $user->name ?? 'Admin' }}</span>
                        <small class="d-block text-muted">{{ $user->role_display ?? 'Administrator' }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" style="min-width: 250px;">
                    <div class="dropdown-header">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar me-3">
                                <img src="{{ $avatarUrl }}" alt="{{ $user->name ?? 'Admin' }}"
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                    onerror="this.onerror=null; this.src='{{ asset('asset-admin/img/placeholder-user.jpg') }}';">
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $user->name ?? 'Admin' }}</h6>
                                <small class="text-muted">{{ $user->role_display ?? 'Administrator' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('user.show', $user->id) }}" class="dropdown-item">
                        <i class="fas fa-user-circle me-2"></i> My Profile
                    </a>
                    <a href="{{ route('user.edit', $user->id) }}" class="dropdown-item">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                    @if (session('last_login'))
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-clock me-2"></i>
                            Last Login: {{ \Carbon\Carbon::parse(session('last_login'))->format('d/m/Y H:i') }}
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt me-2"></i> Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
