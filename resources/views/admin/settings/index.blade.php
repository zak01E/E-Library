@extends('layouts.admin-dashboard')

@section('page-title', 'Paramètres Système')
@section('page-description', 'Configurez les paramètres globaux de la plateforme eLibrary')

@section('content')
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Paramètres Système</h1>
            <p class="text-gray-600 mt-2">Configurez les paramètres globaux de la plateforme eLibrary</p>
        </div>

        <!-- Settings Navigation -->
        <div class="mb-8">
            <nav class="flex space-x-4 border-b">
                <button class="pb-3 px-1 border-b-2 border-blue-500 text-blue-600 font-medium">Général</button>
                <button class="pb-3 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-800">Sécurité</button>
                <button class="pb-3 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-800">Email</button>
                <button class="pb-3 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-800">Stockage</button>
                <button class="pb-3 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-800">API</button>
                <button class="pb-3 px-1 border-b-2 border-transparent text-gray-600 hover:text-gray-800">Maintenance</button>
            </nav>
        </div>

        <!-- General Settings -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Site Information -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Informations du Site</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du site</label>
                        <input type="text" value="eLibrary" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slogan</label>
                        <input type="text" value="Votre bibliothèque numérique moderne" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email de contact</label>
                        <input type="email" value="contact@elibrary.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fuseau horaire</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Europe/Paris (GMT+1)</option>
                            <option>UTC</option>
                            <option>America/New_York (GMT-5)</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>

            <!-- Reading Settings -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Paramètres de Lecture</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Livres par page</label>
                        <input type="number" value="12" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Durée d'emprunt par défaut (jours)</label>
                        <input type="number" value="14" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Limite d'emprunts simultanés</label>
                        <input type="number" value="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Activer les téléchargements hors ligne</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm text-gray-700">Autoriser les commentaires</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>

            <!-- Upload Settings -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Paramètres de Téléversement</h3>
                <form class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Taille maximale des fichiers (MB)</label>
                        <input type="number" value="50" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Formats acceptés</label>
                        <div class="space-y-2 mt-2">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">PDF</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">EPUB</span>
                            </label>
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                                <span class="text-sm text-gray-700">MOBI</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-sm text-gray-700">Modération automatique du contenu</span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>

            <!-- User Settings -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Paramètres Utilisateurs</h3>
                <form class="space-y-4">
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-sm text-gray-700">Inscription ouverte</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" checked class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-sm text-gray-700">Vérification email obligatoire</span>
                        </label>
                    </div>
                    <div>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 rounded">
                            <span class="text-sm text-gray-700">Approbation manuelle des comptes</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôle par défaut</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Utilisateur</option>
                            <option>Auteur</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                        Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-4">État du Système</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Version PHP</p>
                    <p class="text-lg font-medium">8.1.2</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Version Laravel</p>
                    <p class="text-lg font-medium">10.0.0</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Espace disque utilisé</p>
                    <p class="text-lg font-medium">12.5 GB / 100 GB</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Base de données</p>
                    <p class="text-lg font-medium text-green-600">✓ Connectée</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Cache</p>
                    <p class="text-lg font-medium text-green-600">✓ Redis actif</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">File d'attente</p>
                    <p class="text-lg font-medium text-green-600">✓ En cours d'exécution</p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="mt-6 flex space-x-4">
                <button class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition">
                    Vider le cache
                </button>
                <button class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    Mode maintenance
                </button>
                <button class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Exporter configuration
                </button>
            </div>
        </div>
    </div>
@endsection