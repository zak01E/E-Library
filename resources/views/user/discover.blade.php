@extends('layouts.user-dashboard')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h1 class="text-2xl font-bold mb-6">Découvrir de nouveaux livres</h1>

        <!-- Recommandations personnalisées -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                    Recommandés pour vous
                </h2>
                <button class="text-sm text-blue-600 hover:text-blue-800">Actualiser</button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @for($i = 1; $i <= 6; $i++)
                <div class="group cursor-pointer">
                    <div class="aspect-[3/4] bg-gradient-to-br from-purple-400 to-pink-600 rounded-lg mb-2 relative overflow-hidden group-hover:shadow-lg transition">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition flex items-center justify-center">
                            <button class="opacity-0 group-hover:opacity-100 bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-medium transform scale-95 group-hover:scale-100 transition">
                                Voir détails
                            </button>
                        </div>
                        @if($i == 1)
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">Nouveau</span>
                        @endif
                    </div>
                    <h3 class="font-medium text-sm truncate">Titre du livre {{ $i }}</h3>
                    <p class="text-xs text-gray-600 truncate">Auteur {{ $i }}</p>
                    <div class="flex items-center mt-1">
                        <div class="flex text-yellow-400">
                            @for($j = 0; $j < 5; $j++)
                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-xs ml-1 text-gray-500">(4.5)</span>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Catégories à explorer -->
        <div class="mb-10">
            <h2 class="text-lg font-semibold mb-4">Explorer par catégorie</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @php
                $categories = [
                    ['name' => 'Science Fiction', 'icon' => '🚀', 'color' => 'blue'],
                    ['name' => 'Romance', 'icon' => '💕', 'color' => 'pink'],
                    ['name' => 'Thriller', 'icon' => '🔍', 'color' => 'gray'],
                    ['name' => 'Fantasy', 'icon' => '🐉', 'color' => 'purple'],
                    ['name' => 'Histoire', 'icon' => '📜', 'color' => 'yellow'],
                    ['name' => 'Développement', 'icon' => '🌱', 'color' => 'green'],
                ];
                @endphp

                @foreach($categories as $category)
                <button class="bg-{{ $category['color'] }}-50 hover:bg-{{ $category['color'] }}-100 border border-{{ $category['color'] }}-200 rounded-lg p-4 text-center transition">
                    <div class="text-3xl mb-2">{{ $category['icon'] }}</div>
                    <p class="text-sm font-medium text-{{ $category['color'] }}-900">{{ $category['name'] }}</p>
                    <p class="text-xs text-{{ $category['color'] }}-600 mt-1">234 livres</p>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Tendances du moment -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                    </svg>
                    Tendances cette semaine
                </h2>
                <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Voir tout →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 1; $i <= 6; $i++)
                <div class="flex space-x-4 bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition cursor-pointer">
                    <div class="flex-shrink-0">
                        <div class="w-20 h-28 bg-gradient-to-br from-red-400 to-orange-600 rounded"></div>
                    </div>
                    <div class="flex-1">
                        <span class="text-2xl font-bold text-gray-400">#{{ $i }}</span>
                        <h3 class="font-semibold mt-1">Titre tendance {{ $i }}</h3>
                        <p class="text-sm text-gray-600">Par Auteur Populaire</p>
                        <p class="text-xs text-gray-500 mt-1">
                            <span class="text-green-600">↑ 15%</span> cette semaine • 
                            1.2k lectures
                        </p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Collections thématiques -->
        <div class="mb-10">
            <h2 class="text-lg font-semibold mb-4">Collections thématiques</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Collection Été -->
                <div class="bg-gradient-to-r from-yellow-100 to-orange-100 rounded-lg p-6 hover:shadow-lg transition cursor-pointer">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-lg">Lectures d'été ☀️</h3>
                        <span class="bg-white px-2 py-1 rounded-full text-xs">25 livres</span>
                    </div>
                    <p class="text-sm text-gray-700 mb-4">Des histoires légères et captivantes pour vos vacances</p>
                    <div class="flex -space-x-2">
                        @for($j = 0; $j < 4; $j++)
                        <div class="w-10 h-14 bg-gradient-to-br from-yellow-300 to-orange-400 rounded border-2 border-white"></div>
                        @endfor
                        <div class="w-10 h-14 bg-gray-300 rounded border-2 border-white flex items-center justify-center text-xs font-medium">+21</div>
                    </div>
                </div>

                <!-- Collection Classiques -->
                <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-lg p-6 hover:shadow-lg transition cursor-pointer">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-lg">Classiques intemporels 📚</h3>
                        <span class="bg-white px-2 py-1 rounded-full text-xs">50 livres</span>
                    </div>
                    <p class="text-sm text-gray-700 mb-4">Les œuvres qui ont marqué l'histoire de la littérature</p>
                    <div class="flex -space-x-2">
                        @for($j = 0; $j < 4; $j++)
                        <div class="w-10 h-14 bg-gradient-to-br from-gray-400 to-gray-600 rounded border-2 border-white"></div>
                        @endfor
                        <div class="w-10 h-14 bg-gray-300 rounded border-2 border-white flex items-center justify-center text-xs font-medium">+46</div>
                    </div>
                </div>

                <!-- Collection Nouveautés -->
                <div class="bg-gradient-to-r from-green-100 to-blue-100 rounded-lg p-6 hover:shadow-lg transition cursor-pointer">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-lg">Nouveautés du mois 🆕</h3>
                        <span class="bg-white px-2 py-1 rounded-full text-xs">18 livres</span>
                    </div>
                    <p class="text-sm text-gray-700 mb-4">Les dernières sorties à ne pas manquer</p>
                    <div class="flex -space-x-2">
                        @for($j = 0; $j < 4; $j++)
                        <div class="w-10 h-14 bg-gradient-to-br from-green-300 to-blue-400 rounded border-2 border-white"></div>
                        @endfor
                        <div class="w-10 h-14 bg-gray-300 rounded border-2 border-white flex items-center justify-center text-xs font-medium">+14</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auteurs à découvrir -->
        <div class="mb-10">
            <h2 class="text-lg font-semibold mb-4">Auteurs à découvrir</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @for($i = 1; $i <= 6; $i++)
                <div class="text-center group cursor-pointer">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full mb-3 group-hover:shadow-lg transition"></div>
                    <h3 class="font-medium text-sm">Auteur {{ $i }}</h3>
                    <p class="text-xs text-gray-600">15 livres</p>
                    <button class="mt-2 text-xs text-blue-600 hover:text-blue-800">Suivre</button>
                </div>
                @endfor
            </div>
        </div>

        <!-- Quiz de recommandation -->
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-8 text-center">
            <h2 class="text-xl font-bold mb-3">Pas sûr de quoi lire ensuite ?</h2>
            <p class="text-gray-700 mb-6">Répondez à notre quiz rapide et obtenez des recommandations personnalisées basées sur vos goûts littéraires.</p>
            <button class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-medium">
                Commencer le quiz (2 min)
            </button>
        </div>

        <!-- Filtres de recherche avancée -->
        <div class="mt-10 bg-gray-50 rounded-lg p-6">
            <h3 class="font-semibold mb-4">Recherche avancée</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                    <select class="w-full rounded-md border-gray-300 shadow-sm">
                        <option>Tous les genres</option>
                        <option>Science Fiction</option>
                        <option>Romance</option>
                        <option>Thriller</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
                    <select class="w-full rounded-md border-gray-300 shadow-sm">
                        <option>Français</option>
                        <option>Anglais</option>
                        <option>Espagnol</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Note minimum</label>
                    <select class="w-full rounded-md border-gray-300 shadow-sm">
                        <option>Toutes les notes</option>
                        <option>4★ et plus</option>
                        <option>4.5★ et plus</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Année de publication</label>
                    <select class="w-full rounded-md border-gray-300 shadow-sm">
                        <option>Toutes les années</option>
                        <option>2025</option>
                        <option>2024</option>
                        <option>2023</option>
                        <option>Avant 2020</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-center">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Appliquer les filtres
                </button>
            </div>
        </div>
    </div>
</div>
@endsection