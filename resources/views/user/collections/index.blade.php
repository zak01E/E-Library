<x-user-dashboard>
    <div class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Mes collections</h1>
                    <p class="text-gray-600">Organisez vos livres en collections thématiques</p>
                </div>
                <a href="{{ route('user.collections.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Nouvelle collection
                </a>
            </div>

            <!-- Collection Types Tabs -->
            <div class="flex space-x-1 mb-6 border-b border-gray-200">
                <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                    Mes collections ({{ $my_collections_count ?? 8 }})
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    Partagées avec moi ({{ $shared_collections_count ?? 3 }})
                </button>
                <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    Publiques ({{ $public_collections_count ?? 15 }})
                </button>
            </div>

            <!-- Collections Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($collections ?? [] as $collection)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <!-- Collection Cover -->
                        <div class="relative h-48 bg-gradient-to-br {{ $collection->color ?? 'from-blue-400 to-blue-600' }} p-6">
                            <div class="absolute top-4 right-4">
                                <button class="w-8 h-8 bg-white/20 backdrop-blur rounded-full flex items-center justify-center text-white hover:bg-white/30">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                            <div class="h-full flex flex-col justify-end">
                                <i class="fas {{ $collection->icon ?? 'fa-folder-open' }} text-4xl text-white/80 mb-2"></i>
                                <h3 class="text-xl font-semibold text-white">{{ $collection->name }}</h3>
                            </div>
                        </div>

                        <!-- Collection Info -->
                        <div class="p-4">
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $collection->description ?? 'Une collection de livres soigneusement sélectionnés' }}</p>
                            
                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span><i class="fas fa-book mr-1"></i> {{ $collection->books_count ?? rand(5, 25) }} livres</span>
                                <span><i class="fas fa-clock mr-1"></i> Mis à jour {{ $collection->updated_at ?? 'il y a 2j' }}</span>
                            </div>

                            <!-- Book Previews -->
                            <div class="flex -space-x-3 mb-4">
                                @for($i = 0; $i < min(4, $collection->books_count ?? 5); $i++)
                                    <div class="w-10 h-14 bg-gray-300 rounded border-2 border-white shadow-sm"></div>
                                @endfor
                                @if(($collection->books_count ?? 5) > 4)
                                    <div class="w-10 h-14 bg-gray-100 rounded border-2 border-white shadow-sm flex items-center justify-center">
                                        <span class="text-xs text-gray-600 font-medium">+{{ ($collection->books_count ?? 5) - 4 }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @if($collection->is_public ?? false)
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                            <i class="fas fa-globe mr-1"></i> Public
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            <i class="fas fa-lock mr-1"></i> Privé
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('user.collections.show', $collection) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Voir la collection →
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune collection créée</h3>
                            <p class="text-gray-600 mb-6">Créez votre première collection pour organiser vos livres</p>
                            <a href="{{ route('user.collections.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Créer une collection
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Quick Create Templates -->
            <div class="mt-12">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Créer rapidement</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button class="p-4 bg-white rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                        <i class="fas fa-heart text-2xl text-gray-400 group-hover:text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Mes coups de cœur</p>
                    </button>
                    <button class="p-4 bg-white rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                        <i class="fas fa-graduation-cap text-2xl text-gray-400 group-hover:text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-blue-600">À lire pour études</p>
                    </button>
                    <button class="p-4 bg-white rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                        <i class="fas fa-gift text-2xl text-gray-400 group-hover:text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Liste de souhaits</p>
                    </button>
                    <button class="p-4 bg-white rounded-lg border-2 border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-colors group">
                        <i class="fas fa-briefcase text-2xl text-gray-400 group-hover:text-blue-600 mb-2"></i>
                        <p class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Développement pro</p>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-user-dashboard>