<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Library') }} - Authentification</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>

            <!-- Logo Section -->
            <div class="mb-8 text-center relative z-10">
                <a href="/" class="group">
                    <div class="w-20 h-20 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent group-hover:from-indigo-700 group-hover:to-purple-700 transition-all duration-300">
                        E-Library
                    </h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Votre bibliothèque numérique</p>
                </a>
            </div>

            <!-- Main Content Card -->
            <div class="w-full sm:max-w-md relative z-10">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm shadow-2xl border border-gray-200/50 dark:border-gray-700/50 rounded-2xl p-8 relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-full -translate-y-16 translate-x-16 opacity-50"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-purple-100 to-indigo-100 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-full translate-y-12 -translate-x-12 opacity-50"></div>

                    <!-- Content -->
                    <div class="relative z-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-400 relative z-10">
                <p>&copy; {{ date('Y') }} E-Library. Tous droits réservés.</p>
                <div class="flex justify-center space-x-4 mt-2">
                    <a href="#" class="hover:text-indigo-600 transition-colors">Aide</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Conditions</a>
                </div>
            </div>
        </div>

        <!-- Custom Styles -->
        <style>
            .bg-grid-pattern {
                background-image:
                    linear-gradient(rgba(99, 102, 241, 0.1) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(99, 102, 241, 0.1) 1px, transparent 1px);
                background-size: 20px 20px;
            }
        </style>
    </body>
</html>