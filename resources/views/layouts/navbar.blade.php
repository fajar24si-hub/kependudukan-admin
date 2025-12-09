<!-- Top Navbar -->
<nav class="top-navbar">
    <div class="navbar-inner">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
            <!-- Sidebar Toggler -->
            <button class="sidebar-toggler">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Search -->
            <div class="search-container">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
            </div>
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
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown">
                    <div class="user-avatar" style="width: 40px; height: 40px;">
                        <img src="{{ asset('asset-admin/img/user.jpg') }}" alt="{{ Auth::user()->name ?? 'Admin' }}">
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" style="min-width: 200px;">
                    <div class="dropdown-header">
                        <h6 class="mb-0">{{ Auth::user()->name ?? 'Admin' }}</h6>
                        <small class="text-muted">Administrator</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-circle me-2"></i> Profile
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-clock me-2"></i>
                        Last Login: {{ session('last_login', 'N/A') }}
                    </a>
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
