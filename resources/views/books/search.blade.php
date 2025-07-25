@extends(auth()->user()->role === 'admin' ? 'layouts.admin-dashboard' : 'layouts.author-dashboard')

@section('page-title', 'Recherche de Livres')
@section('page-description', 'Trouvez les livres qui vous intéressent')

@section('content')
    <div class="space-y-6">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('books.search') }}" class="space-y-4">
                        <!-- Search Bar -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Search by title, author, ISBN, publisher..."
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Filters Row -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Category Filter -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Language Filter -->
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                                <select name="language" id="language" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">All Languages</option>
                                    @foreach($languages as $lang)
                                        <option value="{{ $lang }}" {{ request('language') == $lang ? 'selected' : '' }}>
                                            @if($lang == 'fr') Français
                                            @elseif($lang == 'en') English
                                            @elseif($lang == 'ar') العربية
                                            @else {{ $lang }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Year From -->
                            <div>
                                <label for="year_from" class="block text-sm font-medium text-gray-700">Year From</label>
                                <input type="number" name="year_from" id="year_from" value="{{ request('year_from') }}" 
                                       min="1800" max="{{ date('Y') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>

                            <!-- Year To -->
                            <div>
                                <label for="year_to" class="block text-sm font-medium text-gray-700">Year To</label>
                                <input type="number" name="year_to" id="year_to" value="{{ request('year_to') }}" 
                                       min="1800" max="{{ date('Y') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Sort Options -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                                <select name="sort_by" id="sort_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Added</option>
                                    <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                                    <option value="author_name" {{ request('sort_by') == 'author_name' ? 'selected' : '' }}>Author</option>
                                    <option value="publication_year" {{ request('sort_by') == 'publication_year' ? 'selected' : '' }}>Publication Year</option>
                                    <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>Most Viewed</option>
                                    <option value="downloads" {{ request('sort_by') == 'downloads' ? 'selected' : '' }}>Most Downloaded</option>
                                </select>
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700">Order</label>
                                <select name="sort_order" id="sort_order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center space-x-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Search
                            </button>
                            <a href="{{ route('books.search') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <p class="text-gray-700">Found {{ $books->total() }} books</p>
                    </div>

                    @if($books->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($books as $book)
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 group h-96 flex flex-col">
                                    <div class="relative h-56 flex-shrink-0">
                                        @if($book->cover_image)
                                            <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center group-hover:from-indigo-600 group-hover:to-indigo-700 transition-all duration-300">
                                                <div class="text-white text-center p-3 max-w-full">
                                                    <i class="fas fa-book text-2xl mb-2"></i>
                                                    <div class="font-bold text-xs leading-tight break-words line-clamp-3">{{ Str::limit($book->title, 30) }}</div>
                                                </div>
                                            </div>
                                        @endif
                                        <!-- Stats Badge -->
                                        <div class="absolute top-2 right-2 bg-indigo-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            <i class="fas fa-eye mr-1"></i>{{ number_format($book->views) }}
                                        </div>
                                    </div>
                                    <div class="p-4 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="font-heading font-bold text-gray-900 mb-2 text-sm group-hover:text-indigo-600 transition-colors line-clamp-2">
                                                <a href="{{ route('books.show', $book) }}">
                                                    {{ $book->title }}
                                                </a>
                                            </h3>
                                            <p class="text-gray-600 text-xs mb-2">Par {{ $book->author_name }}</p>
                                            @if($book->category)
                                                <span class="inline-block bg-gray-100 rounded-full px-2 py-1 text-xs font-semibold text-gray-700 mb-2">
                                                    {{ $book->category }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mt-auto">
                                            <div class="flex justify-between items-center text-xs text-gray-500 mb-2">
                                                <span><i class="fas fa-eye mr-1"></i>{{ $book->views }}</span>
                                                <span><i class="fas fa-download mr-1"></i>{{ $book->downloads }}</span>
                                            </div>
                                            @if(!$book->is_approved && auth()->user()->role === 'admin')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    En attente
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $books->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No books found matching your criteria.</p>
                    @endif
            </div>
        </div>
    </div>
@endsection