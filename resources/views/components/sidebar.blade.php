<div 
    x-data="{
        open: window.innerWidth >= 1024,
        activeMenu: null,
        activeSubmenu: null,

        toggleSubmenu(menu) {
            // Toggle seulement si on clique sur le bouton du menu parent
            this.activeMenu = this.activeMenu === menu ? null : menu;
            // Sauvegarder l'état dans le localStorage pour persistance
            if (this.activeMenu) {
                localStorage.setItem('sidebarActiveMenu', this.activeMenu);
            } else {
                localStorage.removeItem('sidebarActiveMenu');
            }
        },

        // Fonction pour maintenir un menu ouvert (utilisée par les sous-menus)
        keepMenuOpen(menu) {
            if (this.activeMenu !== menu) {
                this.activeMenu = menu;
                localStorage.setItem('sidebarActiveMenu', menu);
            }
        },

        // Fonction pour déterminer le menu actif basé sur l'URL
        getActiveMenuFromUrl() {
            const currentPath = window.location.pathname;

            // Pour les pages admin
            if (currentPath.includes('/admin/')) {
                if (currentPath.includes('/admin/books') || currentPath.includes('/admin/categories') || currentPath.includes('/books/create')) {
                    return 'books';
                } else if (currentPath.includes('/admin/users') || currentPath.includes('/admin/permissions')) {
                    return 'users';
                } else if (currentPath.includes('/admin/reports') || currentPath.includes('/admin/activity') || currentPath.includes('/admin/analytics')) {
                    return 'analytics';
                } else if (currentPath.includes('/admin/settings') || currentPath.includes('/admin/system-settings') ||
                           currentPath.includes('/admin/backup') || currentPath.includes('/admin/logs') ||
                           currentPath.includes('/admin/audit') || currentPath.includes('/admin/themes') ||
                           currentPath.includes('/admin/emails') || currentPath.includes('/admin/notifications') ||
                           currentPath.includes('/admin/subscriptions')) {
                    return 'system';
                }
            }
            // Pour les pages auteur
            else if (currentPath.includes('/author/')) {
                if (currentPath.includes('/author/books') || currentPath.includes('/books/create')) {
                    return 'books';
                } else if (currentPath.includes('/author/analytics')) {
                    return 'analytics';
                } else if (currentPath.includes('/author/revenue')) {
                    return 'revenue';
                } else if (currentPath.includes('/author/promotions')) {
                    return 'promotions';
                } else if (currentPath.includes('/author/tools')) {
                    return 'tools';
                }
            }
            // Pour les pages utilisateur
            else if (currentPath.includes('/user/')) {
                if (currentPath.includes('/user/library')) {
                    return 'library';
                } else if (currentPath.includes('/user/discover')) {
                    return 'discover';
                } else if (currentPath.includes('/user/collections')) {
                    return 'collections';
                }
            }

            return null;
        }
    }"
    x-init="
        // Fermer la sidebar sur mobile au chargement
        if (window.innerWidth < 1024) {
            open = false;
        }

        // Gérer le redimensionnement de la fenêtre
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                open = true;
            }
        });

        // Définir le menu actif basé sur l'URL
        const urlBasedMenu = getActiveMenuFromUrl();

        // Priorité : menu basé sur l'URL (pour maintenir la cohérence)
        if (urlBasedMenu) {
            activeMenu = urlBasedMenu;
            localStorage.setItem('sidebarActiveMenu', urlBasedMenu);
        } else {
            // Fallback : récupérer depuis localStorage si disponible
            const savedMenu = localStorage.getItem('sidebarActiveMenu');
            if (savedMenu) {
                activeMenu = savedMenu;
            }
        }
    "
    class="relative"
>
    <!-- Overlay pour mobile -->
    <div 
        x-show="open && window.innerWidth < 1024" 
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = false"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden"
    ></div>

    <!-- Sidebar -->
    <aside 
        :class="{
            'translate-x-0': open,
            '-translate-x-full': !open
        }"
        class="fixed top-0 left-0 z-50 w-64 h-screen transition-transform duration-300 ease-in-out bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
        <!-- Header avec Logo -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="flex items-center">
                @if(isset($siteSettings['admin_logo']) && $siteSettings['admin_logo'])
                    <img src="{{ asset('storage/' . $siteSettings['admin_logo']) }}" alt="Logo" class="h-8 w-8 object-contain">
                @elseif(isset($siteSettings['site_logo']) && $siteSettings['site_logo'])
                    <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="h-8 w-8 object-contain">
                @else
                    <svg class="w-8 h-8 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                @endif
                <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">
                    {{ $title ?? 'Dashboard' }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                <!-- User Menu (si fourni) -->
                @isset($userMenu)
                    {{ $userMenu }}
                @endisset

                <button
                    @click="open = !open"
                    class="p-2 text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 lg:hidden"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            <ul class="space-y-2">
                {{ $slot }}
            </ul>
        </nav>

        <!-- Footer -->
        @if(isset($footer))
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $footer }}
            </div>
        @endif
    </aside>

    <!-- Toggle Button (visible quand sidebar fermée) -->
    <button 
        @click="open = !open"
        :class="{
            'translate-x-0': !open,
            'translate-x-64': open
        }"
        class="fixed top-4 left-4 z-40 p-2 text-gray-600 bg-white rounded-lg shadow-md hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 transition-transform duration-300 ease-in-out lg:hidden"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Contenu principal avec padding adaptatif -->
    <div 
        :class="{
            'lg:ml-64': open,
            'ml-0': !open
        }"
        class="transition-margin duration-300 ease-in-out"
    >
        <!-- Le contenu de la page sera affiché ici -->
    </div>
</div>