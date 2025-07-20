@extends('layouts.user-dashboard')

@section('title', 'Nouveautés')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Nouveautés</h2>
            <p class="mt-1 text-sm text-gray-600">Découvrez les derniers livres ajoutés à notre collection</p>
        </div>
        <div class="flex items-center space-x-3">
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Cette semaine</option>
                <option>Ce mois</option>
                <option>Les 3 derniers mois</option>
                <option>Cette année</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filtres avancés
            </button>
        </div>
    </div>

    <!-- Featured New Release -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 text-white">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                <img src="https://via.placeholder.com/300x450" alt="Featured Book" class="w-full rounded-lg shadow-2xl">
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <span class="inline-block bg-yellow-400 text-yellow-900 text-xs font-semibold px-3 py-1 rounded-full">NOUVEAU CETTE SEMAINE</span>
                    <h3 class="text-3xl font-bold mt-2">L'Odyssée du Futur</h3>
                    <p class="text-xl opacity-90">par Marie Dubois</p>
                </div>
                <p class="text-lg opacity-90 leading-relaxed">
                    Une épopée de science-fiction captivante qui explore les limites de l'humanité dans un futur où la technologie et la conscience fusionnent. Suivez l'aventure extraordinaire d'Elena alors qu'elle navigue dans un monde transformé...
                </p>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="ml-1">4.8 (124 avis)</span>
                    </div>
                    <span>•</span>
                    <span>Science-Fiction</span>
                    <span>•</span>
                    <span>523 pages</span>
                </div>
                <div class="flex space-x-4 pt-4">
                    <button class="bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Emprunter maintenant
                    </button>
                    <button class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                        Ajouter aux favoris
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- New Books Grid -->
    <div>
        <h3 class="text-xl font-semibold text-gray-900 mb-4">Ajoutés cette semaine</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            @for ($i = 1; $i <= 12; $i++)
            <div class="group cursor-pointer">
                <div class="relative overflow-hidden rounded-lg shadow-lg transition-transform group-hover:scale-105">
                    <img src="https://via.placeholder.com/200x300" alt="Book {{ $i }}" class="w-full h-72 object-cover">
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">NOUVEAU</span>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                                Voir détails
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <h4 class="font-semibold text-gray-900 truncate">Titre du livre {{ $i }}</h4>
                    <p class="text-sm text-gray-600 truncate">Auteur {{ $i }}</p>
                    <div class="flex items-center mt-1">
                        <div class="flex text-yellow-400">
                            @for ($j = 0; $j < 5; $j++)
                            <svg class="w-4 h-4 {{ $j < 4 ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 ml-1">({{ rand(10, 200) }})</span>
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-center space-x-2 mt-8">
        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100">Précédent</button>
        <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100">2</button>
        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100">3</button>
        <span class="px-2 text-gray-500">...</span>
        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100">10</button>
        <button class="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100">Suivant</button>
    </div>
</div>
@endsection