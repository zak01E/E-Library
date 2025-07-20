@extends('layouts.user-dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Mes réservations</h1>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle réservation
            </button>
        </div>

        <!-- Statistiques des réservations -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600">Réservations actives</p>
                        <p class="text-2xl font-bold text-blue-800">3</p>
                    </div>
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-green-600">Disponibles</p>
                        <p class="text-2xl font-bold text-green-800">1</p>
                    </div>
                    <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-orange-600">En attente</p>
                        <p class="text-2xl font-bold text-orange-800">2</p>
                    </div>
                    <svg class="w-10 h-10 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-purple-600">Total ce mois</p>
                        <p class="text-2xl font-bold text-purple-800">8</p>
                    </div>
                    <svg class="w-10 h-10 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Réservations actives -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Réservations actives</h2>
            <div class="space-y-4">
                <!-- Réservation disponible -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded"></div>
                            </div>
                            <div>
                                <h3 class="font-semibold">Le Nom de la Rose</h3>
                                <p class="text-sm text-gray-600">Par Umberto Eco</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm"><span class="font-medium">Réservé le:</span> 15 juillet 2025</p>
                                    <p class="text-sm text-green-600 font-medium">✓ Disponible maintenant</p>
                                    <p class="text-sm text-red-600">⚠️ À récupérer avant le 20 juillet 2025</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right space-y-2">
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Disponible</span>
                            <button class="block w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                                Emprunter maintenant
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Réservation en attente -->
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded"></div>
                            </div>
                            <div>
                                <h3 class="font-semibold">1984</h3>
                                <p class="text-sm text-gray-600">Par George Orwell</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm"><span class="font-medium">Réservé le:</span> 10 juillet 2025</p>
                                    <p class="text-sm text-orange-600">Position dans la file: 3/5</p>
                                    <p class="text-sm">Temps d'attente estimé: ~5 jours</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right space-y-2">
                            <span class="inline-block bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">En attente</span>
                            <button class="block w-full bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                                Annuler
                            </button>
                        </div>
                    </div>
                    <!-- Barre de progression -->
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Position actuelle</span>
                            <span>3 sur 5</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full" style="width: 40%"></div>
                        </div>
                    </div>
                </div>

                <!-- Autre réservation en attente -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded"></div>
                            </div>
                            <div>
                                <h3 class="font-semibold">L'Alchimiste</h3>
                                <p class="text-sm text-gray-600">Par Paulo Coelho</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-sm"><span class="font-medium">Réservé le:</span> 18 juillet 2025</p>
                                    <p class="text-sm text-blue-600">Position dans la file: 1/2</p>
                                    <p class="text-sm">Disponibilité prévue: Demain</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right space-y-2">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Bientôt disponible</span>
                            <button class="block w-full bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                                Annuler
                            </button>
                        </div>
                    </div>
                    <!-- Barre de progression -->
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Position actuelle</span>
                            <span>1 sur 2</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des réservations -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Historique des réservations</h2>
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date réservation</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date emprunt</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                        $history = [
                            ['title' => 'Les Misérables', 'author' => 'Victor Hugo', 'reserved' => '01/07/2025', 'borrowed' => '03/07/2025', 'status' => 'completed'],
                            ['title' => 'Le Petit Prince', 'author' => 'Saint-Exupéry', 'reserved' => '25/06/2025', 'borrowed' => '26/06/2025', 'status' => 'completed'],
                            ['title' => 'Dune', 'author' => 'Frank Herbert', 'reserved' => '20/06/2025', 'borrowed' => '-', 'status' => 'expired'],
                            ['title' => 'Harry Potter', 'author' => 'J.K. Rowling', 'reserved' => '15/06/2025', 'borrowed' => '16/06/2025', 'status' => 'completed'],
                            ['title' => 'Le Seigneur des Anneaux', 'author' => 'J.R.R. Tolkien', 'reserved' => '10/06/2025', 'borrowed' => '-', 'status' => 'cancelled'],
                        ];
                        @endphp

                        @foreach($history as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $item['title'] }}</div>
                                    <div class="text-sm text-gray-500">{{ $item['author'] }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item['reserved'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item['borrowed'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item['status'] == 'completed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Complété
                                    </span>
                                @elseif($item['status'] == 'expired')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Expiré
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Annulé
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button class="text-blue-600 hover:text-blue-900">Réserver à nouveau</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Livres populaires à réserver -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Livres populaires disponibles à la réservation</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @for($i = 1; $i <= 6; $i++)
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-gradient-to-br from-purple-400 to-pink-600 rounded-lg mb-2 relative overflow-hidden">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white p-2 text-xs">
                            <p>{{ rand(0, 5) }} personnes en attente</p>
                        </div>
                        <button class="absolute top-2 right-2 bg-white text-gray-900 p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </button>
                    </div>
                    <h3 class="font-medium text-sm truncate">Titre populaire {{ $i }}</h3>
                    <p class="text-xs text-gray-600">Disponible dans ~{{ rand(1, 7) }} jours</p>
                </div>
                @endfor
            </div>
        </div>

        <!-- Règles de réservation -->
        <div class="bg-blue-50 rounded-lg p-6">
            <h3 class="font-semibold mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Règles de réservation
            </h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    Vous pouvez réserver jusqu'à 5 livres simultanément
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    Les livres réservés doivent être récupérés dans les 48h suivant la notification
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    Les réservations peuvent être annulées jusqu'à 24h avant la disponibilité
                </li>
                <li class="flex items-start">
                    <span class="text-blue-600 mr-2">•</span>
                    La durée d'emprunt est de 14 jours, renouvelable une fois si aucune réservation n'est en attente
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection