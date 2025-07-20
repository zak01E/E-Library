@extends('layouts.user-dashboard')

@section('title', 'Mes notes de lecture')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Mes notes de lecture</h2>
            <p class="mt-1 text-sm text-gray-600">Organisez et retrouvez toutes vos annotations</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Exporter mes notes
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-64">
                <div class="relative">
                    <input type="text" placeholder="Rechercher dans vos notes..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Tous les livres</option>
                <option>Les Dépossédés</option>
                <option>1984</option>
                <option>Le Petit Prince</option>
            </select>
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Tous les types</option>
                <option>Surlignages</option>
                <option>Notes</option>
                <option>Citations</option>
            </select>
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Plus récentes</option>
                <option>Plus anciennes</option>
                <option>Par livre</option>
                <option>Par importance</option>
            </select>
        </div>
    </div>

    <!-- Notes Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Total des notes</p>
                    <p class="text-2xl font-bold text-blue-900">248</p>
                </div>
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
        </div>
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-600">Surlignages</p>
                    <p class="text-2xl font-bold text-yellow-900">156</p>
                </div>
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                </svg>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Citations</p>
                    <p class="text-2xl font-bold text-green-900">67</p>
                </div>
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600">Livres annotés</p>
                    <p class="text-2xl font-bold text-purple-900">23</p>
                </div>
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Notes by Book -->
    <div class="space-y-6">
        <!-- Book 1 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="https://via.placeholder.com/60x90" alt="Book" class="w-12 h-18 object-cover rounded">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Les Dépossédés</h3>
                        <p class="text-sm text-gray-600">Ursula K. Le Guin • 45 notes</p>
                    </div>
                </div>
                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Voir tout</button>
            </div>
            <div class="p-6 space-y-4">
                <!-- Note 1 -->
                <div class="border-l-4 border-yellow-400 pl-4 py-2">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-gray-800 italic">"Il n'y avait pas de certitude, seulement l'opportunité."</p>
                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs mr-2">Surlignage</span>
                                <span>Chapitre 3, Page 87</span>
                                <span class="mx-2">•</span>
                                <span>Il y a 2 jours</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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

                <!-- Note 2 with comment -->
                <div class="border-l-4 border-blue-400 pl-4 py-2">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-gray-800 italic">"La révolution est dans chaque esprit ou elle n'est nulle part."</p>
                            <div class="bg-gray-50 rounded-lg p-3 mt-2">
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium">Ma note :</span> Cette citation résume parfaitement l'idée centrale du livre - le changement social commence par une transformation personnelle.
                                </p>
                            </div>
                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs mr-2">Note</span>
                                <span>Chapitre 7, Page 198</span>
                                <span class="mx-2">•</span>
                                <span>Il y a 5 jours</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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

        <!-- Book 2 -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="https://via.placeholder.com/60x90" alt="Book" class="w-12 h-18 object-cover rounded">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">1984</h3>
                        <p class="text-sm text-gray-600">George Orwell • 38 notes</p>
                    </div>
                </div>
                <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">Voir tout</button>
            </div>
            <div class="p-6 space-y-4">
                <!-- Quote -->
                <div class="border-l-4 border-green-400 pl-4 py-2">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-gray-800 italic">"La guerre, c'est la paix. La liberté, c'est l'esclavage. L'ignorance, c'est la force."</p>
                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs mr-2">Citation</span>
                                <span>Chapitre 1, Page 4</span>
                                <span class="mx-2">•</span>
                                <span>Il y a 1 semaine</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button class="text-gray-400 hover:text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </button>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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
    </div>

    <!-- Collections -->
    <div class="bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Collections de notes</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-purple-100 text-purple-600 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">45</span>
                </div>
                <h4 class="font-medium text-gray-900">Philosophie</h4>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">32</span>
                </div>
                <h4 class="font-medium text-gray-900">Citations favorites</h4>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition cursor-pointer">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-orange-100 text-orange-600 p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">28</span>
                </div>
                <h4 class="font-medium text-gray-900">À relire</h4>
            </div>
            <button class="bg-white rounded-lg p-4 border-2 border-dashed border-gray-300 hover:border-gray-400 transition flex flex-col items-center justify-center">
                <svg class="w-8 h-8 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-sm text-gray-600">Nouvelle collection</span>
            </button>
        </div>
    </div>

    <!-- Add Note Button -->
    <button class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </button>
</div>
@endsection