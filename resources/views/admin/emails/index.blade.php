@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Emails')
@section('page-description', 'Gérez les templates et l\'envoi d\'emails de la plateforme')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow-sm rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">Gestion des Emails</h2>
                <div class="flex items-center space-x-3">
                    <button class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                        </svg>
                        Tester l'envoi
                    </button>
                    <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Nouveau template
                    </button>
                </div>
            </div>
        </div>

        <!-- Email Stats -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Emails envoyés (30j)</p>
                    <p class="text-2xl font-semibold text-gray-800">45,678</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Taux d'ouverture</p>
                    <p class="text-2xl font-semibold text-green-600">67.8%</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Taux de clic</p>
                    <p class="text-2xl font-semibold text-blue-600">23.4%</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Taux de désabonnement</p>
                    <p class="text-2xl font-semibold text-red-600">0.8%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Templates -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Transactional Emails -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Emails transactionnels</h3>
                <p class="text-sm text-gray-600 mt-1">Emails automatiques envoyés suite à des actions utilisateur</p>
            </div>
            <div class="p-6 space-y-4">
                <!-- Email de bienvenue -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Email de bienvenue</h4>
                            <p class="text-sm text-gray-600 mb-2">Envoyé automatiquement après l'inscription</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>Dernière modification: 15/01/2025</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Email de confirmation -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Confirmation d'email</h4>
                            <p class="text-sm text-gray-600 mb-2">Vérification de l'adresse email</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>Dernière modification: 10/01/2025</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Réinitialisation mot de passe -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Réinitialisation mot de passe</h4>
                            <p class="text-sm text-gray-600 mb-2">Lien de réinitialisation sécurisé</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>Dernière modification: 05/01/2025</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Confirmation de commande -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Confirmation d'abonnement</h4>
                            <p class="text-sm text-gray-600 mb-2">Détails de l'abonnement et facture</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>Dernière modification: 12/01/2025</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Marketing Emails -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Emails marketing</h3>
                <p class="text-sm text-gray-600 mt-1">Campagnes et newsletters envoyées aux utilisateurs</p>
            </div>
            <div class="p-6 space-y-4">
                <!-- Newsletter mensuelle -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Newsletter mensuelle</h4>
                            <p class="text-sm text-gray-600 mb-2">Nouveautés et recommandations du mois</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>Prochain envoi: 01/02/2025</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recommandations personnalisées -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Recommandations personnalisées</h4>
                            <p class="text-sm text-gray-600 mb-2">Suggestions basées sur l'historique de lecture</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>Envoi hebdomadaire</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Offres promotionnelles -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Offres promotionnelles</h4>
                            <p class="text-sm text-gray-600 mb-2">Promotions et réductions spéciales</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    En pause
                                </span>
                                <span>Dernière campagne: 10/01/2025</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rappel de renouvellement -->
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 mb-1">Rappel de renouvellement</h4>
                            <p class="text-sm text-gray-600 mb-2">Notification avant expiration d'abonnement</p>
                            <div class="flex items-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Actif
                                </span>
                                <span>7 jours avant expiration</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Configuration -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Configuration SMTP</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Serveur SMTP</label>
                    <input type="text" value="smtp.gmail.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Port</label>
                    <input type="text" value="587" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom d'utilisateur</label>
                    <input type="text" value="noreply@elibrary.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" value="••••••••••••" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'expéditeur</label>
                    <input type="text" value="eLibrary" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email de réponse</label>
                    <input type="text" value="support@elibrary.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Tester la connexion
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </div>
</div>
@endsection