@extends('layouts.user-dashboard')

@section('title', 'Livres populaires')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Livres populaires</h2>
            <p class="mt-1 text-sm text-gray-600">Les plus lus et appréciés par notre communauté</p>
        </div>
        <div class="flex items-center space-x-3">
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Toutes catégories</option>
                <option>Fiction</option>
                <option>Non-fiction</option>
                <option>Science</option>
                <option>Histoire</option>
                <option>Jeunesse</option>
            </select>
            <select class="border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                <option>Cette semaine</option>
                <option>Ce mois</option>
                <option>Cette année</option>
                <option>Tous les temps</option>
            </select>
        </div>
    </div>

    <!-- Top 3 Popular Books -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- #1 Most Popular -->
        <div class="relative bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg p-6 text-white shadow-xl">
            <div class="absolute top-2 right-2">
                <div class="bg-white text-orange-500 rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl">
                    #1
                </div>
            </div>
            <img src="https://via.placeholder.com/200x300" alt="Top 1" class="w-full h-64 object-cover rounded-lg mb-4">
            <h3 class="text-xl font-bold mb-1">Le Petit Prince</h3>
            <p class="text-sm opacity-90 mb-3">Antoine de Saint-Exupéry</p>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    12,456 lectures
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    4.9 (2,341 avis)
                </div>
            </div>
            <button class="w-full mt-4 bg-white text-orange-500 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                Lire maintenant
            </button>
        </div>

        <!-- #2 Most Popular -->
        <div class="relative bg-gradient-to-br from-gray-400 to-gray-600 rounded-lg p-6 text-white shadow-xl">
            <div class="absolute top-2 right-2">
                <div class="bg-white text-gray-600 rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl">
                    #2
                </div>
            </div>
            <img src="https://via.placeholder.com/200x300" alt="Top 2" class="w-full h-64 object-cover rounded-lg mb-4">
            <h3 class="text-xl font-bold mb-1">1984</h3>
            <p class="text-sm opacity-90 mb-3">George Orwell</p>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    10,234 lectures
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    4.8 (1,876 avis)
                </div>
            </div>
            <button class="w-full mt-4 bg-white text-gray-600 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                Lire maintenant
            </button>
        </div>

        <!-- #3 Most Popular -->
        <div class="relative bg-gradient-to-br from-amber-600 to-amber-800 rounded-lg p-6 text-white shadow-xl">
            <div class="absolute top-2 right-2">
                <div class="bg-white text-amber-700 rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl">
                    #3
                </div>
            </div>
            <img src="https://via.placeholder.com/200x300" alt="Top 3" class="w-full h-64 object-cover rounded-lg mb-4">
            <h3 class="text-xl font-bold mb-1">L'Étranger</h3>
            <p class="text-sm opacity-90 mb-3">Albert Camus</p>
            <div class="space-y-2">
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    9,876 lectures
                </div>
                <div class="flex items-center text-sm">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    4.7 (1,654 avis)
                </div>
            </div>
            <button class="w-full mt-4 bg-white text-amber-700 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                Lire maintenant
            </button>
        </div>
    </div>

    <!-- Trending Now -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                </svg>
                En tendance maintenant
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <div class="flex space-x-4">
                    @for ($i = 1; $i <= 8; $i++)
                    <div class="flex-shrink-0 w-32">
                        <img src="https://via.placeholder.com/150x225" alt="Trending {{ $i }}" class="w-full h-48 object-cover rounded-lg shadow-md mb-2">
                        <h4 class="text-sm font-medium text-gray-900 truncate">Titre tendance {{ $i }}</h4>
                        <div class="flex items-center mt-1">
                            <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs text-gray-500">+{{ rand(20, 150) }}%</span>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Popular by Category -->
    <div class="space-y-6">
        <!-- Fiction -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Les plus populaires en Fiction</h3>
                <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Voir tout</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for ($i = 4; $i <= 7; $i++)
                <div class="flex bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <span class="text-2xl font-bold text-gray-400 mr-4">#{{ $i }}</span>
                    <img src="https://via.placeholder.com/80x120" alt="Book {{ $i }}" class="w-20 h-28 object-cover rounded mr-4">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">Les Misérables</h4>
                        <p class="text-sm text-gray-600">Victor Hugo</p>
                        <div class="flex items-center mt-2">
                            <div class="flex text-yellow-400">
                                @for ($j = 0; $j < 5; $j++)
                                <svg class="w-4 h-4 {{ $j < 4 ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">({{ rand(500, 1500) }})</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ rand(5000, 9000) }} lectures</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Non-fiction -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Les plus populaires en Non-fiction</h3>
                <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Voir tout</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @for ($i = 8; $i <= 11; $i++)
                <div class="flex bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <span class="text-2xl font-bold text-gray-400 mr-4">#{{ $i - 7 }}</span>
                    <img src="https://via.placeholder.com/80x120" alt="Book {{ $i }}" class="w-20 h-28 object-cover rounded mr-4">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900">Sapiens</h4>
                        <p class="text-sm text-gray-600">Yuval Noah Harari</p>
                        <div class="flex items-center mt-2">
                            <div class="flex text-yellow-400">
                                @for ($j = 0; $j < 5; $j++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 ml-1">({{ rand(800, 2000) }})</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ rand(4000, 8000) }} lectures</p>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Reading Stats -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques de lecture</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-3xl font-bold text-blue-600">156K</p>
                <p class="text-sm text-gray-600">Lectures cette semaine</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-purple-600">2.3M</p>
                <p class="text-sm text-gray-600">Pages lues</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-green-600">45min</p>
                <p class="text-sm text-gray-600">Temps moyen/livre</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-orange-600">89%</p>
                <p class="text-sm text-gray-600">Taux de satisfaction</p>
            </div>
        </div>
    </div>
</div>
@endsection