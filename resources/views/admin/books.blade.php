@extends('layouts.admin-dashboard')

@section('page-title', 'Gestion des Livres')
@section('page-description', 'Gérez tous les livres de votre plateforme eLibrary')

@push('styles')
<style>
    .compact-table {
        font-size: 0.8rem;
    }
    .compact-table td {
        padding: 0.375rem 0.5rem;
        vertical-align: middle;
    }
    .compact-table th {
        padding: 0.375rem 0.5rem;
        font-size: 0.7rem;
        font-weight: 600;
    }
    .action-btn {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.25rem;
        transition: all 0.15s ease-in-out;
    }
    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush



@section('content')
    <!-- Conteneur principal des statistiques -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6 p-6">
        <!-- Titre et actions principales -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tableau de bord des livres</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Vue d'ensemble et statistiques de la bibliothèque</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ admin_route('books.create') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Ajouter un livre
                </a>
                <button type="button" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Exporter
                </button>
            </div>
        </div>

        <!-- Statistiques principales en ligne -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
            <!-- Total -->
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total'] ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Total livres</div>
            </div>
            <!-- Approuvés -->
            <div class="text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['approved'] ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Approuvés</div>
            </div>
            <!-- En attente -->
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">En attente</div>
            </div>
            <!-- Rejetés -->
            <div class="text-center">
                <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $stats['rejected'] ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Rejetés</div>
            </div>
            <!-- Avec niveau -->
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['with_level'] ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Avec niveau</div>
            </div>
            <!-- Sans niveau -->
            <div class="text-center">
                <div class="text-3xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['without_level'] ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Sans niveau</div>
            </div>
            <!-- Téléchargements -->
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $books->sum('downloads') }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Téléchargements</div>
            </div>
            <!-- Vues -->
            <div class="text-center">
                <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">{{ $books->sum('views') ?? 0 }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">Vues totales</div>
            </div>
        </div>

        <!-- Barres de progression par statut -->
        <div class="space-y-3">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Livres approuvés</span>
                    <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $stats['approved'] ?? 0 }} / {{ $stats['total'] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['total'] > 0 ? round(($stats['approved'] / $stats['total']) * 100) : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Livres avec niveau éducatif</span>
                    <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $stats['with_level'] ?? 0 }} / {{ $stats['total'] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['total'] > 0 ? round(($stats['with_level'] / $stats['total']) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <!-- En-tête compact avec titre et bouton filtres -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Liste des livres</h3>
                    @if(request()->hasAny(['search', 'status', 'level', 'category', 'language', 'year_from', 'year_to']))
                        <div class="flex items-center">
                            <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">Filtres actifs:</span>
                            <div class="flex flex-wrap items-center gap-1">
                                @php $filterCount = 0; @endphp
                                @if(request('search')) @php $filterCount++; @endphp @endif
                                @if(request('status') && request('status') !== 'all') @php $filterCount++; @endphp @endif
                                @if(request('level') && request('level') !== 'all') @php $filterCount++; @endphp @endif
                                @if(request('category') && request('category') !== 'all') @php $filterCount++; @endphp @endif
                                @if(request('language') && request('language') !== 'all') @php $filterCount++; @endphp @endif
                                @if(request('year_from') || request('year_to')) @php $filterCount++; @endphp @endif
                                
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $filterCount }} {{ $filterCount > 1 ? 'filtres' : 'filtre' }}
                                </span>
                                <a href="{{ admin_route('books') }}" class="ml-2 text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                    <i class="fas fa-times"></i> Réinitialiser
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="toggleFilters()" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        {{ request()->hasAny(['search', 'status', 'level', 'category', 'language', 'year_from', 'year_to']) ? 'Modifier les filtres' : 'Filtrer' }}
                        <i id="filterToggleIcon" class="fas fa-chevron-down ml-2 transition-transform"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Zone de filtres avancés (masquée par défaut) -->
        <div id="advancedFilters" class="hidden border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <div class="p-6">
                <form method="GET" action="{{ admin_route('books') }}" id="filterForm">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <!-- Recherche -->
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Titre, auteur, ISBN..."
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                            </div>
                            
                            <!-- Statut -->
                            <select name="status"
                                    class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                                <option value="all">Tous les statuts</option>
                                @if(isset($statuses))
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvés</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetés</option>
                                @endif
                            </select>
                            
                            <!-- Niveau -->
                            <select name="level"
                                    class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                                <option value="all">Tous les niveaux</option>
                                <option value="null" {{ request('level') == 'null' ? 'selected' : '' }}>Sans niveau</option>
                                @if(isset($levels))
                                    @foreach($levels as $level)
                                        <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                            {{ ucfirst($level) }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                            <!-- Catégorie -->
                            <select name="category"
                                    class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                                <option value="all">Toutes les catégories</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                            <!-- Langue -->
                            <select name="language"
                                    class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                                <option value="all">Toutes les langues</option>
                                @if(isset($languages))
                                    @foreach($languages as $language)
                                        <option value="{{ $language }}" {{ request('language') == $language ? 'selected' : '' }}>
                                            @php
                                                $languageNames = [
                                                    'fr' => 'Français',
                                                    'en' => 'Anglais',
                                                    'ar' => 'Arabe',
                                                    'es' => 'Espagnol',
                                                    'de' => 'Allemand',
                                                    'it' => 'Italien',
                                                    'pt' => 'Portugais',
                                                    'nl' => 'Néerlandais',
                                                    'ru' => 'Russe',
                                                    'zh' => 'Chinois',
                                                    'ja' => 'Japonais',
                                                    'ko' => 'Coréen'
                                                ];
                                            @endphp
                                            {{ $languageNames[$language] ?? $language }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            
                            <!-- Année de publication (De) -->
                            <input type="number"
                                   name="year_from"
                                   value="{{ request('year_from') }}"
                                   placeholder="Année de..."
                                   min="1900"
                                   max="{{ date('Y') }}"
                                   class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                            
                            <!-- Année de publication (À) -->
                            <input type="number"
                                   name="year_to"
                                   value="{{ request('year_to') }}"
                                   placeholder="Année à..."
                                   min="1900"
                                   max="{{ date('Y') }}"
                                   class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                            
                            <!-- Tri -->
                            <div class="flex space-x-2">
                                <select name="sort_by"
                                        class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date d'ajout</option>
                                    <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Titre</option>
                                    <option value="author_name" {{ request('sort_by') == 'author_name' ? 'selected' : '' }}>Auteur</option>
                                    <option value="downloads" {{ request('sort_by') == 'downloads' ? 'selected' : '' }}>Téléchargements</option>
                                    <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>Vues</option>
                                </select>
                                <select name="sort_order"
                                        class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 dark:bg-gray-700 dark:text-white text-sm">
                                    <option value="desc" {{ request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>↓</option>
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>↑</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-2 mt-3">
                            <a href="{{ admin_route('books') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                                Réinitialiser
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-search mr-2"></i>
                                Appliquer les filtres
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="p-4">
            @if(session('success'))
                <div class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 compact-table">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Couverture
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Titre
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Auteur
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Publié par
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Catégorie
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Niveau
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Stats
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($books as $book)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-2 py-1">
                                            <div class="flex-shrink-0">
                                                @if($book->cover_image)
                                                    <img src="{{ Storage::url($book->cover_image) }}"
                                                         alt="Couverture de {{ $book->title }}"
                                                         class="w-8 h-12 object-cover rounded shadow-sm border border-gray-200 dark:border-gray-600">
                                                @else
                                                    <div class="w-8 h-12 bg-gray-200 dark:bg-gray-600 rounded flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                                        <i class="fas fa-book text-gray-400 dark:text-gray-500 text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                                                {{ Str::limit($book->title, 30) }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="text-gray-900 dark:text-gray-100 text-sm">{{ Str::limit($book->author_name, 18) }}</div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="text-gray-900 dark:text-gray-100 text-sm">{{ Str::limit($book->uploader->name, 12) }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($book->uploader->email, 18) }}</div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ Str::limit($book->category, 10) }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-1">
                                            @if($book->level)
                                                @php
                                                    $levelConfig = [
                                                        'primaire' => ['icon' => 'fa-child', 'color' => 'green'],
                                                        'college' => ['icon' => 'fa-school', 'color' => 'blue'],
                                                        'lycee' => ['icon' => 'fa-graduation-cap', 'color' => 'purple'],
                                                        'superieur' => ['icon' => 'fa-university', 'color' => 'indigo'],
                                                        'professionnel' => ['icon' => 'fa-briefcase', 'color' => 'gray']
                                                    ];
                                                    $config = $levelConfig[$book->level] ?? ['icon' => 'fa-book', 'color' => 'gray'];
                                                @endphp
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 dark:bg-{{ $config['color'] }}-900 dark:text-{{ $config['color'] }}-200">
                                                    <i class="fas {{ $config['icon'] }} mr-1" style="font-size: 10px;"></i>
                                                    {{ ucfirst($book->level) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-1">
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $book->status_badge_class }} dark:bg-opacity-20">
                                                {{ $book->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-2 py-1 text-xs text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center space-x-2">
                                                <span class="flex items-center">
                                                    <i class="fas fa-eye w-3 h-3 mr-1"></i>
                                                    {{ $book->views ?? 0 }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fas fa-download w-3 h-3 mr-1"></i>
                                                    {{ $book->downloads ?? 0 }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-2 py-1">
                                            <div class="flex items-center space-x-2">
                                                <!-- Status Selector -->
                                                @include('admin.components.simple-status-selector', ['book' => $book])

                                                <!-- Quick Actions -->
                                                <div class="flex items-center space-x-1">
                                                    <a href="{{ admin_route('books.show', $book) }}"
                                                       class="action-btn text-gray-600 hover:text-blue-600 hover:bg-blue-50"
                                                       title="Voir">
                                                        <i class="fas fa-eye text-xs"></i>
                                                    </a>
                                                    <a href="{{ admin_route('books.edit', $book) }}"
                                                       class="action-btn text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50"
                                                       title="Éditer">
                                                        <i class="fas fa-edit text-xs"></i>
                                                    </a>
                                                    <a href="{{ admin_route('books.status-history', $book) }}"
                                                       class="action-btn text-teal-600 hover:text-purple-700 hover:bg-purple-50"
                                                       title="Historique">
                                                        <i class="fas fa-history text-xs"></i>
                                                    </a>
                                                    <!-- Bouton Supprimer -->
                                                    <button type="button"
                                                            onclick="showDeleteConfirmation('{{ $book->title }}', '{{ $book->author_name }}', '{{ admin_route('books.delete', $book) }}')"
                                                            class="action-btn text-red-600 hover:text-red-700 hover:bg-red-50 border-0 bg-transparent cursor-pointer"
                                                            title="Supprimer définitivement">
                                                        <i class="fas fa-trash text-xs"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

        </div>

        <!-- Pagination -->
        <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Affichage de {{ $books->firstItem() }} à {{ $books->lastItem() }} sur {{ $books->total() }} résultats
                </div>
                <div class="flex items-center space-x-2">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour basculer l'affichage des filtres
        function toggleFilters() {
            const filtersDiv = document.getElementById('advancedFilters');
            const toggleIcon = document.getElementById('filterToggleIcon');
            
            if (filtersDiv.classList.contains('hidden')) {
                filtersDiv.classList.remove('hidden');
                toggleIcon.classList.add('rotate-180');
            } else {
                filtersDiv.classList.add('hidden');
                toggleIcon.classList.remove('rotate-180');
            }
        }
        
        // Ouvrir automatiquement les filtres si des filtres sont actifs
        document.addEventListener('DOMContentLoaded', function() {
            const hasActiveFilters = {{ request()->hasAny(['search', 'status', 'level', 'category', 'language', 'year_from', 'year_to']) ? 'true' : 'false' }};
            if (hasActiveFilters) {
                const filtersDiv = document.getElementById('advancedFilters');
                const toggleIcon = document.getElementById('filterToggleIcon');
                if (filtersDiv) {
                    filtersDiv.classList.remove('hidden');
                    toggleIcon.classList.add('rotate-180');
                }
            }
        });
    </script>
@endsection

@push('scripts')
<script>
// Variables pour la gestion des modales
let deleteUrl = '';

// Fonction pour afficher la modal de confirmation de suppression
function showDeleteConfirmation(bookTitle, bookAuthor, url) {
    deleteUrl = url;

    // Mettre à jour les informations du livre dans la modal
    document.getElementById('deleteBookTitle').textContent = bookTitle;
    document.getElementById('deleteBookAuthor').textContent = `Par ${bookAuthor}`;

    // Afficher la modal avec animation
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Animation d'entrée
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Fonction pour masquer la modal de suppression
function hideDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');

    if (!modal || modal.classList.contains('hidden')) return;

    // Animation de sortie
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        deleteUrl = '';
    }, 300);
}

// Fonction pour confirmer la suppression
function confirmDelete() {
    if (deleteUrl) {
        // Afficher une notification de traitement
        if (typeof window.showNotification === 'function') {
            window.showNotification('🔄 Suppression en cours...', 'info', 2000);
        }

        // Créer et soumettre le formulaire
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        // Ajouter le token CSRF
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Ajouter la méthode DELETE
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        // Soumettre le formulaire
        document.body.appendChild(form);
        form.submit();
    }
}

// Fermer les modales avec Escape et clic à l'extérieur
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteModal();
        hideApprovalModal();
    }
});

// Fermer la modal de suppression si on clique à l'extérieur
document.addEventListener('click', function(e) {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal && e.target === deleteModal) {
        hideDeleteModal();
    }
});

// Variables pour la modale d'approbation
let currentApprovalBookId = null;
let currentApprovalBookTitle = '';

function showApprovalModal(bookId, bookTitle) {
    currentApprovalBookId = bookId;
    currentApprovalBookTitle = bookTitle;

    const modal = document.getElementById('approvalModal');
    const content = document.getElementById('approvalModalContent');
    const titleElement = document.getElementById('approvalBookTitle');

    titleElement.textContent = bookTitle;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    // Animation d'entrée
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function hideApprovalModal() {
    const modal = document.getElementById('approvalModal');
    const content = document.getElementById('approvalModalContent');

    if (!modal || modal.classList.contains('hidden')) return;

    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        currentApprovalBookId = null;
        currentApprovalBookTitle = '';
    }, 300);
}

function confirmApproval() {
    if (currentApprovalBookId) {
        // Créer et soumettre le formulaire
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/books/${currentApprovalBookId}/approve`;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<!-- Modal de confirmation de suppression compacte -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
    <div class="relative top-20 mx-auto p-4 w-full max-w-md">
        <!-- Contenu de la modale -->
        <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
            <!-- En-tête avec icône -->
            <div class="flex flex-col items-center pt-6 pb-4 px-6">
                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mb-3 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-1">
                    ⚠️ Suppression définitive
                </h3>
                <p class="text-sm text-gray-600 text-center">
                    Cette action est <strong class="text-red-600">irréversible</strong> et supprimera définitivement :
                </p>
            </div>

            <!-- Informations du livre -->
            <div class="px-6 pb-4">
                <div class="bg-gray-50 rounded-lg p-3 mb-3 border-l-4 border-red-500">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm" id="deleteBookTitle">Titre du livre</h4>
                            <p class="text-xs text-gray-600" id="deleteBookAuthor">Auteur</p>
                        </div>
                    </div>
                </div>

                <!-- Liste compacte des éléments supprimés -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                    <h5 class="font-medium text-red-800 text-sm mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Éléments qui seront supprimés :
                    </h5>
                    <ul class="text-xs text-red-700 space-y-1">
                        <li>• Le livre et toutes ses métadonnées</li>
                        <li>• L'image de couverture</li>
                        <li>• Le fichier PDF</li>
                        <li>• Toutes les statistiques de téléchargement</li>
                    </ul>
                </div>

                <!-- Boutons d'action compacts -->
                <div class="flex gap-2">
                    <button type="button"
                            onclick="hideDeleteModal()"
                            class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300 text-sm">
                        ✕ Annuler
                    </button>
                    <button type="button"
                            onclick="confirmDelete()"
                            class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 shadow-lg hover:shadow-xl text-sm">
                        🗑️ Supprimer définitivement
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modale d'approbation moderne -->
<div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
    <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md">
        <!-- Contenu de la modale -->
        <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="approvalModalContent">
            <!-- En-tête avec icône -->
            <div class="flex flex-col items-center pt-8 pb-6 px-6">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 text-center mb-2">
                    Approuver ce livre ?
                </h3>
                <p class="text-sm text-gray-600 text-center leading-relaxed mb-2">
                    <strong id="approvalBookTitle"></strong>
                </p>
                <p class="text-xs text-gray-500 text-center leading-relaxed">
                    Cette action rendra le livre visible à tous les utilisateurs.
                </p>
            </div>

            <!-- Boutons d'action -->
            <div class="flex gap-3 px-6 pb-6">
                <button type="button"
                        onclick="hideApprovalModal()"
                        class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Annuler
                </button>
                <button type="button"
                        onclick="confirmApproval()"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

@endpush