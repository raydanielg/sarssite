<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .auth-card {
            display: none; /* Hidden initially for AJAX/Animation */
        }
        .auth-card.active {
            display: block;
        }
    </style>
</head>
<body class="auth-bg">
    <div id="auth-container">
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>

    <script>
        $(function() {
            // Initial animation
            $('.auth-card').addClass('active animate__animated animate__fadeInDown');

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000"
            };

            // AJAX handling for Login/Forgot Password switch
            $(document).on('click', '.auth-link', function(e) {
                const href = $(this).attr('href');
                
                // Only intercept if it's a known auth route
                if (href.includes('/login') || href.includes('/password/reset')) {
                    e.preventDefault();
                    loadAuthPage(href);
                }
            });

            function loadAuthPage(url) {
                const card = $('.auth-card');
                
                // Exit animation
                card.removeClass('animate__fadeInDown').addClass('animate__fadeOutUp');
                
                setTimeout(() => {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            const newContent = $(response).find('.auth-shell').html();
                            $('.auth-shell').html(newContent);
                            
                            // Re-animate in
                            $('.auth-card').addClass('active animate__animated animate__fadeInDown');
                            
                            // Update URL without reload
                            window.history.pushState(null, '', url);
                        },
                        error: function() {
                            window.location.href = url; // Fallback
                        }
                    });
                }, 400); // Wait for exit animation
            }

            @if(session('status'))
                toastr.success("{{ session('status') }}");
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
        });
    </script>
</body>
</html>
