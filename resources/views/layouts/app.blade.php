<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Absensi Sekolah') }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #f0f8ff 0%, #e0f0ff 100%); }
        .bg-navy { background-color: #1B2A4A; }
        .bg-navy-dark { background-color: #0F1A33; }
        .text-navy { color: #1B2A4A; }
        .bg-baby-blue { background-color: #89CFF0; }
        .bg-baby-blue-light { background-color: #D6EEFB; }
        .text-baby-blue { color: #89CFF0; }
        .border-navy { border-color: #1B2A4A; }
        .border-baby-blue { border-color: #89CFF0; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.02); }
        .transition-smooth { transition: all 0.3s ease; }
        .shadow-navy { box-shadow: 0 4px 14px 0 rgba(27, 42, 74, 0.15); }
        .text-white { color: #FFFFFF !important; }
        .text-dark { color: #1F2937 !important; }
        .btn-navy { background-color: #1B2A4A; color: white; }
        .btn-navy:hover { background-color: #0F1A33; }
        .btn-baby { background-color: #89CFF0; color: #1B2A4A; }
        .btn-baby:hover { background-color: #6BB8E0; }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white shadow-navy">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>
    </div>
    
    @stack('scripts')
    
    <script>
        setTimeout(function() {
            document.querySelectorAll('.flash-message').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 3000);
    </script>
</body>
</html>