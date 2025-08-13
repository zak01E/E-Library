<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ site_name() }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Inter', sans-serif; }
            .card-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-emerald-50 via-white to-teal-50">
            <div>
                <a href="/" class="flex items-center justify-center">
                    @if(site_logo())
                        <img src="{{ site_logo() }}" alt="{{ site_name() }}" class="h-16 w-auto">
                    @else
                        <h1 class="text-4xl font-bold text-gray-800">{{ site_name() }}</h1>
                    @endif
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-xl overflow-hidden rounded-2xl border border-emerald-100 card-hover">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>