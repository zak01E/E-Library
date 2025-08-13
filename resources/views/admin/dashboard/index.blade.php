@extends('layouts.admin-dashboard')

@section('page-title', 'Tableau de bord')
@section('page-description', 'Vue d\'ensemble de votre plateforme E-Library')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Books Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total des livres</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_books'] ?? 0) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-xs text-green-600 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>12%
                        </span>
                        <span class="text-xs text-gray-500 ml-2">ce mois</span>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 p-3 rounded-full">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Utilisateurs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_users'] ?? 0) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-xs text-green-600 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>8%
                        </span>
                        <span class="text-xs text-gray-500 ml-2">ce mois</span>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-400 to-cyan-500 p-3 rounded-full">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Pending Books Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">En attente</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['pending_books'] ?? 0) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-xs text-orange-600 font-medium">
                            <i class="fas fa-clock mr-1"></i>À approuver
                        </span>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-orange-400 to-red-500 p-3 rounded-full">
                    <i class="fas fa-hourglass-half text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow duration-300 card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Utilisateurs actifs</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['active_users'] ?? 0) }}</p>
                    <div class="flex items-center mt-2">
                        <span class="text-xs text-green-600 font-medium">
                            <i class="fas fa-circle mr-1"></i>En ligne
                        </span>
                        <span class="text-xs text-gray-500 ml-2">30 derniers jours</span>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-400 to-emerald-500 p-3 rounded-full">
                    <i class="fas fa-user-check text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Activity Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Activité récente</h3>
                <button class="text-sm text-gray-500 hover:text-emerald-600 transition">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
            <div class="h-64 flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <i class="fas fa-chart-line text-6xl mb-3 text-emerald-200"></i>
                    <p>Graphique d'activité</p>
                </div>
            </div>
        </div>

        <!-- Categories Distribution -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Distribution par catégorie</h3>
                <button class="text-sm text-gray-500 hover:text-emerald-600 transition">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
            <div class="h-64 flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <i class="fas fa-chart-pie text-6xl mb-3 text-teal-200"></i>
                    <p>Graphique des catégories</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Books -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Livres récents</h3>
                <a href="{{ admin_route('books') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                @php
                $recentBooks = \App\Models\Book::latest()->take(5)->get();
                @endphp
                @forelse($recentBooks as $book)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-12 bg-gradient-to-br from-emerald-100 to-teal-100 rounded flex items-center justify-center">
                            <i class="fas fa-book text-emerald-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ Str::limit($book->title, 40) }}</p>
                            <p class="text-xs text-gray-500">{{ $book->author_name ?? 'Auteur inconnu' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($book->is_approved)
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-1 rounded">
                                Approuvé
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-1 rounded">
                                En attente
                            </span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Aucun livre récent</p>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
            <div class="space-y-2">
                <a href="{{ admin_route('books.create') }}" class="flex items-center justify-between p-3 hover:bg-emerald-50 rounded-lg transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center group-hover:bg-emerald-200 transition">
                            <i class="fas fa-plus text-emerald-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Ajouter un livre</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600 transition"></i>
                </a>

                <a href="{{ admin_route('users') }}" class="flex items-center justify-between p-3 hover:bg-blue-50 rounded-lg transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Gérer utilisateurs</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
                </a>

                <a href="{{ admin_route('categories') }}" class="flex items-center justify-between p-3 hover:bg-teal-50 rounded-lg transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center group-hover:bg-teal-200 transition">
                            <i class="fas fa-tags text-teal-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Catégories</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-teal-600 transition"></i>
                </a>

                <a href="{{ admin_route('settings') }}" class="flex items-center justify-between p-3 hover:bg-purple-50 rounded-lg transition group">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition">
                            <i class="fas fa-cog text-purple-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Paramètres</span>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600 transition"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-200">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-server text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">État du système</h3>
                    <p class="text-sm text-gray-600">Tous les services fonctionnent normalement</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <span class="flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <span class="text-sm font-medium text-green-700">En ligne</span>
            </div>
        </div>
    </div>
</div>
@endsection