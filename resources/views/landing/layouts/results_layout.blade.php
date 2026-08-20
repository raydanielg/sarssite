<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title') - SARS Results</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
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
                        'body': ['Plus Jakarta Sans', 'sans-serif'],
                        'sans': ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!-- PDF.js Global Setup -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        // Set worker source for PDF.js performance
        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
    </script>
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.55)), url('/bg.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .results-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }
        .results-btn {
            background: #1f7a35;
            color: #ffffff;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
        }
        .results-btn:hover {
            background: #145524;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .results-link {
            color: #1f7a35;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s;
        }
        .results-link:hover {
            color: #145524;
            text-decoration: underline;
        }
        .breadcrumb-bar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
    </style>
    @stack('css')
</head>
<body class="antialiased">
    
    <main>
        @yield('content')
    </main>

    @stack('js')
</body>
</html>
