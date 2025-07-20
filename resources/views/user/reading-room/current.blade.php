@extends('layouts.user-dashboard')

@section('title', 'Lecture en cours')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Lecture en cours</h2>
            <p class="mt-1 text-sm text-gray-600">Reprenez là où vous vous êtes arrêté</p>
        </div>
        <div class="flex items-center space-x-3">
            <button class="text-gray-600 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </button>
            <button class="text-gray-600 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Currently Reading - Primary Book -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 text-white shadow-2xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <img src="https://via.placeholder.com/300x450" alt="Current Book" class="w-full rounded-lg shadow-2xl">
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <h3 class="text-3xl font-bold">Les Dépossédés</h3>
                    <p class="text-xl opacity-90">Ursula K. Le Guin</p>
                </div>
                
                <!-- Reading Progress -->
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span>Progression</span>
                        <span>65% (Page 234 sur 360)</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-3">
                        <div class="bg-white h-3 rounded-full transition-all duration-500" style="width: 65%"></div>
                    </div>
                </div>

                <!-- Reading Stats -->
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="bg-white/10 rounded-lg p-3">
                        <p class="text-2xl font-bold">3h 45min</p>
                        <p class="text-sm opacity-75">Temps de lecture</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-3">
                        <p class="text-2xl font-bold">2h 15min</p>
                        <p class="text-sm opacity-75">Temps restant estimé</p>
                    </div>
                    <div class="bg-white/10 rounded-lg p-3">
                        <p class="text-2xl font-bold">15</p>
                        <p class="text-sm opacity-75">Notes & signets</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-4">
                    <button class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Continuer la lecture
                    </button>
                    <button class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                        Voir les notes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Other Books in Progress -->
    <div>
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Autres livres en cours</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @for ($i = 1; $i <= 6; $i++)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
                <div class="p-4">
                    <div class="flex space-x-4">
                        <img src="https://via.placeholder.com/100x150" alt="Book {{ $i }}" class="w-24 h-36 object-cover rounded">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">Titre du livre {{ $i }}</h4>
                            <p class="text-sm text-gray-600">Auteur {{ $i }}</p>
                            
                            <!-- Progress -->
                            <div class="mt-3 space-y-1">
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>{{ rand(10, 80) }}%</span>
                                    <span>Page {{ rand(50, 300) }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ rand(10, 80) }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Last Read -->
                            <p class="text-xs text-gray-500 mt-2">
                                Dernière lecture : {{ rand(1, 7) }} jours
                            </p>
                            
                            <!-- Action -->
                            <button class="mt-3 w-full bg-blue-600 text-white py-2 rounded text-sm hover:bg-blue-700 transition">
                                Reprendre
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Reading Sessions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Sessions de lecture récentes</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @for ($i = 0; $i < 5; $i++)
                <div class="flex items-center justify-between py-3 {{ $i < 4 ? 'border-b border-gray-100' : '' }}">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ ['Les Dépossédés', '1984', 'Le Petit Prince', 'Sapiens', 'L\'Étranger'][$i] }}</p>
                            <p class="text-sm text-gray-500">{{ ['Aujourd\'hui', 'Hier', 'Il y a 2 jours', 'Il y a 3 jours', 'Il y a 4 jours'][$i] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">{{ rand(15, 120) }} min</p>
                        <p class="text-sm text-gray-500">{{ rand(10, 50) }} pages</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Reading Goals -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Daily Goal -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-green-900">Objectif quotidien</h3>
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm text-green-700 mb-1">
                        <span>45 min / 30 min</span>
                        <span>150%</span>
                    </div>
                    <div class="w-full bg-green-200 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
                <p class="text-sm text-green-700">Excellent ! Vous avez dépassé votre objectif de 15 minutes</p>
            </div>
        </div>

        <!-- Weekly Goal -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-purple-900">Objectif hebdomadaire</h3>
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm text-purple-700 mb-1">
                        <span>3 livres / 5 livres</span>
                        <span>60%</span>
                    </div>
                    <div class="w-full bg-purple-200 rounded-full h-3">
                        <div class="bg-purple-500 h-3 rounded-full" style="width: 60%"></div>
                    </div>
                </div>
                <p class="text-sm text-purple-700">Plus que 2 livres pour atteindre votre objectif !</p>
            </div>
        </div>
    </div>
</div>
@endsection