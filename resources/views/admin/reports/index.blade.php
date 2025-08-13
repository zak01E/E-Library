@extends('layouts.admin-dashboard')

@section('page-title', 'Centre de Rapports')
@section('page-description', 'Générez et consultez des rapports détaillés sur l\'activité de la plateforme')

@section('content')
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Centre de Rapports</h1>
            <p class="text-gray-600 mt-2">Générez et consultez des rapports détaillés sur l'activité de la plateforme</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100">Rapports Générés</p>
                        <p class="text-3xl font-bold">247</p>
                        <p class="text-sm text-blue-100">Ce mois</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100">Exports Réussis</p>
                        <p class="text-3xl font-bold">1,842</p>
                        <p class="text-sm text-green-100">Total</p>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100">Rapports Planifiés</p>
                        <p class="text-3xl font-bold">12</p>
                        <p class="text-sm text-purple-100">Actifs</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 rounded-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100">Dernière Analyse</p>
                        <p class="text-3xl font-bold">2h</p>
                        <p class="text-sm text-orange-100">Il y a</p>
                    </div>
                    <svg class="w-12 h-12 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Report Types -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Types de Rapports Disponibles</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Activity Report -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-800">Rapport d'Activité</h3>
                            <p class="text-sm text-gray-600 mt-1">Analyse complète de l'activité des utilisateurs</p>
                            <button class="mt-3 text-sm text-blue-600 hover:text-blue-700 font-medium">Générer →</button>
                        </div>
                    </div>
                </div>

                <!-- Financial Report -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-start">
                        <div class="bg-green-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-800">Rapport Financier</h3>
                            <p class="text-sm text-gray-600 mt-1">Revenus, abonnements et transactions</p>
                            <button class="mt-3 text-sm text-green-600 hover:text-green-700 font-medium">Générer →</button>
                        </div>
                    </div>
                </div>

                <!-- Content Report -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-start">
                        <div class="bg-teal-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-800">Rapport de Contenu</h3>
                            <p class="text-sm text-gray-600 mt-1">Livres populaires et tendances de lecture</p>
                            <button class="mt-3 text-sm text-teal-600 hover:text-purple-700 font-medium">Générer →</button>
                        </div>
                    </div>
                </div>

                <!-- User Report -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-start">
                        <div class="bg-orange-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-800">Rapport Utilisateurs</h3>
                            <p class="text-sm text-gray-600 mt-1">Démographie et comportement des utilisateurs</p>
                            <button class="mt-3 text-sm text-orange-600 hover:text-orange-700 font-medium">Générer →</button>
                        </div>
                    </div>
                </div>

                <!-- Performance Report -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-start">
                        <div class="bg-red-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-800">Rapport de Performance</h3>
                            <p class="text-sm text-gray-600 mt-1">Métriques système et temps de réponse</p>
                            <button class="mt-3 text-sm text-red-600 hover:text-red-700 font-medium">Générer →</button>
                        </div>
                    </div>
                </div>

                <!-- Security Report -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-start">
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="font-semibold text-gray-800">Rapport de Sécurité</h3>
                            <p class="text-sm text-gray-600 mt-1">Tentatives de connexion et incidents</p>
                            <button class="mt-3 text-sm text-gray-600 hover:text-gray-700 font-medium">Générer →</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Rapports Récents</h2>
                <button class="text-sm text-blue-600 hover:text-blue-700">Voir tout</button>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Nom du Rapport</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Type</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Généré par</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Date</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Statut</th>
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-medium">Activité Mensuelle - Novembre 2023</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Activité</span>
                            </td>
                            <td class="py-3 px-4">Admin Principal</td>
                            <td class="py-3 px-4">Il y a 2 heures</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Complété</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-green-600 hover:text-green-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-medium">Analyse Financière Q3 2023</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Financier</span>
                            </td>
                            <td class="py-3 px-4">Comptable</td>
                            <td class="py-3 px-4">Il y a 1 jour</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Complété</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-green-600 hover:text-green-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-medium">Top 100 Livres - Novembre</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-teal-100 text-purple-700">Contenu</span>
                            </td>
                            <td class="py-3 px-4">Système</td>
                            <td class="py-3 px-4">Il y a 3 jours</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">En cours</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="text-gray-400 cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-red-600 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection