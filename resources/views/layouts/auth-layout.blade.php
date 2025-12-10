<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kependudukan')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('asset-admin/img/favicon.ico') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Slideshow Background Terluar */
        .fullscreen-slideshow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .fullscreen-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 2s ease-in-out;
        }

        .fullscreen-slide.active {
            opacity: 1;
        }

        /* Overlay untuk readability */
        .fullscreen-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            /* Overlay gelap tipis */
            z-index: -1;
        }

        /* Slideshow dots di pojok kiri bawah */
        .fullscreen-slideshow-dots {
            position: fixed;
            bottom: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            z-index: 1;
        }

        .fullscreen-slideshow-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .fullscreen-slideshow-dot.active {
            background: white;
            transform: scale(1.2);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        /* Container dengan background blur */
        .auth-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            /* Sedikit transparan */
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            display: flex;
            min-height: 680px;
            backdrop-filter: blur(5px);
            /* Efek blur background */
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Left Panel Styles - TIDAK BERUBAH */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            z-index: 1;
        }

        .auth-logo img {
            width: 300px;
            height: 300px;
            object-fit: contain;
            margin-bottom: 25px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            padding: 0px;
            backdrop-filter: blur(10px);
        }

        .auth-logo h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .auth-logo p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .auth-features {
            position: relative;
            z-index: 1;
            margin-top: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .feature-text h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .feature-text p {
            font-size: 14px;
            opacity: 0.8;
        }

        .auth-footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 14px;
            opacity: 0.7;
            z-index: 1;
        }

        /* Right Panel Styles - TIDAK BERUBAH */
        .auth-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-header {
            margin-bottom: 40px;
        }

        .auth-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .auth-header p {
            color: var(--text-light);
            font-size: 16px;
        }

        /* Form Styles - TIDAK BERUBAH */
        .auth-form .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .auth-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .auth-form .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid var(--gray-color);
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background-color: #f8fafc;
        }

        .auth-form .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background-color: white;
            outline: none;
        }

        .auth-form .input-with-icon {
            position: relative;
        }

        .auth-form .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
        }

        .auth-form .input-with-icon .form-control {
            padding-left: 50px;
        }

        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 18px;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        /* Checkbox Styles - TIDAK BERUBAH */
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 2px solid var(--gray-color);
            border-radius: 6px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-color);
            cursor: pointer;
        }

        /* Button Styles - TIDAK BERUBAH */
        .auth-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .auth-btn:active {
            transform: translateY(0);
        }

        .auth-btn.loading {
            opacity: 0.8;
            cursor: not-allowed;
        }

        .auth-btn.loading .spinner {
            display: inline-block;
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Links - TIDAK BERUBAH */
        .auth-links {
            margin-top: 30px;
            text-align: center;
        }

        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .auth-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 30px 0;
            color: var(--text-light);
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-color);
        }

        .divider span {
            padding: 0 15px;
            font-size: 14px;
        }

        /* Social Login - TIDAK BERUBAH */
        .social-login {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-btn {
            flex: 1;
            padding: 14px;
            border: 2px solid var(--gray-color);
            border-radius: var(--border-radius);
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 500;
            color: var(--text-color);
            cursor: pointer;
            transition: var(--transition);
        }

        .social-btn:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .social-btn.google:hover {
            border-color: #DB4437;
            color: #DB4437;
        }

        .social-btn.facebook:hover {
            border-color: #4267B2;
            color: #4267B2;
        }

        /* Alert Styles - TIDAK BERUBAH */
        .alert {
            padding: 15px 20px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border-color: var(--success-color);
            color: #065f46;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: var(--danger-color);
            color: #991b1b;
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            border-color: var(--warning-color);
            color: #92400e;
        }

        .alert-info {
            background-color: rgba(37, 99, 235, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-dark);
        }

        /* Responsive Styles - TIDAK BERUBAH */
        @media (max-width: 992px) {
            .auth-logo img {
                width: 180px;
                height: 180px;
            }
        }

        @media (max-width: 992px) {
            .auth-card {
                flex-direction: column;
                min-height: auto;
            }

            .auth-left {
                padding: 40px 30px;
                border-radius: var(--border-radius) var(--border-radius) 0 0;
            }

            .auth-right {
                padding: 40px 30px;
                border-radius: 0 0 var(--border-radius) var(--border-radius);
            }

            .auth-logo img {
                width: 100px;
                height: 100px;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .auth-left,
            .auth-right {
                padding: 30px 20px;
            }

            .auth-logo h1 {
                font-size: 26px;
            }

            .auth-header h2 {
                font-size: 24px;
            }

            .social-login {
                flex-direction: column;
            }

            /* Sembunyikan dots di mobile jika mengganggu */
            .fullscreen-slideshow-dots {
                display: none;
            }
        }

        /* Animation - TIDAK BERUBAH */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Slideshow Background Terluar - HANYA INI YANG DITAMBAHKAN -->
    <div class="fullscreen-slideshow" id="fullscreenSlideshow">
        <!-- Slide 1 -->
        <div class="fullscreen-slide active"
            style="background-image: url('{{ asset('asset-admin/img/slideshow/slideshow1.jpg') }}');"></div>

        <!-- Slide 2 -->
        <div class="fullscreen-slide"
            style="background-image: url('{{ asset('asset-admin/img/slideshow/slideshow2.jpg') }}');"></div>

        <!-- Slide 3 -->
        <div class="fullscreen-slide"
            style="background-image: url('{{ asset('asset-admin/img/slideshow/slideshow3.jpg') }}');"></div>

        <!-- Fallback jika gambar tidak ada -->
        <div class="fullscreen-slide" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
    </div>

    <!-- Overlay gelap tipis untuk readability -->
    <div class="fullscreen-overlay"></div>

    <!-- Slideshow dots di pojok kiri bawah -->
    <div class="fullscreen-slideshow-dots" id="fullscreenSlideshowDots">
        <button class="fullscreen-slideshow-dot active" data-slide="0"></button>
        <button class="fullscreen-slideshow-dot" data-slide="1"></button>
        <button class="fullscreen-slideshow-dot" data-slide="2"></button>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Left Panel: Branding & Features -->
            <div class="auth-left">
                <div class="auth-logo">
                    <img src="{{ asset('asset-admin/img/LogoKotak.png') }}" alt="Logo Kependudukan"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/120x120/2563eb/ffffff?text=LOGO';">
                    <h1>KEPENDUDUKAN</h1>
                    <p>Data Akurat, Pelayanan Cepat</p>
                </div>

                <div class="auth-features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Data Terintegrasi</h4>
                            <p>Manajemen data penduduk yang terpusat dan terorganisir</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Keamanan Terjamin</h4>
                            <p>Proteksi data dengan enkripsi dan autentikasi aman</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Analisis Real-time</h4>
                            <p>Laporan dan analisis data yang selalu diperbarui</p>
                        </div>
                    </div>
                </div>

                <div class="auth-footer">
                    <p>&copy; {{ date('Y') }} Sistem Kependudukan. Hak cipta dilindungi.</p>
                </div>
            </div>

            <!-- Right Panel: Form Content - TIDAK BERUBAH -->
            <div class="auth-right">
                <div class="auth-header">
                    @yield('auth-header')
                </div>

                <!-- Notifications -->
                @if (session('success'))
                    <div class="alert alert-success fade-in">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger fade-in">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger fade-in">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Content -->
                <div class="auth-content">
                    @yield('content')
                </div>

                <!-- Additional Links -->
                <div class="auth-links">
                    @yield('auth-links')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fullscreen Slideshow Functionality - HANYA INI YANG DITAMBAHKAN
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.fullscreen-slide');
            const dots = document.querySelectorAll('.fullscreen-slideshow-dot');
            let currentSlide = 0;
            const slideInterval = 6000; // 6 seconds

            // Function to show specific slide
            function showFullscreenSlide(index) {
                // Hide all slides
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));

                // Show selected slide
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                currentSlide = index;
            }

            // Next slide function
            function nextFullscreenSlide() {
                let next = currentSlide + 1;
                if (next >= slides.length) {
                    next = 0;
                }
                showFullscreenSlide(next);
            }

            // Start automatic slideshow
            let slideTimer = setInterval(nextFullscreenSlide, slideInterval);

            // Pause slideshow on hover (opsional)
            const slideshowContainer = document.getElementById('fullscreenSlideshow');
            if (slideshowContainer) {
                slideshowContainer.addEventListener('mouseenter', () => {
                    clearInterval(slideTimer);
                });

                slideshowContainer.addEventListener('mouseleave', () => {
                    slideTimer = setInterval(nextFullscreenSlide, slideInterval);
                });
            }

            // Dot click event
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    clearInterval(slideTimer);
                    showFullscreenSlide(index);
                    slideTimer = setInterval(nextFullscreenSlide, slideInterval);
                });
            });

            // Preload slideshow images
            function preloadImages() {
                const imageUrls = [
                    "{{ asset('asset-admin/img/slideshow/slideshow1.jpg') }}",
                    "{{ asset('asset-admin/img/slideshow/slideshow2.jpg') }}",
                    "{{ asset('asset-admin/img/slideshow/slideshow3.jpg') }}"
                ];

                imageUrls.forEach(url => {
                    const img = new Image();
                    img.src = url;
                });
            }

            // Call preload
            preloadImages();
        });

        // Password toggle functionality - TIDAK BERUBAH
        document.addEventListener('DOMContentLoaded', function() {
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

            // Form submission loading state
            const authForms = document.querySelectorAll('.auth-form');
            authForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('.auth-btn');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;

                        // Re-enable button after 5 seconds (in case of error)
                        setTimeout(() => {
                            submitBtn.classList.remove('loading');
                            submitBtn.disabled = false;
                        }, 5000);
                    }
                });
            });

            // Auto-focus first input with error
            const firstErrorInput = document.querySelector('.is-invalid');
            if (firstErrorInput) {
                firstErrorInput.focus();
            }

            // Fade in animation for elements
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
