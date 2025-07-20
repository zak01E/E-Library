<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Library') }} - Administration</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Alpine.js for interactive components -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div x-data="{ sidebarOpen: false, profileOpen: false, notificationOpen: false }" class="flex h-screen overflow-hidden">
            
            <!-- Sidebar -->
            <div class="flex">
                <!-- Sidebar backdrop (mobile only) -->
                <div @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden lg:z-auto transition-opacity duration-200" 
                     :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"></div>
                
                <!-- Sidebar -->
                <div class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
                     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
                    <div class="flex flex-col h-full">
                        <!-- Sidebar header -->
                        <div class="flex items-center justify-between h-16 px-6 bg-gray-800">
                            <div class="flex items-center">
                                <span class="text-2xl font-semibold text-white">E-Library</span>
                            </div>
                            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Sidebar navigation -->
                        <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto">
                            @include('partials.admin-sidebar-menu')
                        </nav>

                        <!-- User info -->
                        <div class="px-4 py-4 border-t border-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">
                                        <span class="text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">Administrateur</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Top header -->
                <header class="bg-white shadow-sm">
                    <div class="flex items-center justify-between h-16 px-6">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 lg:hidden">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            <h1 class="ml-2 text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h1>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative text-gray-600 hover:text-gray-800">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50">
                                    <div class="py-2">
                                        <div class="px-4 py-2 border-b">
                                            <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                                        </div>
                                        <div class="max-h-64 overflow-y-auto">
                                            <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                                <p class="text-sm text-gray-800">Nouveau livre en attente d'approbation</p>
                                                <p class="text-xs text-gray-500 mt-1">Il y a 5 minutes</p>
                                            </a>
                                            <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                                <p class="text-sm text-gray-800">Nouvel utilisateur inscrit</p>
                                                <p class="text-xs text-gray-500 mt-1">Il y a 1 heure</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center">
                                        <span class="text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon profil</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                                        <hr class="my-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Déconnexion
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Main content area -->
                <main class="flex-1 overflow-y-auto bg-gray-50">
                    <!-- Toast Notifications Container -->
                    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

                    <div class="p-6">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <!-- Toast Notification System -->
        <script>
        function showToast(message, type = 'success', duration = 5000) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            // Define colors and icons based on type
            const styles = {
                success: {
                    bg: 'bg-green-500',
                    icon: `<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                           </svg>`
                },
                error: {
                    bg: 'bg-red-500',
                    icon: `<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                           </svg>`
                },
                warning: {
                    bg: 'bg-yellow-500',
                    icon: `<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                           </svg>`
                },
                info: {
                    bg: 'bg-blue-500',
                    icon: `<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                           </svg>`
                }
            };

            const style = styles[type] || styles.success;

            toast.className = `flex items-center p-4 mb-4 text-white rounded-lg shadow-lg transform transition-all duration-300 ease-in-out translate-x-full opacity-0 ${style.bg} max-w-sm`;
            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg mr-3">
                    ${style.icon}
                </div>
                <div class="ml-3 text-sm font-medium">${message}</div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 text-white hover:text-gray-200 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            `;

            container.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
                toast.classList.add('translate-x-0', 'opacity-100');
            }, 100);

            // Auto remove
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 300);
            }, duration);
        }

        // Show session messages as toasts
        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if (session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif

        @if (session('warning'))
            showToast('{{ session('warning') }}', 'warning');
        @endif

        @if (session('info'))
            showToast('{{ session('info') }}', 'info');
        @endif
        </script>
    </body>
</html>