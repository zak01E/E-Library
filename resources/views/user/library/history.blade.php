<x-user-dashboard-layout>
    <x-slot name="header">
        Historique de lecture
    </x-slot>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-3xl font-bold text-blue-600">48</p>
            <p class="text-sm text-gray-600 mt-1">Livres lus</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-3xl font-bold text-green-600">12,450</p>
            <p class="text-sm text-gray-600 mt-1">Pages lues</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-3xl font-bold text-purple-600">125h</p>
            <p class="text-sm text-gray-600 mt-1">Temps de lecture</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-3xl font-bold text-orange-600">4.2</p>
            <p class="text-sm text-gray-600 mt-1">Note moyenne donnée</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                        <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>Tout l'historique</option>
                            <option>Cette année</option>
                            <option>6 derniers mois</option>
                            <option>3 derniers mois</option>
                            <option>Ce mois-ci</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                        <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>Toutes les catégories</option>
                            <option>Fiction</option>
                            <option>Non-fiction</option>
                            <option>Science</option>
                            <option>Histoire</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option>Tous</option>
                            <option>Terminés</option>
                            <option>En cours</option>
                            <option>Abandonnés</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-end">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Exporter l'historique
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- History Timeline -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Historique complet</h3>
        </div>
        <div class="p-6">
            <div class="space-y-8">
                <!-- Month Group -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Juillet 2025</h4>
                    
                    <!-- Book Entry -->
                    <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-16 bg-gray-300 rounded"></div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h5 class="font-medium text-gray-900">L'Étranger</h5>
                                    <p class="text-sm text-gray-500">Albert Camus</p>
                                    <div class="flex items-center mt-2 space-x-4 text-sm">
                                        <span class="text-gray-600">Lu du 5 au 15 juillet</span>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Terminé</span>
                                        <div class="flex items-center">
                                            <div class="flex text-yellow-400">
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            </div>
                                            <span class="ml-1 text-gray-600">Votre note</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">123 pages</p>
                                    <p class="text-sm text-gray-500">10 jours</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 italic">"Un livre qui m'a profondément marqué. La philosophie de l'absurde de Camus..."</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Book Entry -->
                    <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-16 bg-gray-300 rounded"></div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h5 class="font-medium text-gray-900">1984</h5>
                                    <p class="text-sm text-gray-500">George Orwell</p>
                                    <div class="flex items-center mt-2 space-x-4 text-sm">
                                        <span class="text-gray-600">Commencé le 10 juillet</span>
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">En cours</span>
                                        <div class="flex items-center">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-600">65%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">210/328 pages</p>
                                    <p class="text-sm text-gray-500">8 jours</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Month Group -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Juin 2025</h4>
                    
                    <!-- Book Entry -->
                    <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-16 bg-gray-300 rounded"></div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h5 class="font-medium text-gray-900">Le Petit Prince</h5>
                                    <p class="text-sm text-gray-500">Antoine de Saint-Exupéry</p>
                                    <div class="flex items-center mt-2 space-x-4 text-sm">
                                        <span class="text-gray-600">Lu du 15 au 20 juin</span>
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Terminé</span>
                                        <div class="flex items-center">
                                            <div class="flex text-yellow-400">
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                            </div>
                                            <span class="ml-1 text-gray-600">Votre note</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">96 pages</p>
                                    <p class="text-sm text-gray-500">5 jours</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 italic">"Un conte philosophique intemporel qui parle autant aux enfants qu'aux adultes..."</p>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Book Entry - Abandoned -->
                    <div class="flex items-start space-x-4 p-4 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-16 bg-gray-300 rounded"></div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h5 class="font-medium text-gray-900">Guerre et Paix</h5>
                                    <p class="text-sm text-gray-500">Léon Tolstoï</p>
                                    <div class="flex items-center mt-2 space-x-4 text-sm">
                                        <span class="text-gray-600">Abandonné le 10 juin</span>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Abandonné</span>
                                        <div class="flex items-center">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-red-400 h-2 rounded-full" style="width: 15%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-600">15%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">180/1225 pages</p>
                                    <p class="text-sm text-gray-500">20 jours</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Load More -->
            <div class="mt-8 text-center">
                <button class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Charger plus d'historique
                </button>
            </div>
        </div>
    </div>
</x-user-dashboard-layout>