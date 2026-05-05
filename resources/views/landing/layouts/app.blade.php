<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - EMAS Results Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tz-green': '#1b5e20',
                        'tz-dark-green': '#0d3c14',
                        'tz-nav-green': '#2e7d32',
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap 4 (Keep for Select2 and other plugins compatibility) -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom CSS for Landing -->
    <style>
        :root {
            --font-main: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: #ffffff;
            color: #1a1a1a;
        }
    </style>
    @stack('css')
</head>
<body>

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
    @stack('js')
</body>
</html>
