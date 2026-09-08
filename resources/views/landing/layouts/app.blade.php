<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MWANZA REGION EXAMINATION SYSTEM</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'tz-green': '#1b5e20',
                        'tz-dark-green': '#0d3c14',
                        'tz-nav-green': '#2e7d32',
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#22c55e","600":"#16a34a","700":"#15803d","800":"#166534","900":"#14532d","950":"#052e16"}
                    },
                    fontFamily: {
                        'body': ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif'],
                        'sans': ['Plus Jakarta Sans', 'Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Boxicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <!-- AOS (Animate On Scroll) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"/>
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <!-- Glightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css"/>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap 4 (Keep for Select2 and other plugins compatibility) -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom CSS for Landing -->
    <style>
        :root {
            --font-main: 'Plus Jakarta Sans', sans-serif;
            --necta-green: #1b5e20;
            --necta-dark: #0d3c14;
            --necta-light: #2e7d32;
        }

        body {
            font-family: var(--font-main);
            background-color: #ffffff;
            color: #1a1a1a;
        }

        /* Dropdown menu styles */
        .nav-dropdown {
            position: relative;
        }
        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 200;
            padding: 8px 0;
        }
        .nav-dropdown:hover .nav-dropdown-menu,
        .nav-dropdown:focus-within .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .nav-dropdown-menu a {
            display: block;
            padding: 10px 20px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .nav-dropdown-menu a:hover {
            background: #f0fdf4;
            color: #15803d;
            border-left-color: #22c55e;
        }

        /* Hero carousel */
        .hero-slide {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Sidebar styles */
        #mobileMenuDrawer {
            z-index: 201;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        #mobileMenuOverlay {
            z-index: 200;
        }

        /* Mobile dropdown */
        .mobile-dropdown-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .mobile-dropdown-content.open {
            max-height: 500px;
        }

        /* Line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
    @stack('css')
</head>
<body data-aos-easing="ease-in-out" data-aos-duration="1000" data-aos-delay="0">

    @include('landing.partials.header')
    
    <!-- Menu Overlay for Mobile -->
    <div class="menu-overlay"></div>

    <main class="content-wrapper bg-white" style="margin-left: 0; min-height: 600px;">
        @yield('content')
    </main>

    @include('landing.partials.footer')

    <!-- Scripts -->
    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Sidebar toggle logic
            $('.navbar-toggler').on('click', function() {
                $('.navbar-collapse').addClass('show');
                $('.menu-overlay').addClass('show');
                $('body').css('overflow', 'hidden');
            });

            $('.sidebar-close, .menu-overlay').on('click', function() {
                $('.navbar-collapse').removeClass('show');
                $('.menu-overlay').removeClass('show');
                $('body').css('overflow', 'auto');
            });
        });
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Glightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        AOS.init({
            easing: 'ease-in-out',
            duration: 1000,
            delay: 0,
            once: true
        });
    </script>
    @stack('js')
</body>
</html>
