<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
    }
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteSettings['site_name'] ?? config('app.name', 'eLibrary') }} - Admin Dashboard</title>

    <!-- Favicon -->
    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div x-data="{
        sidebarOpen: true,
        activeMenu: null,
        toggleSubmenu(menu) {
            this.activeMenu = this.activeMenu === menu ? null : menu;
        },
        init() {
            // Auto-open submenu if current page is in that section
            const currentPath = window.location.pathname;

            // Books section (includes categories)
            if (currentPath.includes('/admin/books') ||
                currentPath.includes('/books/create') ||
                currentPath.includes('/admin/categories')) {
                this.activeMenu = 'books';
            }
            // Users section (includes permissions and active users)
            else if (currentPath.includes('/admin/users') ||
                     currentPath.includes('/admin/permissions')) {
                this.activeMenu = 'users';
            }
            // Analytics section
            else if (currentPath.includes('/admin/reports') ||
                     currentPath.includes('/admin/activity') ||
                     currentPath.includes('/admin/analytics')) {
                this.activeMenu = 'analytics';
            }
            // System section (includes all system-related pages)
            else if (currentPath.includes('/admin/settings') ||
                     currentPath.includes('/admin/system-settings') ||
                     currentPath.includes('/admin/backup') ||
                     currentPath.includes('/admin/logs') ||
                     currentPath.includes('/admin/audit') ||
                     currentPath.includes('/admin/themes') ||
                     currentPath.includes('/admin/emails') ||
                     currentPath.includes('/admin/notifications') ||
                     currentPath.includes('/admin/subscriptions')) {
                this.activeMenu = 'system';
            }
        }
    }" class="min-h-screen flex">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'"
               class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 shadow-xl transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700">

            <!-- Logo & Toggle -->
            <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-indigo-600 to-purple-600">
                <div class="flex items-center">
                    @if(isset($siteSettings['admin_logo']) && $siteSettings['admin_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['admin_logo']) }}" alt="Admin Logo" class="w-8 h-8 object-contain">
                    @elseif(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Site Logo" class="w-8 h-8 object-contain">
                    @else
                        <i class="fas fa-book-open text-white text-2xl"></i>
                    @endif
                    <span x-show="sidebarOpen" x-transition class="ml-3 text-xl font-bold text-white">{{ $siteSettings['site_name'] ?? 'eLibrary' }} Admin</span>
                </div>
                <button @click="sidebarOpen = !sidebarOpen"
                        class="text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

                <!-- Dashboard -->
                <div class="mb-6">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center px-4 py-3 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 dark:bg-gray-700 text-indigo-700 dark:text-indigo-300' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 h-5"></i>
                        <span x-show="sidebarOpen" x-transition class="ml-3 font-medium">Dashboard</span>
                    </a>
                </div>

                <!-- Content Management -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Gestion du contenu
                    </div>

                    <!-- Books Management -->
                    <div class="space-y-1">
                        <button @click="toggleSubmenu('books')"
                                :class="activeMenu === 'books' ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-book w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Livres</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'books' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'books' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('admin.books') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.books') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-list w-4 h-4 mr-2"></i>Tous les livres
                            </a>
                            <a href="{{ route('admin.books.create') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.books.create') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-plus w-4 h-4 mr-2"></i>Ajouter un livre
                            </a>
                            <a href="{{ route('admin.categories') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.categories') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-tags w-4 h-4 mr-2"></i>Catégories
                            </a>
                        </div>
                    </div>

                    <!-- Users Management -->
                    <div class="space-y-1">
                        <button @click="toggleSubmenu('users')"
                                :class="activeMenu === 'users' ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-users w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Utilisateurs</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'users' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'users' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.users') && !request()->has('status') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-list w-4 h-4 mr-2"></i>Tous les utilisateurs
                            </a>
                            <a href="{{ route('admin.users.active') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.users.active') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-user-check w-4 h-4 mr-2"></i>Utilisateurs actifs
                            </a>
                            <a href="{{ route('admin.permissions') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.permissions') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-shield-alt w-4 h-4 mr-2"></i>Permissions & Rôles
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Analytics & Reports -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Analytics & Rapports
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.reports*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-chart-line w-5 h-5"></i>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Rapports</span>
                        </a>
                        <a href="{{ route('admin.activity') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.activity') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <i class="fas fa-chart-pie w-5 h-5"></i>
                            <span x-show="sidebarOpen" x-transition class="ml-3">Activité</span>
                        </a>
                    </div>
                </div>

                <!-- System & Settings -->
                <div class="mb-4">
                    <div x-show="sidebarOpen" class="px-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">
                        Système & Configuration
                    </div>

                    <div class="space-y-1">
                        <button @click="toggleSubmenu('system')"
                                :class="activeMenu === 'system' ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="flex items-center justify-between w-full px-4 py-3 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-cogs w-5 h-5"></i>
                                <span x-show="sidebarOpen" x-transition class="ml-3">Système</span>
                            </div>
                            <i x-show="sidebarOpen" :class="activeMenu === 'system' ? 'fa-chevron-down' : 'fa-chevron-right'"
                               class="fas text-xs transition-transform"></i>
                        </button>

                        <div x-show="activeMenu === 'system' && sidebarOpen" x-transition class="ml-8 space-y-1">
                            <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.settings*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-sliders-h w-4 h-4 mr-2"></i>Paramètres généraux
                            </a>
                            <a href="{{ route('admin.homepage-content.index') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.homepage-content*') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-home w-4 h-4 mr-2"></i>Contenu Page d'Accueil
                            </a>
                            <a href="{{ route('admin.backup') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.backup') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-database w-4 h-4 mr-2"></i>Sauvegarde
                            </a>
                            <a href="{{ route('admin.logs') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.logs') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-file-alt w-4 h-4 mr-2"></i>Logs système
                            </a>
                            <a href="{{ route('admin.system-settings') }}" class="block px-4 py-2 text-sm rounded-md transition-colors {{ request()->routeIs('admin.system-settings') ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                <i class="fas fa-tools w-4 h-4 mr-2"></i>Maintenance
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img class="w-10 h-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name ?? 'Admin' }}">
                        <div x-show="sidebarOpen" x-transition class="ml-3">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(Auth::user()->role ?? 'admin') }}</p>
                        </div>
                    </div>

                    <!-- Quick Logout Button -->
                    <button onclick="showLogoutModal()"
                       title="Déconnexion rapide"
                       class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main :class="sidebarOpen ? 'ml-72' : 'ml-20'" class="flex-1 transition-all duration-300 ease-in-out">
            <!-- Top Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">@yield('page-title', 'Dashboard Admin')</h1>
                            <p class="text-gray-600 dark:text-gray-400">@yield('page-description', 'Gestion de votre plateforme eLibrary')</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Search -->
                            <div class="relative">
                                <input type="text" placeholder="Rechercher..."
                                       class="w-64 pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>

                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 relative">
                                    <i class="fas fa-bell text-sm"></i>
                                    <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                                </button>
                            </div>

                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleTheme()" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                                <i class="fas fa-moon text-sm" id="theme-icon"></i>
                            </button>

                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-1.5 p-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <img class="w-6 h-6 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name ?? 'Admin' }}">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition
                                     class="absolute right-0 mt-1 w-48 bg-white dark:bg-gray-800 rounded-md shadow-md border border-gray-200 dark:border-gray-700 z-50">
                                    <a href="{{ route('admin.profile.edit') }}" class="block px-3 py-1.5 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-user w-3 h-3 mr-1.5"></i>Profil
                                    </a>
                                    <a href="#" class="block px-3 py-1.5 text-xs text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-cog w-3 h-3 mr-1.5"></i>Paramètres
                                    </a>
                                    <hr class="border-gray-200 dark:border-gray-700 my-1">



                                    <!-- Simple Logout Link -->
                                    <button onclick="showLogoutModal()"
                                       class="block w-full text-left px-3 py-1.5 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="fas fa-sign-out-alt w-3 h-3 mr-1.5"></i>Déconnexion
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Notification Container -->
    <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2" style="max-width: 400px;"></div>

    <!-- Notification System -->
    <script>
        class NotificationSystem {
            constructor() {
                this.container = document.getElementById('notification-container');
                this.notifications = [];
                this.init();
            }

            init() {
                @if(session('success'))
                    this.show('{{ session('success') }}', 'success');
                @endif
                @if(session('error'))
                    this.show('{{ session('error') }}', 'error');
                @endif
                @if(session('warning'))
                    this.show('{{ session('warning') }}', 'warning');
                @endif
                @if(session('info'))
                    this.show('{{ session('info') }}', 'info');
                @endif
            }

            show(message, type = 'info', duration = 5000) {
                const id = 'notification-' + Date.now() + Math.random();
                const notification = this.createNotification(id, message, type);

                this.container.appendChild(notification);
                this.notifications.push({ id, element: notification });

                setTimeout(() => notification.classList.add('notification-enter-active'), 10);

                if (duration > 0) {
                    setTimeout(() => this.hide(id), duration);
                }

                return id;
            }

            createNotification(id, message, type) {
                const notification = document.createElement('div');
                notification.id = id;
                notification.className = `transform translate-x-full opacity-0 transition-all duration-300 ease-out bg-white rounded-lg shadow-lg border-l-4 p-4 mb-2 max-w-sm ${this.getTypeClasses(type)}`;

                notification.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">${this.getIcon(type)}</div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium ${this.getTextColor(type)}">${message}</p>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <button onclick="notificationSystem.hide('${id}')" class="inline-flex text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;

                return notification;
            }

            getTypeClasses(type) {
                const classes = {
                    success: 'border-green-400',
                    error: 'border-red-400',
                    warning: 'border-yellow-400',
                    info: 'border-blue-400'
                };
                return classes[type] || classes.info;
            }

            getTextColor(type) {
                const colors = {
                    success: 'text-green-800',
                    error: 'text-red-800',
                    warning: 'text-yellow-800',
                    info: 'text-blue-800'
                };
                return colors[type] || colors.info;
            }

            getIcon(type) {
                const icons = {
                    success: `<svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>`,
                    error: `<svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>`,
                    warning: `<svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>`,
                    info: `<svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>`
                };
                return icons[type] || icons.info;
            }

            hide(id) {
                const notification = document.getElementById(id);
                if (notification) {
                    notification.classList.remove('notification-enter-active');
                    notification.classList.add('translate-x-full', 'opacity-0');

                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                        this.notifications = this.notifications.filter(n => n.id !== id);
                    }, 300);
                }
            }
        }

        // Initialize
        let notificationSystem;
        document.addEventListener('DOMContentLoaded', function() {
            notificationSystem = new NotificationSystem();
            window.showNotification = (message, type, duration) => notificationSystem.show(message, type, duration);

            // Add CSS for animations
            const style = document.createElement('style');
            style.textContent = `
                .notification-enter-active {
                    transform: translateX(0) !important;
                    opacity: 1 !important;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

    <!-- Modal de déconnexion compacte -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
        <div class="relative top-20 mx-auto p-4 w-full max-w-sm">
            <!-- Contenu de la modale -->
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="logoutModalContent">
                <!-- En-tête avec icône -->
                <div class="flex flex-col items-center pt-6 pb-4 px-6">
                    <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white text-center mb-1">
                        🚪 Déconnexion
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                        Êtes-vous sûr de vouloir vous déconnecter ?
                    </p>
                </div>

                <!-- Informations utilisateur -->
                <div class="px-6 pb-4">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 mb-4 border-l-4 border-blue-500">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ Auth::user()->name ?? 'Admin' }}</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ ucfirst(Auth::user()->role ?? 'admin') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action compacts -->
                    <div class="flex gap-2">
                        <button type="button"
                                onclick="hideLogoutModal()"
                                class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm">
                            ✕ Annuler
                        </button>
                        <button type="button"
                                onclick="confirmLogout()"
                                class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl text-sm">
                            🚪 Se déconnecter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonctions pour la modal de déconnexion
        function showLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const content = document.getElementById('logoutModalContent');

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Animation d'entrée
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function hideLogoutModal() {
            const modal = document.getElementById('logoutModal');
            const content = document.getElementById('logoutModalContent');

            if (!modal || modal.classList.contains('hidden')) return;

            // Animation de sortie
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function confirmLogout() {
            // Rediriger vers la route de déconnexion
            window.location.href = "{{ route('admin.simple.logout') }}";
        }

        // Fermer la modal en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('logoutModal');
            if (event.target === modal) {
                hideLogoutModal();
            }
        });

        // Fermer la modal avec la touche Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideLogoutModal();
            }
        });
    </script>
</body>
</html>
