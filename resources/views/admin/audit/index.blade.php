@extends('layouts.admin-dashboard')

@section('page-title', 'Journal d\'Audit')
@section('page-description', 'Surveillez toutes les activités et modifications sur la plateforme')

@section('content')
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Journal d'Audit</h1>
            <p class="text-gray-600 mt-2">Surveillez toutes les activités et modifications sur la plateforme</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Filtres</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type d'action</label>
                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Toutes les actions</option>
                        <option>Connexion</option>
                        <option>Création</option>
                        <option>Modification</option>
                        <option>Suppression</option>
                        <option>Téléchargement</option>
                        <option>Configuration</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateur</label>
                    <input type="text" placeholder="Rechercher un utilisateur..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                    <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <button class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">
                    Réinitialiser
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Appliquer les filtres
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Actions aujourd'hui</p>
                        <p class="text-2xl font-bold text-gray-800">1,247</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Connexions</p>
                        <p class="text-2xl font-bold text-green-600">342</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Modifications</p>
                        <p class="text-2xl font-bold text-orange-600">89</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Alertes sécurité</p>
                        <p class="text-2xl font-bold text-red-600">3</p>
                    </div>
                    <div class="bg-red-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audit Log Table -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Activités Récentes</h2>
                <button class="text-sm text-blue-600 hover:text-blue-700">Exporter CSV</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Date/Heure</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Utilisateur</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Action</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Ressource</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">IP</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Statut</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Détails</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">2023-11-15 14:32:18</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Admin&background=3B82F6&color=fff" alt="Admin">
                                    <div>
                                        <p class="text-sm font-medium">Admin Principal</p>
                                        <p class="text-xs text-gray-500">admin@elibrary.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Configuration</span>
                            </td>
                            <td class="py-3 px-4 text-sm">Paramètres système</td>
                            <td class="py-3 px-4 text-sm">192.168.1.100</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Succès</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">2023-11-15 14:28:45</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Jean+Dupont&background=10B981&color=fff" alt="Jean">
                                    <div>
                                        <p class="text-sm font-medium">Jean Dupont</p>
                                        <p class="text-xs text-gray-500">auteur@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Création</span>
                            </td>
                            <td class="py-3 px-4 text-sm">Livre: "Python Avancé"</td>
                            <td class="py-3 px-4 text-sm">192.168.1.52</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Succès</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">2023-11-15 14:15:32</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Unknown&background=EF4444&color=fff" alt="Unknown">
                                    <div>
                                        <p class="text-sm font-medium">Utilisateur Inconnu</p>
                                        <p class="text-xs text-gray-500">-</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Connexion</span>
                            </td>
                            <td class="py-3 px-4 text-sm">Tentative échouée</td>
                            <td class="py-3 px-4 text-sm">89.234.45.12</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Échec</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">2023-11-15 14:10:18</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Marie+Martin&background=8B5CF6&color=fff" alt="Marie">
                                    <div>
                                        <p class="text-sm font-medium">Marie Martin</p>
                                        <p class="text-xs text-gray-500">marie@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-700">Téléchargement</span>
                            </td>
                            <td class="py-3 px-4 text-sm">Livre: "JavaScript Moderne"</td>
                            <td class="py-3 px-4 text-sm">192.168.1.78</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Succès</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm">2023-11-15 13:55:42</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full mr-2" src="https://ui-avatars.com/api/?name=Admin&background=3B82F6&color=fff" alt="Admin">
                                    <div>
                                        <p class="text-sm font-medium">Admin Principal</p>
                                        <p class="text-xs text-gray-500">admin@elibrary.com</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Suppression</span>
                            </td>
                            <td class="py-3 px-4 text-sm">Utilisateur: spam_user123</td>
                            <td class="py-3 px-4 text-sm">192.168.1.100</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Succès</span>
                            </td>
                            <td class="py-3 px-4">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">2,347</span> résultats
                </p>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">
                        Précédent
                    </button>
                    <button class="px-3 py-1 bg-blue-600 text-white rounded-md">1</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">2</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">3</button>
                    <span class="px-3 py-1">...</span>
                    <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">235</button>
                    <button class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-50">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection