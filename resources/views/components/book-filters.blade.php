@props([
    'action' => '',
    'categories' => collect(),
    'languages' => collect(),
    'authors' => collect(),
    'showAuthors' => true,
    'showSort' => true,
    'showSearch' => true,
])

<div class="bg-gray-50 rounded-xl p-4 mb-8">
    <form method="GET" action="{{ $action }}" class="flex flex-wrap items-center justify-center gap-4">
        <div class="flex items-center gap-2">
            <i class="fas fa-filter text-gray-500 text-sm"></i>
            <span class="text-gray-700 font-medium text-sm">Filtres:</span>
        </div>

        @if($showSearch)
        <!-- Search -->
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Rechercher..."
               class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-48">
        @endif

        <!-- Category Filter -->
        <select name="category" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="all" {{ request('category', 'all') === 'all' ? 'selected' : '' }}>📚 Toutes catégories</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                    @switch($category)
                        @case('Fiction')
                            📖 {{ $category }}
                            @break
                        @case('Science')
                            🔬 {{ $category }}
                            @break
                        @case('Technologie')
                            💻 {{ $category }}
                            @break
                        @case('Histoire')
                            🏛️ {{ $category }}
                            @break
                        @case('Biographie')
                            👤 {{ $category }}
                            @break
                        @default
                            📚 {{ $category }}
                    @endswitch
                </option>
            @endforeach
        </select>

        <!-- Language Filter -->
        <select name="language" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="all" {{ request('language', 'all') === 'all' ? 'selected' : '' }}>🌍 Toutes langues</option>
            @foreach($languages as $language)
                <option value="{{ $language }}" {{ request('language') === $language ? 'selected' : '' }}>
                    @switch($language)
                        @case('Français')
                            🇫🇷 {{ $language }}
                            @break
                        @case('Anglais')
                            🇬🇧 {{ $language }}
                            @break
                        @case('Espagnol')
                            🇪🇸 {{ $language }}
                            @break
                        @default
                            🌍 {{ $language }}
                    @endswitch
                </option>
            @endforeach
        </select>

        @if($showAuthors && $authors->isNotEmpty())
        <!-- Author Filter -->
        <select name="author" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="all" {{ request('author', 'all') === 'all' ? 'selected' : '' }}>👤 Tous les auteurs</option>
            @foreach($authors as $author)
                <option value="{{ $author }}" {{ request('author') === $author ? 'selected' : '' }}>{{ $author }}</option>
            @endforeach
        </select>
        @endif

        @if($showSort)
        <!-- Sort Filter -->
        <select name="sort" class="bg-white border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
            <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>⏰ Plus récents</option>
            <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>🔥 Plus populaires</option>
            <option value="downloads" {{ request('sort') === 'downloads' ? 'selected' : '' }}>📥 Plus téléchargés</option>
            <option value="alphabetical" {{ request('sort') === 'alphabetical' ? 'selected' : '' }}>🔤 Alphabétique</option>
        </select>
        @endif

        <!-- Submit Button -->
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
            <i class="fas fa-search mr-1"></i>Filtrer
        </button>

        <!-- Clear Filters Button -->
        @if(request()->hasAny(['search', 'category', 'language', 'author', 'sort']) && 
            (request('search') || request('category') !== 'all' || request('language') !== 'all' || request('author') !== 'all' || request('sort') !== 'latest'))
            <a href="{{ $action }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm transition-colors">
                <i class="fas fa-times mr-1"></i>Effacer
            </a>
        @endif
    </form>
</div>
