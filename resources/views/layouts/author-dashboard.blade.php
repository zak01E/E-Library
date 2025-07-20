<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $siteSettings['site_name'] ?? config('app.name', 'eLibrary') }} - Tableau de bord Auteur</title>

    <!-- Favicon -->
    @if(isset($siteSettings['site_favicon']) && $siteSettings['site_favicon'])
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings['site_favicon']) }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen">


        <!-- Sidebar et contenu principal -->
        <div>
            <x-sidebar title="Espace Auteur">
                <!-- Dashboard -->
                <x-sidebar-item 
                    :active="request()->routeIs('author.dashboard')"
                    href="{{ route('author.dashboard') }}"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6&quot;/></svg>'"
                >
                    Tableau de bord
                </x-sidebar-item>

                <!-- Mes Livres -->
                <x-sidebar-item
                    :active="request()->is('author/books*')"
                    :submenu="true"
                    menuId="books"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253&quot;/></svg>'"
                >
                    Mes Livres
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem 
                            :active="request()->is('author/books') && !request()->has('status')"
                            href="{{ route('author.books') }}"
                        >
                            Tous mes livres
                        </x-sidebar-subitem>
                        <x-sidebar-subitem 
                            :active="request()->is('author/books') && request()->get('status') == 'approved'"
                            href="{{ route('author.books') }}?status=approved"
                        >
                            Livres approuvés
                        </x-sidebar-subitem>
                        <x-sidebar-subitem 
                            :active="request()->is('author/books') && request()->get('status') == 'pending'"
                            href="{{ route('author.books') }}?status=pending"
                        >
                            En attente
                        </x-sidebar-subitem>
                        <x-sidebar-subitem 
                            :active="request()->is('author/books') && request()->get('status') == 'rejected'"
                            href="{{ route('author.books') }}?status=rejected"
                        >
                            Rejetés
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/books/create')"
                            href="{{ route('author.books.create') }}"
                        >
                            Publier un livre
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Analyses -->
                <x-sidebar-item 
                    :active="request()->is('author/analytics*')"
                    :submenu="true"
                    menuId="analytics"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z&quot;/></svg>'"
                >
                    Analyses
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem 
                            :active="request()->is('author/analytics') && !request()->has('type')"
                            href="{{ route('author.analytics') }}"
                        >
                            Vue d'ensemble
                        </x-sidebar-subitem>
                        <x-sidebar-subitem 
                            :active="request()->is('author/analytics/downloads')"
                            href="/author/analytics/downloads"
                        >
                            Téléchargements
                        </x-sidebar-subitem>
                        <x-sidebar-subitem 
                            :active="request()->is('author/analytics/views')"
                            href="/author/analytics/views"
                        >
                            Consultations
                        </x-sidebar-subitem>
                        <x-sidebar-subitem 
                            :active="request()->is('author/analytics/readers')"
                            href="/author/analytics/readers"
                        >
                            Lecteurs
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Collections -->
                <x-sidebar-item
                    :active="request()->is('author/collections*')"
                    :submenu="true"
                    menuId="collections"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10&quot;/></svg>'"
                >
                    Collections
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem
                            :active="request()->is('author/collections') && !request()->has('status')"
                            href="{{ route('author.collections') }}"
                        >
                            Mes collections
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/collections/create')"
                            href="{{ route('author.collections.create') }}"
                        >
                            Créer une collection
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Revenus -->
                <x-sidebar-item 
                    :active="request()->is('author/revenue*')"
                    :submenu="true"
                    menuId="revenue"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z&quot;/></svg>'"
                >
                    Revenus
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem
                            :active="request()->is('author/revenue') && !request()->has('tab')"
                            href="{{ route('author.revenue') }}"
                        >
                            Aperçu des revenus
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/revenue/reports')"
                            href="{{ route('author.revenue.reports') }}"
                        >
                            Rapports
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/revenue/payouts')"
                            href="{{ route('author.revenue.payouts') }}"
                        >
                            Paiements
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Commentaires -->
                <x-sidebar-item 
                    :active="request()->is('author/reviews*')"
                    href="/author/reviews"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z&quot;/></svg>'"
                >
                    Commentaires
                </x-sidebar-item>

                <!-- Promotions -->
                <x-sidebar-item 
                    :active="request()->is('author/promotions*')"
                    :submenu="true"
                    menuId="promotions"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z&quot;/></svg>'"
                >
                    Promotions
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem
                            :active="request()->is('author/promotions')"
                            href="{{ route('author.promotions') }}"
                        >
                            Campagnes actives
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/promotions/create')"
                            href="{{ route('author.promotions.create') }}"
                        >
                            Créer une promotion
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/promotions/history')"
                            href="{{ route('author.promotions.history') }}"
                        >
                            Historique
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Avis -->
                <x-sidebar-item
                    :active="request()->is('author/reviews*')"
                    href="{{ route('author.reviews') }}"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z&quot;/></svg>'"
                >
                    Avis et commentaires
                </x-sidebar-item>

                <!-- Outils -->
                <x-sidebar-item 
                    :active="request()->is('author/tools*')"
                    :submenu="true"
                    menuId="tools"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z&quot;/><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M15 12a3 3 0 11-6 0 3 3 0 016 0z&quot;/></svg>'"
                >
                    Outils
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem
                            :active="request()->is('author/tools') && !request()->is('author/tools/*')"
                            href="{{ route('author.tools') }}"
                        >
                            Tous les outils
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/tools/writing')"
                            href="{{ route('author.tools.writing') }}"
                        >
                            Outils d'écriture
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/tools/marketing')"
                            href="{{ route('author.tools.marketing') }}"
                        >
                            Outils marketing
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Support -->
                <x-sidebar-item
                    :active="request()->is('author/support*')"
                    :submenu="true"
                    menuId="support"
                    :icon="'<svg fill=&quot;none&quot; stroke=&quot;currentColor&quot; viewBox=&quot;0 0 24 24&quot;><path stroke-linecap=&quot;round&quot; stroke-linejoin=&quot;round&quot; stroke-width=&quot;2&quot; d=&quot;M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z&quot;/></svg>'"
                >
                    Support
                    <x-slot name="submenuContent">
                        <x-sidebar-subitem
                            :active="request()->is('author/support') && !request()->has('tab')"
                            href="{{ route('author.support') }}"
                        >
                            Centre de support
                        </x-sidebar-subitem>
                        <x-sidebar-subitem
                            :active="request()->is('author/support/faq')"
                            href="{{ route('author.support.faq') }}"
                        >
                            FAQ
                        </x-sidebar-subitem>
                    </x-slot>
                </x-sidebar-item>

                <!-- Footer de la sidebar -->
                <x-slot name="footer">
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        <div class="mb-2">
                            <p class="font-semibold">Quota mensuel</p>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                            </div>
                            <p class="mt-1">45% utilisé (9/20 livres)</p>
                        </div>
                        <div class="text-center">
                            <p>eLibrary v1.0</p>
                            <p>© 2025 Tous droits réservés</p>
                        </div>
                    </div>
                </x-slot>
            </x-sidebar>

            <!-- Contenu principal -->
            <main
                x-data="{ sidebarOpen: true }"
                :class="sidebarOpen ? 'lg:ml-64' : 'ml-0'"
                class="transition-all duration-300 ease-in-out relative"
            >
                <!-- Header avec menu utilisateur -->
                <div class="sticky top-0 z-40 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 px-4 sm:px-6 lg:px-8 py-3">
                    <div class="flex justify-end">
                        <!-- Menu Utilisateur -->
                        <div x-data="{ open: false }" class="relative">
                            <button
                                @click="open = !open"
                                class="flex items-center p-2 text-gray-600 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors"
                            >
                                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                                x-show="open"
                                @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600 z-50"
                            >
                                <div class="py-2">
                                    <!-- Informations utilisateur -->
                                    <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-medium">
                                                    {{ substr(auth()->user()->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ auth()->user()->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ auth()->user()->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Options du menu -->
                                    <div class="py-1">
                                        <a href="{{ route('author.profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Mon Profil
                                        </a>
                                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Paramètres
                                        </a>
                                        <hr class="my-1 border-gray-200 dark:border-gray-600">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:text-red-400 dark:hover:bg-gray-600">
                                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Déconnexion
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contenu de la page -->
                <div class="p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>