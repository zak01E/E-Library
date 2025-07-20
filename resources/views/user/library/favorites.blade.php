<x-user-dashboard-layout>
    <x-slot name="header">
        Mes favoris
    </x-slot>

    <!-- Filter and Sort -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
        <div class="flex items-center space-x-4">
            <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option>Toutes les catégories</option>
                <option>Fiction</option>
                <option>Non-fiction</option>
                <option>Science</option>
                <option>Histoire</option>
                <option>Philosophie</option>
            </select>
            <select class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option>Date d'ajout (récent)</option>
                <option>Date d'ajout (ancien)</option>
                <option>Titre (A-Z)</option>
                <option>Titre (Z-A)</option>
                <option>Auteur (A-Z)</option>
            </select>
        </div>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500">12 livres dans vos favoris</span>
        </div>
    </div>

    <!-- Favorites Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Book Card 1 -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="relative">
                <div class="aspect-w-3 aspect-h-4">
                    <div class="w-full h-64 bg-gray-200 rounded-t-lg"></div>
                </div>
                <button class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100">
                    <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-900 mb-1">Les Misérables</h3>
                <p class="text-sm text-gray-500 mb-2">Victor Hugo</p>
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="ml-2 text-sm text-gray-600">4.5</span>
                </div>
                <p class="text-sm text-gray-600 mb-4">Roman historique captivant qui dépeint la société française du XIXe siècle...</p>
                <div class="flex space-x-2">
                    <a href="#" class="flex-1 text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Emprunter
                    </a>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Détails
                    </button>
                </div>
            </div>
        </div>

        <!-- Book Card 2 -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="relative">
                <div class="aspect-w-3 aspect-h-4">
                    <div class="w-full h-64 bg-gray-200 rounded-t-lg"></div>
                </div>
                <button class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100">
                    <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-900 mb-1">Le Comte de Monte-Cristo</h3>
                <p class="text-sm text-gray-500 mb-2">Alexandre Dumas</p>
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="ml-2 text-sm text-gray-600">5.0</span>
                </div>
                <p class="text-sm text-gray-600 mb-4">Une histoire épique de vengeance et de rédemption qui vous tiendra en haleine...</p>
                <div class="flex space-x-2">
                    <a href="#" class="flex-1 text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Emprunter
                    </a>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Détails
                    </button>
                </div>
            </div>
        </div>

        <!-- Book Card 3 -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="relative">
                <div class="aspect-w-3 aspect-h-4">
                    <div class="w-full h-64 bg-gray-200 rounded-t-lg"></div>
                </div>
                <button class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100">
                    <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
                <span class="absolute top-2 left-2 px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Disponible</span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-900 mb-1">Sapiens</h3>
                <p class="text-sm text-gray-500 mb-2">Yuval Noah Harari</p>
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="ml-2 text-sm text-gray-600">4.7</span>
                </div>
                <p class="text-sm text-gray-600 mb-4">Une brève histoire de l'humanité qui remet en question nos croyances...</p>
                <div class="flex space-x-2">
                    <a href="#" class="flex-1 text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Emprunter
                    </a>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Détails
                    </button>
                </div>
            </div>
        </div>

        <!-- Book Card 4 -->
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="relative">
                <div class="aspect-w-3 aspect-h-4">
                    <div class="w-full h-64 bg-gray-200 rounded-t-lg"></div>
                </div>
                <button class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-100">
                    <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
                <span class="absolute top-2 left-2 px-2 py-1 text-xs font-semibold text-white bg-orange-500 rounded">Emprunté</span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-900 mb-1">La Peste</h3>
                <p class="text-sm text-gray-500 mb-2">Albert Camus</p>
                <div class="flex items-center mb-3">
                    <div class="flex text-yellow-400">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <span class="ml-2 text-sm text-gray-600">4.3</span>
                </div>
                <p class="text-sm text-gray-600 mb-4">Un récit allégorique sur la condition humaine face à l'absurdité de l'existence...</p>
                <div class="flex space-x-2">
                    <button class="flex-1 text-center px-3 py-2 text-sm font-medium text-gray-500 bg-gray-200 rounded-md cursor-not-allowed" disabled>
                        Déjà emprunté
                    </button>
                    <button class="px-3 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        Détails
                    </button>
                </div>
            </div>
        </div>

        <!-- More cards... -->
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <a href="#" class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">3</a>
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Next</span>
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
        </nav>
    </div>
</x-user-dashboard-layout>