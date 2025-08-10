@extends('layouts.user-dashboard')

@section('page-title', 'Paramètres')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Paramètres</h1>
            <p class="text-gray-600 mt-1">Personnalisez votre expérience de lecture</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Settings Navigation -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <nav class="space-y-2">
                    <a href="#general" class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">
                        <i class="fas fa-cog w-4 h-4 mr-3"></i>
                        Général
                    </a>
                    <a href="#reading" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-book-reader w-4 h-4 mr-3"></i>
                        Lecture
                    </a>
                    <a href="#notifications" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-bell w-4 h-4 mr-3"></i>
                        Notifications
                    </a>
                    <a href="#privacy" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-shield-alt w-4 h-4 mr-3"></i>
                        Confidentialité
                    </a>
                    <a href="#appearance" class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg">
                        <i class="fas fa-palette w-4 h-4 mr-3"></i>
                        Apparence
                    </a>
                </nav>
            </div>
        </div>

        <!-- Settings Content -->
        <div class="lg:col-span-3 space-y-6">
            <!-- General Settings -->
            <div id="general" class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Paramètres généraux</h2>
                    <p class="text-sm text-gray-600 mt-1">Configurez vos préférences de base</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">Langue</label>
                            <select id="language" name="language"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="fr" selected>Français</option>
                                <option value="en">English</option>
                                <option value="es">Español</option>
                                <option value="de">Deutsch</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Fuseau horaire</label>
                            <select id="timezone" name="timezone"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="Europe/Paris" selected>Europe/Paris (UTC+1)</option>
                                <option value="Europe/London">Europe/London (UTC+0)</option>
                                <option value="America/New_York">America/New_York (UTC-5)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-3 text-blue-600 focus:ring-blue-500" checked>
                            <span class="text-sm text-gray-700">Recevoir des emails de mise à jour</span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reading Settings -->
            <div id="reading" class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Préférences de lecture</h2>
                    <p class="text-sm text-gray-600 mt-1">Personnalisez votre expérience de lecture</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="reading_goal" class="block text-sm font-medium text-gray-700 mb-2">Objectif mensuel</label>
                            <select id="reading_goal" name="reading_goal"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="1">1 livre par mois</option>
                                <option value="2">2 livres par mois</option>
                                <option value="3">3 livres par mois</option>
                                <option value="5" selected>5 livres par mois</option>
                                <option value="10">10 livres par mois</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="default_view" class="block text-sm font-medium text-gray-700 mb-2">Vue par défaut</label>
                            <select id="default_view" name="default_view"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="grid" selected>Grille</option>
                                <option value="list">Liste</option>
                                <option value="compact">Compacte</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Genres préférés</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php
                                $genres = ['Fiction', 'Science-fiction', 'Romance', 'Thriller', 'Biographie', 'Fantaisie'];
                            @endphp
                            @foreach($genres as $genre)
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" name="preferred_genres[]" value="{{ strtolower($genre) }}" 
                                       class="mr-3 text-blue-600 focus:ring-blue-500" 
                                       {{ in_array($genre, ['Fiction', 'Science-fiction']) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $genre }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Suivi automatique de progression</h4>
                                <p class="text-sm text-gray-600">Enregistrer automatiquement votre progression de lecture</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Recommandations personnalisées</h4>
                                <p class="text-sm text-gray-600">Recevoir des suggestions basées sur vos lectures</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notification Settings -->
            <div id="notifications" class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Notifications</h2>
                    <p class="text-sm text-gray-600 mt-1">Choisissez comment vous souhaitez être informé</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Nouveaux livres</h4>
                                <p class="text-sm text-gray-600">Notifications pour les nouvelles sorties</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Rappels de lecture</h4>
                                <p class="text-sm text-gray-600">Rappels pour continuer vos lectures en cours</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Objectifs atteints</h4>
                                <p class="text-sm text-gray-600">Notifications quand vous atteignez vos objectifs</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Newsletter</h4>
                                <p class="text-sm text-gray-600">Newsletter hebdomadaire avec les tendances</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="notification_frequency" class="block text-sm font-medium text-gray-700 mb-2">Fréquence des rappels</label>
                        <select id="notification_frequency" name="notification_frequency"
                                class="w-full md:w-1/2 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="daily">Quotidien</option>
                            <option value="weekly" selected>Hebdomadaire</option>
                            <option value="monthly">Mensuel</option>
                            <option value="never">Jamais</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>

            <!-- Privacy Settings -->
            <div id="privacy" class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Confidentialité</h2>
                    <p class="text-sm text-gray-600 mt-1">Contrôlez la visibilité de vos données</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Profil public</h4>
                                <p class="text-sm text-gray-600">Permettre aux autres utilisateurs de voir votre profil</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Statistiques publiques</h4>
                                <p class="text-sm text-gray-600">Afficher vos statistiques de lecture publiquement</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Collecte de données analytiques</h4>
                                <p class="text-sm text-gray-600">Permettre la collecte de données pour améliorer le service</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>

            <!-- Appearance Settings -->
            <div id="appearance" class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Apparence</h2>
                    <p class="text-sm text-gray-600 mt-1">Personnalisez l'apparence de l'interface</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Thème</label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="theme" value="light" class="sr-only peer" checked>
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-full h-16 bg-white rounded border mb-2"></div>
                                    <p class="text-sm font-medium text-center">Clair</p>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="theme" value="dark" class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-full h-16 bg-gray-800 rounded border mb-2"></div>
                                    <p class="text-sm font-medium text-center">Sombre</p>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="theme" value="auto" class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-full h-16 bg-gradient-to-r from-white to-gray-800 rounded border mb-2"></div>
                                    <p class="text-sm font-medium text-center">Auto</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="font_size" class="block text-sm font-medium text-gray-700 mb-2">Taille de police</label>
                            <select id="font_size" name="font_size"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="small">Petite</option>
                                <option value="medium" selected>Moyenne</option>
                                <option value="large">Grande</option>
                                <option value="extra-large">Très grande</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="density" class="block text-sm font-medium text-gray-700 mb-2">Densité d'affichage</label>
                            <select id="density" name="density"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="compact">Compacte</option>
                                <option value="comfortable" selected>Confortable</option>
                                <option value="spacious">Spacieuse</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
