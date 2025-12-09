<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'DesaKu - Sistem Pengelolaan Desa')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset('asset-admin/img/favicon.ico') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Icon Font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gray-color: #e2e8f0;
            --text-color: #334155;
            --text-light: #94a3b8;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
            --sidebar-width: 280px;
            --header-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Main Container */
        .main-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--dark-color) 0%, #0f172a 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: 5px 0 20px rgba(0, 0, 0, 0.1);
            transition: transform var(--transition);
            overflow-y: auto;
            padding: 0;
            transform: translateX(0);
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        /* Content Area */
        .content-area {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            width: calc(100% - var(--sidebar-width));
        }

        .content-area.expanded {
            margin-left: 0;
            width: 100%;
        }

        /* Logo Section - DIUBAH UNTUK LOGO PANJANG */
        .sidebar-logo {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .logo-image {
            width: 100%;
            max-width: 240px;
            height: auto;
            object-fit: contain;
            filter: brightness(0) invert(1); /* Membuat logo putih */
            transition: var(--transition);
        }

        .logo-text {
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .logo-tagline {
            color: rgba(255, 255, 255, 0.7);
            font-size: 11px;
            font-weight: 300;
            letter-spacing: 0.3px;
            line-height: 1.3;
            max-width: 200px;
            margin: 0 auto;
        }

        /* User Profile */
        .user-profile {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            border: 3px solid var(--primary-color);
            position: relative;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-online {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: var(--success-color);
            border-radius: 50%;
            border: 2px solid var(--dark-color);
        }

        .user-info h6 {
            color: white;
            font-weight: 600;
            margin-bottom: 3px;
            font-size: 15px;
        }

        .user-info span {
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            font-weight: 400;
        }

        /* Navigation */
        .sidebar-nav {
            padding: 20px 15px;
        }

        .nav-item {
            margin-bottom: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.8);
            border-radius: var(--border-radius);
            transition: var(--transition);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 10px;
            margin-top: 5px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .dropdown-item {
            color: rgba(255, 255, 255, 0.8);
            padding: 10px 15px;
            border-radius: 8px;
            margin: 3px 0;
            font-size: 14px;
            transition: var(--transition);
        }

        .dropdown-item:hover,
        .dropdown-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Top Navbar */
        .top-navbar {
            height: var(--header-height);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--gray-color);
            padding: 0 25px;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        /* Navbar Inner Container */
        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            width: 100%;
        }

        .sidebar-toggler {
            width: 45px;
            height: 45px;
            border-radius: var(--border-radius);
            background: var(--light-color);
            border: 1px solid var(--gray-color);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            cursor: pointer;
            border: none;
        }

        .sidebar-toggler:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .search-container {
            max-width: 400px;
            width: 100%;
            margin: 0 20px;
        }

        .search-box {
            position: relative;
        }

        .search-box .form-control {
            padding-left: 45px;
            padding-right: 15px;
            height: 45px;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-color);
            background: var(--light-color);
            transition: var(--transition);
            width: 100%;
        }

        .search-box .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            width: 45px;
            height: 45px;
            border-radius: var(--border-radius);
            background: var(--light-color);
            border: 1px solid var(--gray-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            transition: var(--transition);
            cursor: pointer;
            border: none;
        }

        .notification-icon:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content Area */
        .main-content {
            padding: 25px;
            flex: 1;
            width: 100%;
        }

        /* Breadcrumb */
        .breadcrumb-container {
            margin-bottom: 25px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item {
            color: var(--text-light);
            font-size: 14px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--text-color);
            font-weight: 500;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            color: var(--dark-color);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            font-family: 'Poppins', sans-serif;
        }

        .page-subtitle {
            color: var(--text-light);
            font-size: 15px;
            margin: 0;
        }

        /* Footer */
        .footer {
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px solid var(--gray-color);
            padding: 20px 25px;
            margin-top: auto;
            width: 100%;
        }

        .footer p {
            margin: 0;
            color: var(--text-light);
            font-size: 14px;
        }

        .footer a {
            color: var(--primary-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* WhatsApp Button */
        .whatsapp-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            transition: var(--transition);
            z-index: 99;
            text-decoration: none;
        }

        .whatsapp-button:hover {
            transform: scale(1.1) rotate(10deg);
            box-shadow: 0 12px 30px rgba(37, 211, 102, 0.6);
        }

        /* Back to Top */
        .back-to-top {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            box-shadow: 0 5px 20px rgba(37, 99, 235, 0.3);
            transition: var(--transition);
            z-index: 99;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 90px;
            right: 25px;
            z-index: 999;
        }

        .toast {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1001;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content-area {
                margin-left: 0;
                width: 100%;
            }

            .search-container {
                max-width: 300px;
            }

            /* Overlay untuk mobile */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }

            /* Logo pada mobile */
            .logo-image {
                max-width: 200px;
            }
        }

        @media (max-width: 768px) {
            .search-container {
                max-width: 250px;
                margin: 0 15px;
            }

            .top-navbar {
                padding: 0 15px;
            }

            .main-content {
                padding: 15px;
            }

            .user-menu {
                gap: 15px;
            }

            .logo-image {
                max-width: 180px;
            }

            .logo-text {
                font-size: 16px;
            }

            .logo-tagline {
                font-size: 10px;
            }
        }

        @media (max-width: 576px) {
            .user-menu {
                gap: 10px;
            }

            .notification-icon,
            .sidebar-toggler {
                width: 40px;
                height: 40px;
                font-size: 14px;
            }

            .search-container {
                max-width: 200px;
                margin: 0 10px;
            }

            .whatsapp-button {
                width: 50px;
                height: 50px;
                font-size: 24px;
                bottom: 20px;
                right: 20px;
            }

            .back-to-top {
                width: 45px;
                height: 45px;
                bottom: 80px;
                right: 20px;
            }

            .sidebar-logo {
                padding: 15px 10px;
            }

            .logo-image {
                max-width: 160px;
            }

            .logo-text {
                font-size: 14px;
            }

            .logo-tagline {
                font-size: 9px;
                max-width: 150px;
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        /* Custom Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="main-wrapper">
        <!-- Sidebar Overlay untuk Mobile -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Content Area -->
        <div class="content-area">
            <!-- Top Navbar -->
            @include('layouts.navbar')

            <!-- Main Content -->
            <div class="main-content">
                <!-- Breadcrumb -->
                <div class="breadcrumb-container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home me-1"></i> Dashboard</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </nav>
                </div>

                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">@yield('title')</h1>
                    @hasSection('subtitle')
                    <p class="page-subtitle">@yield('subtitle')</p>
                    @endif
                </div>

                <!-- Main Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/85179797880" target="_blank" class="whatsapp-button">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </a>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Sidebar toggle function
            $('.sidebar-toggler').click(function(e) {
                e.preventDefault();
                e.stopPropagation();

                if ($(window).width() <= 992) {
                    // Mobile behavior
                    $('.sidebar').toggleClass('show');
                    $('.sidebar-overlay').toggleClass('show');
                    $('body').toggleClass('no-scroll');
                } else {
                    // Desktop behavior
                    $('.sidebar').toggleClass('collapsed');
                    $('.content-area').toggleClass('expanded');
                }
            });

            // Close sidebar on overlay click (mobile)
            $('.sidebar-overlay').click(function() {
                $('.sidebar').removeClass('show');
                $('.sidebar-overlay').removeClass('show');
                $('body').removeClass('no-scroll');
            });

            // Close sidebar when clicking outside on mobile
            $(document).click(function(e) {
                if ($(window).width() <= 992) {
                    if (!$(e.target).closest('.sidebar').length &&
                        !$(e.target).closest('.sidebar-toggler').length &&
                        $('.sidebar').hasClass('show')) {
                        $('.sidebar').removeClass('show');
                        $('.sidebar-overlay').removeClass('show');
                        $('body').removeClass('no-scroll');
                    }
                }
            });

            // Prevent dropdown from closing when clicking inside
            $('.dropdown-menu').click(function(e) {
                e.stopPropagation();
            });

            // Active menu highlighting
            const currentPath = window.location.pathname;
            $('.nav-link').each(function() {
                const href = $(this).attr('href');
                if (href === currentPath || currentPath.startsWith(href + '/')) {
                    $(this).addClass('active');

                    // Also activate parent dropdown
                    const parentDropdown = $(this).closest('.dropdown');
                    if (parentDropdown.length) {
                        parentDropdown.find('.dropdown-toggle').addClass('active');
                    }
                }
            });

            // Auto-hide alerts
            setTimeout(function() {
                $('.alert').fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 5000);

            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Back to top button
            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    $('.back-to-top').addClass('show');
                } else {
                    $('.back-to-top').removeClass('show');
                }
            });

            $('.back-to-top').click(function(e) {
                e.preventDefault();
                $('html, body').animate({scrollTop: 0}, 500);
                return false;
            });

            // Form submission loading
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.prop('disabled', true);
                    submitBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');

                    // Re-enable after 10 seconds
                    setTimeout(() => {
                        submitBtn.prop('disabled', false);
                        submitBtn.html(submitBtn.data('original-text') || 'Submit');
                    }, 10000);
                }
            });

            // Store original button text
            $('button[type="submit"]').each(function() {
                $(this).data('original-text', $(this).html());
            });

            // Initialize dropdowns
            $('.dropdown-toggle').dropdown();

            // Add fade-in animation to new content
            $('.main-content > *').addClass('fade-in');
        });

        // Handle window resize
        $(window).resize(function() {
            if ($(window).width() > 992) {
                // On desktop, ensure sidebar is visible
                $('.sidebar').removeClass('show');
                $('.sidebar-overlay').removeClass('show');
                $('body').removeClass('no-scroll');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
