<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
    <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
    </svg>
    Tableau de bord
</a>

<!-- Gestion des livres -->
<div x-data="{ open: {{ request()->is('admin/books*') ? 'true' : 'false' }} }">
    <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
        <div class="flex items-center">
            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Gestion des livres
        </div>
        <svg class="h-5 w-5 transform transition-transform" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition class="mt-2 space-y-1">
        <a href="{{ route('admin.books') }}" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.books') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            Tous les livres
        </a>
        <a href="{{ route('admin.books') }}?filter=pending" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            En attente d'approbation
            @if(isset($pendingBooksCount) && $pendingBooksCount > 0)
                <span class="ml-auto bg-red-600 text-white text-xs px-2 py-1 rounded-full">{{ $pendingBooksCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.books') }}?filter=approved" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Livres approuvés
        </a>
        <a href="{{ route('books.create') }}" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Ajouter un livre
        </a>
    </div>
</div>

<!-- Gestion des utilisateurs -->
<div x-data="{ open: {{ request()->is('admin/users*') ? 'true' : 'false' }} }">
    <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
        <div class="flex items-center">
            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Gestion des utilisateurs
        </div>
        <svg class="h-5 w-5 transform transition-transform" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition class="mt-2 space-y-1">
        <a href="{{ route('admin.users') }}" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users') ? 'bg-gray-800 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
            Tous les utilisateurs
        </a>
        <a href="{{ route('admin.users') }}?role=admin" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Administrateurs
        </a>
        <a href="{{ route('admin.users') }}?role=author" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Auteurs
        </a>
        <a href="{{ route('admin.users') }}?role=user" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Utilisateurs
        </a>
    </div>
</div>

<!-- Catégories -->
<div x-data="{ open: false }">
    <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
        <div class="flex items-center">
            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            Catégories
        </div>
        <svg class="h-5 w-5 transform transition-transform" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition class="mt-2 space-y-1">
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Toutes les catégories
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Ajouter une catégorie
        </a>
    </div>
</div>

<!-- Statistiques -->
<div x-data="{ open: false }">
    <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
        <div class="flex items-center">
            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Statistiques
        </div>
        <svg class="h-5 w-5 transform transition-transform" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition class="mt-2 space-y-1">
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Vue d'ensemble
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Téléchargements
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Utilisateurs actifs
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Rapports
        </a>
    </div>
</div>

<!-- Paramètres -->
<div x-data="{ open: false }">
    <button @click="open = !open" class="w-full flex items-center justify-between px-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
        <div class="flex items-center">
            <svg class="mr-3 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Paramètres
        </div>
        <svg class="h-5 w-5 transform transition-transform" :class="open ? 'rotate-90' : ''" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    <div x-show="open" x-transition class="mt-2 space-y-1">
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Paramètres généraux
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Sécurité
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Emails
        </a>
        <a href="#" class="group flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md text-gray-300 hover:bg-gray-700 hover:text-white">
            Maintenance
        </a>
    </div>
</div>