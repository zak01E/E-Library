@extends('layouts.user-dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <!-- En-tête avec contrôles de lecture -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Salle de lecture</h1>
            <div class="flex items-center space-x-4">
                <button class="bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    Paramètres de lecture
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    Mode plein écran
                </button>
            </div>
        </div>

        <!-- Livre en cours de lecture -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mb-8">
            <div class="flex items-start space-x-6">
                <div class="flex-shrink-0">
                    <div class="w-32 h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg shadow-lg flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">SF</span>
                    </div>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold mb-2">Les Chroniques de l'Espace</h2>
                    <p class="text-gray-600 mb-4">Par Jean Dupont • Science Fiction</p>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Progression</span>
                            <span class="font-medium">65% (Page 234/360)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Continuer la lecture
                        </button>
                        <span class="text-sm text-gray-600">Temps restant estimé: 2h 15min</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Outils de lecture -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Notes et annotations -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Notes & Annotations
                    </h3>
                    <span class="text-sm text-gray-500">12 notes</span>
                </div>
                <div class="space-y-3 max-h-40 overflow-y-auto">
                    <div class="p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                        <p class="text-sm font-medium">Page 145</p>
                        <p class="text-sm text-gray-600">Citation intéressante sur l'exploration spatiale...</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                        <p class="text-sm font-medium">Page 189</p>
                        <p class="text-sm text-gray-600">Point important à retenir pour la suite...</p>
                    </div>
                </div>
                <button class="w-full mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium">
                    Voir toutes les notes →
                </button>
            </div>

            <!-- Signets -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        Signets
                    </h3>
                    <span class="text-sm text-gray-500">5 signets</span>
                </div>
                <div class="space-y-2">
                    <button class="w-full text-left p-2 hover:bg-gray-50 rounded flex justify-between items-center">
                        <span class="text-sm">Chapitre 3 - Début</span>
                        <span class="text-xs text-gray-500">Page 45</span>
                    </button>
                    <button class="w-full text-left p-2 hover:bg-gray-50 rounded flex justify-between items-center">
                        <span class="text-sm">Scène importante</span>
                        <span class="text-xs text-gray-500">Page 123</span>
                    </button>
                    <button class="w-full text-left p-2 hover:bg-gray-50 rounded flex justify-between items-center">
                        <span class="text-sm">Révélation</span>
                        <span class="text-xs text-gray-500">Page 201</span>
                    </button>
                </div>
                <button class="w-full mt-4 bg-red-100 text-red-600 py-2 rounded hover:bg-red-200">
                    + Ajouter un signet
                </button>
            </div>

            <!-- Dictionnaire et traduction -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Outils linguistiques
                    </h3>
                </div>
                <div class="space-y-3">
                    <button class="w-full bg-green-50 text-green-700 py-2 rounded hover:bg-green-100">
                        Dictionnaire intégré
                    </button>
                    <button class="w-full bg-blue-50 text-blue-700 py-2 rounded hover:bg-blue-100">
                        Traducteur
                    </button>
                    <button class="w-full bg-purple-50 text-purple-700 py-2 rounded hover:bg-purple-100">
                        Recherche dans le livre
                    </button>
                </div>
            </div>
        </div>

        <!-- Sessions de lecture récentes -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Reprendre la lecture</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                $books = [
                    ['title' => 'Les Misérables', 'author' => 'Victor Hugo', 'progress' => 45, 'color' => 'red'],
                    ['title' => '1984', 'author' => 'George Orwell', 'progress' => 78, 'color' => 'gray'],
                    ['title' => 'Le Petit Prince', 'author' => 'Antoine de Saint-Exupéry', 'progress' => 100, 'color' => 'yellow'],
                    ['title' => 'L\'Étranger', 'author' => 'Albert Camus', 'progress' => 23, 'color' => 'blue']
                ];
                @endphp

                @foreach($books as $book)
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                    <div class="aspect-[3/4] bg-gradient-to-br from-{{ $book['color'] }}-400 to-{{ $book['color'] }}-600 rounded mb-3 relative">
                        @if($book['progress'] == 100)
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                            Terminé
                        </div>
                        @endif
                    </div>
                    <h4 class="font-medium text-sm mb-1 truncate">{{ $book['title'] }}</h4>
                    <p class="text-xs text-gray-600 mb-2">{{ $book['author'] }}</p>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-{{ $book['color'] }}-500 h-2 rounded-full" style="width: {{ $book['progress'] }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $book['progress'] }}% lu</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Paramètres de lecture personnalisés -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Personnalisation de la lecture</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Thème de lecture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thème</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button class="p-3 bg-white border-2 border-blue-500 rounded text-center">
                            <div class="w-full h-12 bg-white mb-1 rounded border"></div>
                            <span class="text-xs">Clair</span>
                        </button>
                        <button class="p-3 bg-gray-800 border-2 border-transparent rounded text-center">
                            <div class="w-full h-12 bg-gray-900 mb-1 rounded"></div>
                            <span class="text-xs text-white">Sombre</span>
                        </button>
                        <button class="p-3 bg-yellow-50 border-2 border-transparent rounded text-center">
                            <div class="w-full h-12 bg-yellow-100 mb-1 rounded"></div>
                            <span class="text-xs">Sépia</span>
                        </button>
                    </div>
                </div>

                <!-- Taille de police -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Taille du texte</label>
                    <div class="flex items-center space-x-3">
                        <button class="p-2 bg-white border rounded hover:bg-gray-50">
                            <span class="text-sm">A-</span>
                        </button>
                        <span class="flex-1 text-center font-medium">16px</span>
                        <button class="p-2 bg-white border rounded hover:bg-gray-50">
                            <span class="text-lg">A+</span>
                        </button>
                    </div>
                    <input type="range" min="12" max="24" value="16" class="w-full mt-2">
                </div>

                <!-- Police -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Police</label>
                    <select class="w-full rounded-md border-gray-300 shadow-sm">
                        <option>Georgia</option>
                        <option>Arial</option>
                        <option>Times New Roman</option>
                        <option>Helvetica</option>
                        <option>Open Sans</option>
                    </select>
                </div>

                <!-- Espacement -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Espacement</label>
                    <div class="space-y-2">
                        <select class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                            <option>Interligne normal</option>
                            <option>Interligne 1.5</option>
                            <option>Interligne double</option>
                        </select>
                        <select class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                            <option>Marges normales</option>
                            <option>Marges larges</option>
                            <option>Marges étroites</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Options supplémentaires -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">Mode nuit automatique</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">Afficher la progression</span>
                </label>
                <label class="flex items-center space-x-3">
                    <input type="checkbox" checked class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm">Sync. entre appareils</span>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection