@extends('layouts.user-dashboard')

@section('title', 'Mes signets')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Mes signets</h2>
            <p class="mt-1 text-sm text-gray-600">Retrouvez rapidement vos passages favoris</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="text-gray-600 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                </svg>
            </button>
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Plus récents</option>
                <option>Plus anciens</option>
                <option>Par livre</option>
                <option>Par chapitre</option>
            </select>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-6 border border-indigo-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600">Total signets</p>
                    <p class="text-3xl font-bold text-indigo-900">134</p>
                    <p class="text-sm text-indigo-700 mt-1">Dans 18 livres</p>
                </div>
                <div class="bg-indigo-500 text-white p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600">Cette semaine</p>
                    <p class="text-3xl font-bold text-purple-900">12</p>
                    <p class="text-sm text-purple-700 mt-1">+5 vs semaine dernière</p>
                </div>
                <div class="bg-purple-500 text-white p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-6 border border-pink-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-pink-600">Favoris</p>
                    <p class="text-3xl font-bold text-pink-900">28</p>
                    <p class="text-sm text-pink-700 mt-1">Marqués importants</p>
                </div>
                <div class="bg-pink-500 text-white p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookmarks List -->
    <div class="space-y-4">
        <!-- Book Group 1 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between" x-data="{ expanded: true }">
                <button @click="expanded = !expanded" class="flex items-center space-x-3 flex-1">
                    <svg class="w-5 h-5 text-gray-500 transition-transform" :class="expanded ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <img src="https://via.placeholder.com/40x60" alt="Book" class="w-10 h-15 object-cover rounded">
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900">Les Dépossédés</h3>
                        <p class="text-sm text-gray-600">23 signets</p>
                    </div>
                </button>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Dernière activité: Il y a 2 jours</span>
                </div>
            </div>
            <div x-show="expanded" x-transition class="divide-y divide-gray-100">
                <!-- Bookmark 1 -->
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Chapitre 3 - L'Arrivée</span>
                                <span class="text-sm text-gray-500">Page 87</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Important
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2">
                                Shevek contemplait la planète bleue qui grossissait dans le hublot. Pour la première fois de sa vie, il allait fouler le sol d'Urras, cette terre à la fois promise et interdite...
                            </p>
                            <div class="flex items-center mt-3 text-xs text-gray-500">
                                <span>Ajouté il y a 5 jours</span>
                                <span class="mx-2">•</span>
                                <button class="text-blue-600 hover:text-blue-700">Aller à la page</button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button class="text-gray-400 hover:text-yellow-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                            <button class="text-gray-400 hover:text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bookmark 2 -->
                <div class="px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                </svg>
                                <span class="text-sm font-medium text-gray-700">Chapitre 7 - La Révélation</span>
                                <span class="text-sm text-gray-500">Page 198</span>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-2">
                                "La révolution est dans chaque esprit ou elle n'est nulle part." Cette phrase résonnait encore dans l'esprit de Shevek alors qu'il marchait dans les rues d'A-Io...
                            </p>
                            <div class="flex items-center mt-3 text-xs text-gray-500">
                                <span>Ajouté il y a 1 semaine</span>
                                <span class="mx-2">•</span>
                                <button class="text-blue-600 hover:text-blue-700">Aller à la page</button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button class="text-gray-400 hover:text-yellow-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                            <button class="text-gray-400 hover:text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Group 2 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between" x-data="{ expanded: false }">
                <button @click="expanded = !expanded" class="flex items-center space-x-3 flex-1">
                    <svg class="w-5 h-5 text-gray-500 transition-transform" :class="expanded ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <img src="https://via.placeholder.com/40x60" alt="Book" class="w-10 h-15 object-cover rounded">
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900">1984</h3>
                        <p class="text-sm text-gray-600">18 signets</p>
                    </div>
                </button>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Dernière activité: Il y a 1 semaine</span>
                </div>
            </div>
        </div>

        <!-- Book Group 3 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between" x-data="{ expanded: false }">
                <button @click="expanded = !expanded" class="flex items-center space-x-3 flex-1">
                    <svg class="w-5 h-5 text-gray-500 transition-transform" :class="expanded ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <img src="https://via.placeholder.com/40x60" alt="Book" class="w-10 h-15 object-cover rounded">
                    <div class="text-left">
                        <h3 class="font-semibold text-gray-900">Le Petit Prince</h3>
                        <p class="text-sm text-gray-600">15 signets</p>
                    </div>
                </button>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Dernière activité: Il y a 2 semaines</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Accès rapide</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button class="bg-white rounded-lg p-4 text-left hover:shadow-md transition border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-100 text-yellow-600 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Signets favoris</p>
                        <p class="text-sm text-gray-600">28 marqués importants</p>
                    </div>
                </div>
            </button>
            <button class="bg-white rounded-lg p-4 text-left hover:shadow-md transition border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Récents</p>
                        <p class="text-sm text-gray-600">12 cette semaine</p>
                    </div>
                </div>
            </button>
            <button class="bg-white rounded-lg p-4 text-left hover:shadow-md transition border border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 text-purple-600 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Archives</p>
                        <p class="text-sm text-gray-600">Signets plus anciens</p>
                    </div>
                </div>
            </button>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Exporter vos signets</h3>
        <div class="flex flex-wrap gap-3">
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                PDF
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                TXT
            </button>
            <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
                JSON
            </button>
        </div>
    </div>
</div>
@endsection