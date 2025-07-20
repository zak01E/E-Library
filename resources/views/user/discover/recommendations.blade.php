@extends('layouts.user-dashboard')

@section('title', 'Recommandations pour vous')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Recommandations pour vous</h2>
            <p class="mt-1 text-sm text-gray-600">Basées sur vos lectures et préférences</p>
        </div>
        <button class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Actualiser les recommandations
        </button>
    </div>

    <!-- Recommendation Categories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Based on Reading History -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
            <div class="flex items-center mb-3">
                <div class="bg-purple-500 text-white p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-purple-900">Basé sur votre historique</h3>
                    <p class="text-sm text-purple-700">23 suggestions</p>
                </div>
            </div>
        </div>

        <!-- Similar Readers -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
            <div class="flex items-center mb-3">
                <div class="bg-green-500 text-white p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-green-900">Lecteurs similaires aiment</h3>
                    <p class="text-sm text-green-700">15 suggestions</p>
                </div>
            </div>
        </div>

        <!-- Trending in Your Genres -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6 border border-orange-200">
            <div class="flex items-center mb-3">
                <div class="bg-orange-500 text-white p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-orange-900">Tendances dans vos genres</h3>
                    <p class="text-sm text-orange-700">18 suggestions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Personalized Recommendation Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-semibold text-gray-900">Parce que vous avez lu "1984"</h3>
                <p class="text-sm text-gray-600 mt-1">Autres dystopies captivantes</p>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Voir tout</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @for ($i = 1; $i <= 6; $i++)
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-lg shadow-md transition-all group-hover:shadow-xl">
                    <img src="https://via.placeholder.com/200x300" alt="Book" class="w-full h-56 object-cover">
                    <div class="absolute top-2 left-2">
                        <span class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">{{ rand(85, 98) }}% match</span>
                    </div>
                </div>
                <div class="mt-2">
                    <h4 class="font-medium text-gray-900 text-sm truncate">Le Meilleur des Mondes</h4>
                    <p class="text-xs text-gray-600">Aldous Huxley</p>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- AI Recommendations -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
        <div class="flex items-start space-x-4">
            <div class="bg-blue-500 text-white p-3 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Recommandations IA personnalisées</h3>
                <p class="text-gray-600 mb-4">Notre intelligence artificielle a analysé vos habitudes de lecture et vous suggère ces titres uniques</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex space-x-3">
                            <img src="https://via.placeholder.com/60x90" alt="Book" class="w-15 h-20 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">Les Dépossédés</h4>
                                <p class="text-sm text-gray-600">Ursula K. Le Guin</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for ($j = 0; $j < 5; $j++)
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">4.7</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Science-Fiction • Philosophie</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex space-x-3">
                            <img src="https://via.placeholder.com/60x90" alt="Book" class="w-15 h-20 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">La Servante écarlate</h4>
                                <p class="text-sm text-gray-600">Margaret Atwood</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-400">
                                        @for ($j = 0; $j < 5; $j++)
                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-500 ml-1">4.9</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Dystopie • Féminisme</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Genre-based Recommendations -->
    <div class="space-y-6">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Dans vos genres favoris</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Science-Fiction</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200">Thriller</button>
                    <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200">Histoire</button>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @for ($i = 1; $i <= 10; $i++)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition cursor-pointer">
                    <img src="https://via.placeholder.com/150x225" alt="Book" class="w-full h-48 object-cover rounded mb-3">
                    <h4 class="font-medium text-gray-900 text-sm truncate">Titre du livre {{ $i }}</h4>
                    <p class="text-xs text-gray-600 truncate">Auteur {{ $i }}</p>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex text-yellow-400">
                            @for ($j = 0; $j < 5; $j++)
                            <svg class="w-3 h-3 {{ $j < 4 ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <button class="text-blue-600 hover:text-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gray-50 rounded-lg p-6 text-center">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Voulez-vous affiner vos recommandations ?</h3>
        <p class="text-gray-600 mb-4">Dites-nous en plus sur vos goûts pour obtenir des suggestions encore plus personnalisées</p>
        <div class="flex justify-center space-x-4">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Mettre à jour mes préférences
            </button>
            <button class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-white transition">
                Noter plus de livres
            </button>
        </div>
    </div>
</div>
@endsection