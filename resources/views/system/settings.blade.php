@extends('layouts.main-dashboard')

@section('title', 'Paramètres Système')
@section('page-title', 'Paramètres Système')
@section('page-description', 'Configurez les paramètres généraux de votre plateforme E-Library')

@section('content')
    <!-- Settings Navigation -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Navigation -->
        <div class="lg:w-1/4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <nav class="space-y-2">
                    <a href="#general" class="flex items-center px-3 py-2 text-sm font-medium text-emerald-600 bg-emerald-50 dark:bg-indigo-900 dark:text-indigo-300 rounded-lg">
                        <i class="fas fa-cog mr-3"></i>
                        Général
                    </a>
                    <a href="#security" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-shield-alt mr-3"></i>
                        Sécurité
                    </a>
                    <a href="#email" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-envelope mr-3"></i>
                        Email
                    </a>
                    <a href="#storage" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-database mr-3"></i>
                        Stockage
                    </a>
                    <a href="#api" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-code mr-3"></i>
                        API
                    </a>
                    <a href="#maintenance" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-tools mr-3"></i>
                        Maintenance
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:w-3/4 space-y-6">
            <!-- General Settings -->
            <div id="general" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paramètres Généraux</h3>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">
                        Sauvegarder
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nom de la plateforme
                        </label>
                        <input type="text" value="E-Library" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            URL de base
                        </label>
                        <input type="url" value="https://elibrary.com" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Fuseau horaire
                        </label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option>Europe/Paris</option>
                            <option>Europe/London</option>
                            <option>America/New_York</option>
                            <option>Asia/Tokyo</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Langue par défaut
                        </label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option>Français</option>
                            <option>English</option>
                            <option>Español</option>
                            <option>Deutsch</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description de la plateforme
                    </label>
                    <textarea rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                              placeholder="Décrivez votre plateforme de bibliothèque numérique...">Une plateforme moderne de bibliothèque numérique permettant aux auteurs de publier leurs œuvres et aux lecteurs de découvrir de nouveaux contenus.</textarea>
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Inscriptions ouvertes</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Permettre aux nouveaux utilisateurs de s'inscrire</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">Mode maintenance</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Activer le mode maintenance</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Security Settings -->
            <div id="security" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paramètres de Sécurité</h3>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">
                        Sauvegarder
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Durée de session (minutes)
                            </label>
                            <input type="number" value="120" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tentatives de connexion max
                            </label>
                            <input type="number" value="5" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Authentification à deux facteurs</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Exiger 2FA pour tous les administrateurs</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Logs de sécurité</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Enregistrer toutes les tentatives de connexion</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Protection CSRF</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Protection contre les attaques CSRF</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Storage Settings -->
            <div id="storage" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Paramètres de Stockage</h3>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm">
                        Sauvegarder
                    </button>
                </div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Taille max par fichier (MB)
                            </label>
                            <input type="number" value="50" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Quota par utilisateur (GB)
                            </label>
                            <input type="number" value="5" 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Types de fichiers autorisés
                        </label>
                        <input type="text" value="pdf,epub,mobi,txt" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                               placeholder="Séparez par des virgules">
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Utilisation du Stockage</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Livres PDF</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">2.4 GB</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 48%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Images de couverture</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">156 MB</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 12%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Avatars utilisateurs</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">89 MB</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-teal-500 h-2 rounded-full" style="width: 8%"></div>
                            </div>
                            
                            <div class="pt-2 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Total utilisé</span>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white">2.6 GB / 10 GB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">État du Système</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                        <div class="w-8 h-8 bg-green-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div class="text-sm font-medium text-green-800 dark:text-green-200">Base de données</div>
                        <div class="text-xs text-green-600 dark:text-green-400">Opérationnelle</div>
                    </div>
                    
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                        <div class="w-8 h-8 bg-green-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div class="text-sm font-medium text-green-800 dark:text-green-200">Cache Redis</div>
                        <div class="text-xs text-green-600 dark:text-green-400">Connecté</div>
                    </div>
                    
                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <i class="fas fa-exclamation text-white text-sm"></i>
                        </div>
                        <div class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Service Email</div>
                        <div class="text-xs text-yellow-600 dark:text-yellow-400">Lent</div>
                    </div>
                    
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                        <div class="w-8 h-8 bg-green-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div class="text-sm font-medium text-green-800 dark:text-green-200">Stockage</div>
                        <div class="text-xs text-green-600 dark:text-green-400">26% utilisé</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
