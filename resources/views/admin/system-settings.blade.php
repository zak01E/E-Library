@extends('layouts.admin-dashboard')

@section('page-title', 'Paramètres Système')
@section('page-description', 'Configuration avancée du système et maintenance')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Paramètres système</h2>
            <p class="mt-1 text-sm text-gray-600">Configuration et personnalisation de la plateforme eLibrary</p>
        </div>
        <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Enregistrer les modifications
        </button>
    </div>

    <!-- Settings Tabs -->
    <div x-data="{ activeTab: 'general' }" class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button @click="activeTab = 'general'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'general', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'general' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Général
                </button>
                <button @click="activeTab = 'security'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'security', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'security' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Sécurité
                </button>
                <button @click="activeTab = 'email'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'email', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'email' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email
                </button>
                <button @click="activeTab = 'storage'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'storage', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'storage' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                    Stockage
                </button>
                <button @click="activeTab = 'api'"
                        :class="{ 'border-emerald-500 text-emerald-600': activeTab === 'api', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'api' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    API
                </button>
            </nav>
        </div>

        <!-- Tab Contents -->
        <div class="p-6">
            <!-- General Settings -->
            <div x-show="activeTab === 'general'" class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom du site</label>
                            <input type="text" value="eLibrary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slogan</label>
                            <input type="text" value="Votre bibliothèque numérique" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL du site</label>
                            <input type="url" value="https://elibrary.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email de contact</label>
                            <input type="email" value="contact@elibrary.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Langue par défaut</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option>Français</option>
                                <option>English</option>
                                <option>Español</option>
                                <option>Deutsch</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fuseau horaire</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option>Europe/Paris (UTC+1)</option>
                                <option>UTC</option>
                                <option>America/New_York (UTC-5)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres d'affichage</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Mode maintenance</label>
                                <p class="text-sm text-gray-500">Activer le mode maintenance pour les visiteurs</p>
                            </div>
                            <button type="button" class="bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Inscriptions ouvertes</label>
                                <p class="text-sm text-gray-500">Permettre aux nouveaux utilisateurs de s'inscrire</p>
                            </div>
                            <button type="button" class="bg-emerald-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Mode sombre par défaut</label>
                                <p class="text-sm text-gray-500">Activer le thème sombre pour les nouveaux utilisateurs</p>
                            </div>
                            <button type="button" class="bg-gray-200 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="false">
                                <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div x-show="activeTab === 'security'" style="display: none;" class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de sécurité</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Durée de session (minutes)</label>
                            <input type="number" value="60" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tentatives de connexion maximum</label>
                            <input type="number" value="5" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Durée de blocage après échecs (minutes)</label>
                            <input type="number" value="15" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Authentification à deux facteurs</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Forcer 2FA pour les admins</label>
                                <p class="text-sm text-gray-500">Exiger l'authentification à deux facteurs pour tous les administrateurs</p>
                            </div>
                            <button type="button" class="bg-emerald-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Activer 2FA par SMS</label>
                                <p class="text-sm text-gray-500">Permettre l'authentification via SMS</p>
                            </div>
                            <button type="button" class="bg-emerald-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Liste blanche IP</h3>
                    <div class="space-y-3">
                        <div class="flex space-x-3">
                            <input type="text" placeholder="Adresse IP (ex: 192.168.1.1)" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <button class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Ajouter</button>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm">192.168.1.1</span>
                                    <button class="text-red-600 hover:text-red-700 text-sm">Supprimer</button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm">10.0.0.0/24</span>
                                    <button class="text-red-600 hover:text-red-700 text-sm">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div x-show="activeTab === 'email'" style="display: none;" class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Configuration SMTP</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Serveur SMTP</label>
                            <input type="text" value="smtp.gmail.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Port</label>
                            <input type="number" value="587" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                            <input type="text" value="noreply@elibrary.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                            <input type="password" value="••••••••" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Chiffrement</label>
                            <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option>TLS</option>
                                <option>SSL</option>
                                <option>Aucun</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email d'expédition</label>
                            <input type="email" value="noreply@elibrary.com" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Tester la configuration</button>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Modèles d'emails</h3>
                    <div class="space-y-3">
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">Email de bienvenue</h4>
                                    <p class="text-sm text-gray-500">Envoyé lors de l'inscription d'un nouvel utilisateur</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">Réinitialisation du mot de passe</h4>
                                    <p class="text-sm text-gray-500">Envoyé lors d'une demande de réinitialisation</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 cursor-pointer">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">Confirmation d'achat</h4>
                                    <p class="text-sm text-gray-500">Envoyé après un achat ou abonnement</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Storage Settings -->
            <div x-show="activeTab === 'storage'" style="display: none;" class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Utilisation du stockage</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Espace utilisé</span>
                                <span class="font-medium text-gray-900">245.8 GB / 500 GB</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-emerald-600 h-3 rounded-full" style="width: 49.16%"></div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Livres PDF</p>
                                <p class="font-medium text-gray-900">189.2 GB</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Images de couverture</p>
                                <p class="font-medium text-gray-900">45.6 GB</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Sauvegardes</p>
                                <p class="font-medium text-gray-900">11.0 GB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Paramètres de stockage</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Taille maximale par fichier (MB)</label>
                            <input type="number" value="100" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Types de fichiers autorisés</label>
                            <input type="text" value="pdf, epub, mobi" class="mt-1 block w-full md:w-2/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Compression automatique</label>
                                <p class="text-sm text-gray-500">Compresser les PDF uploadés pour économiser l'espace</p>
                            </div>
                            <button type="button" class="bg-emerald-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Nettoyage automatique</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="font-medium text-gray-700">Supprimer les fichiers temporaires</label>
                                <p class="text-sm text-gray-500">Nettoyer automatiquement les fichiers temporaires après 7 jours</p>
                            </div>
                            <button type="button" class="bg-emerald-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" role="switch" aria-checked="true">
                                <span class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                        <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Nettoyer maintenant</button>
                    </div>
                </div>
            </div>

            <!-- API Settings -->
            <div x-show="activeTab === 'api'" style="display: none;" class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Clés API</h3>
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">Clé de production</h4>
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Active</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <code class="flex-1 bg-gray-200 rounded px-3 py-2 text-sm font-mono">sk_live_****************************6789</code>
                                <button class="text-emerald-600 hover:text-emerald-700">Copier</button>
                                <button class="text-red-600 hover:text-red-700">Révoquer</button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Créée le 15 janvier 2025 • Dernière utilisation: il y a 2 heures</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900">Clé de test</h4>
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Test</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <code class="flex-1 bg-gray-200 rounded px-3 py-2 text-sm font-mono">sk_test_****************************abcd</code>
                                <button class="text-emerald-600 hover:text-emerald-700">Copier</button>
                                <button class="text-red-600 hover:text-red-700">Révoquer</button>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Créée le 10 janvier 2025 • Dernière utilisation: il y a 5 jours</p>
                        </div>
                        
                        <button class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Générer nouvelle clé</button>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Limites de taux</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Requêtes par minute</label>
                            <input type="number" value="60" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Requêtes par jour</label>
                            <input type="number" value="10000" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Webhooks</h3>
                    <div class="space-y-3">
                        <div class="flex space-x-3">
                            <input type="url" placeholder="URL du webhook" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <button class="px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Ajouter</button>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium">https://api.example.com/webhook/elibrary</p>
                                        <p class="text-xs text-gray-500">user.created, book.uploaded</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Actif</span>
                                        <button class="text-red-600 hover:text-red-700 text-sm">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection