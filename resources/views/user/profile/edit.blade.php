@extends('layouts.user-dashboard')

@section('page-title', 'Mon Profil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Mon Profil</h1>
            <p class="text-gray-600 mt-1">Gérez vos informations personnelles et préférences</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Profile Picture -->
                <div class="text-center mb-6">
                    <div class="relative inline-block">
                        <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <button class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors">
                            <i class="fas fa-camera text-sm"></i>
                        </button>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>
                    <div class="mt-2">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded-full">
                            Membre actif
                        </span>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-book text-blue-600 mr-3"></i>
                            <span class="text-sm text-gray-700">Livres lus</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $userStats['books_read'] ?? 47 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-heart text-red-600 mr-3"></i>
                            <span class="text-sm text-gray-700">Favoris</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ $userStats['favorites'] ?? 24 }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-calendar text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-700">Membre depuis</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">
                            {{ auth()->user()->created_at ? auth()->user()->created_at->format('M Y') : 'Jan 2024' }}
                        </span>
                    </div>
                </div>

                <!-- Reading Preferences -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Genres préférés</h4>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $preferredGenres = ['Fiction', 'Sci-Fi', 'Romance'];
                        @endphp
                        @foreach($preferredGenres as $genre)
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full">
                            {{ $genre }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Informations personnelles</h2>
                    <p class="text-sm text-gray-600 mt-1">Mettez à jour vos informations de profil</p>
                </div>
                
                <form class="p-6 space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                            <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">Date de naissance</label>
                            <input type="date" id="birth_date" name="birth_date" value="{{ auth()->user()->birth_date ?? '' }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Biographie</label>
                        <textarea id="bio" name="bio" rows="4" placeholder="Parlez-nous de vous et de vos goûts littéraires..."
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ auth()->user()->bio ?? '' }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Sauvegarder
                        </button>
                    </div>
                </form>
            </div>

            <!-- Reading Preferences -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Préférences de lecture</h2>
                    <p class="text-sm text-gray-600 mt-1">Personnalisez votre expérience de lecture</p>
                </div>
                
                <form class="p-6 space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Genres préférés</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @php
                                $genres = ['Fiction', 'Science-fiction', 'Romance', 'Thriller', 'Biographie', 'Fantaisie', 'Mystère', 'Historique', 'Philosophie'];
                            @endphp
                            @foreach($genres as $genre)
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" name="preferred_genres[]" value="{{ strtolower($genre) }}" 
                                       class="mr-3 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">{{ $genre }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="reading_goal" class="block text-sm font-medium text-gray-700 mb-2">Objectif mensuel</label>
                            <select id="reading_goal" name="reading_goal"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="1">1 livre par mois</option>
                                <option value="2">2 livres par mois</option>
                                <option value="3" selected>3 livres par mois</option>
                                <option value="5">5 livres par mois</option>
                                <option value="10">10 livres par mois</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="preferred_language" class="block text-sm font-medium text-gray-700 mb-2">Langue préférée</label>
                            <select id="preferred_language" name="preferred_language"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="fr" selected>Français</option>
                                <option value="en">Anglais</option>
                                <option value="es">Espagnol</option>
                                <option value="de">Allemand</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Sauvegarder les préférences
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Sécurité</h2>
                    <p class="text-sm text-gray-600 mt-1">Gérez votre mot de passe et la sécurité de votre compte</p>
                </div>
                
                <form class="p-6 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                        <input type="password" id="current_password" name="current_password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                            <input type="password" id="password" name="password"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-key mr-2"></i>Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notification Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Notifications</h2>
                    <p class="text-sm text-gray-600 mt-1">Choisissez comment vous souhaitez être informé</p>
                </div>
                
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Nouveaux livres</h4>
                            <p class="text-sm text-gray-600">Recevoir des notifications pour les nouvelles sorties</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Recommandations</h4>
                            <p class="text-sm text-gray-600">Recevoir des suggestions personnalisées</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Newsletter</h4>
                            <p class="text-sm text-gray-600">Recevoir notre newsletter hebdomadaire</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-white rounded-xl shadow-sm border border-red-200">
                <div class="p-6 border-b border-red-200">
                    <h2 class="text-lg font-semibold text-red-900">Zone de danger</h2>
                    <p class="text-sm text-red-600 mt-1">Actions irréversibles sur votre compte</p>
                </div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-red-900">Supprimer mon compte</h4>
                            <p class="text-sm text-red-600">Cette action est irréversible et supprimera toutes vos données</p>
                        </div>
                        <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Supprimer le compte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
