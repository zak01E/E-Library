@extends(auth()->check() && auth()->user()->role === 'admin' ? 'layouts.admin-dashboard' : 'layouts.author-dashboard')

@section('page-title', $book->title)
@section('page-description', 'Détails du livre par ' . $book->author_name)

@section('content')
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? admin_route('books') : route('author.books') }}"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Retour à {{ auth()->check() && auth()->user()->role === 'admin' ? 'la liste admin' : 'mes livres' }}
                        </a>
                    </div>

                    <!-- Header Section -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $book->title }}</h1>

                        <div class="mb-6">
                            <p class="text-lg text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">Auteur:</span> {{ $book->author_name }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Publié le {{ $book->created_at->format('d F Y') }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mb-6" x-data="{ showReader: false }">
                            <button @click="showReader = !showReader"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span x-text="showReader ? 'Masquer le lecteur' : 'Lire en ligne'"></span>
                            </button>

                            <a href="{{ route('books.download', $book) }}"
                               class="ml-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                </svg>
                                Télécharger PDF
                            </a>

                            <div x-show="showReader" x-transition class="mt-6">
                                <iframe src="{{ asset('storage/' . $book->pdf_path) }}"
                                        class="w-full h-96 lg:h-[600px] border-2 border-gray-300 rounded-lg"
                                        title="Lecteur PDF">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid: Cover, Description, and Information side by side -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Book Cover -->
                        <div class="lg:col-span-3 order-2 lg:order-1">
                            <div class="sticky top-6">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                                         alt="Couverture de {{ $book->title }}"
                                         class="w-full max-w-64 mx-auto lg:max-w-full rounded-xl shadow-lg">
                                @else
                                    <div class="w-full max-w-64 mx-auto lg:max-w-full aspect-[3/4] bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl shadow-lg flex items-center justify-center">
                                        <div class="text-center text-white p-4">
                                            <i class="fas fa-book text-3xl mb-3"></i>
                                            <h3 class="text-sm font-semibold mb-1">{{ Str::limit($book->title, 20) }}</h3>
                                            <p class="text-xs opacity-90">{{ Str::limit($book->author_name, 15) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Description and Information side by side -->
                        <div class="lg:col-span-9 order-1 lg:order-2">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Description -->
                                <div class="lg:col-span-1">
                                    @if($book->description)
                                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 h-full">
                                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                                <i class="fas fa-align-left text-blue-500 mr-3"></i>
                                                Description
                                            </h2>
                                            <div class="prose prose-gray dark:prose-invert max-w-none">
                                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-base">{{ $book->description }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Book Information -->
                                <div class="lg:col-span-1">
                                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 h-full">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                            <i class="fas fa-info-circle text-green-500 mr-3"></i>
                                            Informations
                                        </h3>

                                        <div class="space-y-5">
                                            <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Statut</span>
                                                <span class="font-semibold">
                                                    @if($book->is_approved)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                            <i class="fas fa-check-circle mr-1"></i>
                                                            Approuvé
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            En attente
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléchargé par</span>
                                                <span class="font-semibold text-gray-900 dark:text-white">{{ $book->uploader->name }}</span>
                                            </div>

                                            @if($book->pages)
                                                <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre de pages</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $book->pages }} pages</span>
                                                </div>
                                            @endif

                                            @if($book->category)
                                                <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Catégorie</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $book->category }}</span>
                                                </div>
                                            @endif

                                            @if($book->language)
                                                <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Langue</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">
                                                        @switch($book->language)
                                                            @case('fr') Français @break
                                                            @case('en') English @break
                                                            @case('ar') العربية @break
                                                            @default {{ $book->language }}
                                                        @endswitch
                                                    </span>
                                                </div>
                                            @endif

                                            @if($book->publication_year)
                                                <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Année de publication</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $book->publication_year }}</span>
                                                </div>
                                            @endif

                                            @if($book->isbn)
                                                <div class="flex justify-between items-start py-2 border-b border-gray-100 dark:border-gray-700">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ISBN</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $book->isbn }}</span>
                                                </div>
                                            @endif

                                            @if($book->publisher)
                                                <div class="flex justify-between items-start py-2">
                                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Éditeur</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $book->publisher }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if(auth()->check() && auth()->user()->role === 'admin' && !$book->is_approved)
                                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600">
                                                <button type="button"
                                                        onclick="showApprovalModal()"
                                                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Approuver ce livre
                                                </button>
                                            </div>
                                        @endif

                                        @if(auth()->check() && (auth()->id() === $book->uploaded_by || auth()->user()->role === 'admin'))
                                            <div class="mt-4">
                                                <form action="{{ auth()->check() && auth()->user()->role === 'admin' ? admin_route('books.delete', $book) : route('author.books.delete', $book) }}" method="POST"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                                        <i class="fas fa-trash mr-2"></i>
                                                        Supprimer ce livre
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    <!-- Modale d'approbation moderne -->
    @if(auth()->user()->role === 'admin' && !$book->is_approved)
    <div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
        <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md">
            <!-- Contenu de la modale -->
            <div class="relative bg-white rounded-2xl shadow-2xl transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
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
                    <p class="text-sm text-gray-600 text-center leading-relaxed">
                        Cette action rendra le livre visible à tous les utilisateurs de la bibliothèque.
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

    <!-- Formulaire caché pour l'approbation -->
    <form id="approvalForm" action="{{ admin_route('books.approve', $book) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>
    @endif

    <script>
        function showApprovalModal() {
            const modal = document.getElementById('approvalModal');
            const content = document.getElementById('modalContent');

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
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function confirmApproval() {
            document.getElementById('approvalForm').submit();
        }

        // Fermer la modale en cliquant à l'extérieur
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('approvalModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideApprovalModal();
                    }
                });
            }

            // Fermer avec la touche Échap
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    hideApprovalModal();
                }
            });
        });
    </script>
@endsection
