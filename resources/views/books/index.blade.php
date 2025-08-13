@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin-dashboard' : 'layouts.author-dashboard')

@section('content')
    <div class="space-y-6">
            @if(auth()->check() && auth()->user()->role === 'author')
                <div class="mb-6">
                    <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ajouter un livre
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('books.show', $book) }}" class="block">
                            <!-- Cover Image -->
                            @if($book->cover_image)
                                <img src="{{ asset('storage/' . $book->cover_image) }}"
                                     alt="{{ $book->title }}"
                                     class="w-full aspect-[6/7] object-cover">
                            @else
                                <div class="w-full aspect-[6/7] bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center">
                                    <i class="fas fa-book text-white text-2xl"></i>
                                </div>
                            @endif

                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $book->title }}</h3>
                                <p class="text-gray-600 text-sm mb-2">Par {{ $book->author_name }}</p>
                                
                                @if($book->description)
                                    <p class="text-gray-500 text-sm line-clamp-3 mb-3">{{ $book->description }}</p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">{{ $book->created_at->format('d/m/Y') }}</span>
                                    
                                    @if(auth()->check() && auth()->user()->role === 'admin' && !$book->is_approved)
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            En attente
                                        </span>
                                    @elseif($book->is_approved)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            Approuvé
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>

                        @if(auth()->check() && auth()->user()->role === 'admin' && !$book->is_approved)
                            <div class="border-t px-4 py-3 bg-gray-50">
                                <form action="{{ route('books.approve', $book) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                        Approuver
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Aucun livre disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    </div>
@endsection