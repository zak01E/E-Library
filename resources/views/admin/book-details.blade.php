@extends('layouts.admin-dashboard')

@section('page-title', $book->title)
@section('page-description', 'Détails complets du livre')


@section('content')
    @php
        // Déterminer le chemin du PDF une fois pour toute la vue
        $pdfPath = null;
        if($book->pdf_path) {
            $pdfPath = $book->pdf_path;
            if (!Storage::disk('public')->exists($pdfPath)) {
                // Essayer avec le dossier pdfs
                $filename = basename($pdfPath);
                if (Storage::disk('public')->exists('books/pdfs/' . $filename)) {
                    $pdfPath = 'books/pdfs/' . $filename;
                }
            }
            // Vérifier que le fichier existe vraiment
            if (!Storage::disk('public')->exists($pdfPath)) {
                $pdfPath = null;
            }
        }
    @endphp

    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ admin_route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ admin_route('books') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            Livres
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ Str::limit($book->title, 30) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Header avec statut et actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $book->title }}</h1>
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Statut -->
                    @php
                        $statusColors = [
                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            'suspended' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                            'under_review' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
                        ];
                        $statusIcons = [
                            'approved' => 'fa-check-circle',
                            'pending' => 'fa-clock',
                            'rejected' => 'fa-times-circle',
                            'suspended' => 'fa-pause-circle',
                            'under_review' => 'fa-search'
                        ];
                        $statusLabels = [
                            'approved' => 'Approuvé',
                            'pending' => 'En attente',
                            'rejected' => 'Rejeté',
                            'suspended' => 'Suspendu',
                            'under_review' => 'En révision'
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$book->status ?? 'pending'] }}">
                        <i class="fas {{ $statusIcons[$book->status ?? 'pending'] }} mr-2"></i>
                        {{ $statusLabels[$book->status ?? 'pending'] }}
                    </span>
                    
                    <!-- Niveau éducatif -->
                    @if($book->level)
                        @php
                            $levelColors = [
                                'primaire' => 'bg-blue-100 text-blue-800',
                                'college' => 'bg-indigo-100 text-indigo-800',
                                'lycee' => 'bg-purple-100 text-purple-800',
                                'superieur' => 'bg-pink-100 text-pink-800',
                                'professionnel' => 'bg-orange-100 text-orange-800'
                            ];
                            $levelIcons = [
                                'primaire' => 'fa-child',
                                'college' => 'fa-user-graduate',
                                'lycee' => 'fa-graduation-cap',
                                'superieur' => 'fa-university',
                                'professionnel' => 'fa-briefcase'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $levelColors[$book->level] ?? 'bg-gray-100 text-gray-800' }}">
                            <i class="fas {{ $levelIcons[$book->level] ?? 'fa-book' }} mr-2"></i>
                            {{ ucfirst($book->level) }}
                        </span>
                    @endif
                    
                    <!-- Langue -->
                    @if($book->language)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                            <i class="fas fa-language mr-2"></i>
                            @switch($book->language)
                                @case('fr') Français @break
                                @case('en') Anglais @break
                                @case('ar') Arabe @break
                                @case('es') Espagnol @break
                                @default {{ strtoupper($book->language) }}
                            @endswitch
                        </span>
                    @endif
                    
                    <!-- Featured -->
                    @if($book->is_featured ?? false)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-star mr-2"></i>
                            En vedette
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ admin_route('books.edit', $book) }}" 
                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Modifier
                </a>
                
                @if($pdfPath)
                    <button onclick="togglePdfReader()"
                            id="toggleReaderBtn"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-book-open mr-2"></i>
                        <span id="readerBtnText">Lire ici</span>
                    </button>
                    
                    <a href="{{ asset('storage/' . $pdfPath) }}" 
                       target="_blank"
                       class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center">
                        <i class="fas fa-external-link-alt mr-2"></i>
                        Ouvrir PDF
                    </a>
                @else
                    <button disabled
                            class="px-4 py-2 bg-gray-400 cursor-not-allowed text-white rounded-lg text-sm font-medium inline-flex items-center opacity-50">
                        <i class="fas fa-eye-slash mr-2"></i>
                        PDF non disponible
                    </button>
                @endif
                
                <button onclick="openDeleteModal()" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center">
                    <i class="fas fa-trash mr-2"></i>
                    Supprimer
                </button>
            </div>
        </div>
    </div>
    
    <!-- Lecteur PDF intégré -->
    @if($pdfPath)
        <div id="pdfReaderContainer" style="display: none;" class="mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex justify-between items-center mb-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-book-reader mr-2 text-green-600"></i>
                        Lecteur PDF intégré
                    </h3>
                    <button onclick="closePdfReader()" 
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <iframe src="{{ asset('storage/' . $pdfPath) }}"
                        class="w-full h-[10000px] border-2 border-gray-300 dark:border-gray-600 rounded-lg"
                        title="Lecteur PDF">
                </iframe>
            </div>
        </div>
    @endif

    <!-- Contenu principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne gauche - Couverture et infos de base -->
        <div class="lg:col-span-1">
            <!-- Couverture -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}"
                         alt="Couverture de {{ $book->title }}"
                         class="w-full rounded-lg shadow-lg mb-4">
                @else
                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg shadow-lg flex items-center justify-center mb-4">
                        <div class="text-center text-white p-4">
                            <i class="fas fa-book text-6xl mb-3 opacity-50"></i>
                            <p class="text-sm font-medium">Pas de couverture</p>
                        </div>
                    </div>
                @endif
                
                <!-- Boutons d'action pour le statut -->
                <div class="space-y-2">
                    @if($book->status !== 'approved')
                        <form action="{{ admin_route('books.approve', $book) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-check mr-2"></i>
                                Approuver
                            </button>
                        </form>
                    @endif
                    
                    @if($book->status !== 'rejected')
                        <form action="{{ admin_route('books.reject', $book) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Rejeter
                            </button>
                        </form>
                    @endif
                    
                    @if($book->status !== 'suspended')
                        <form action="{{ admin_route('books.suspend', $book) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-pause mr-2"></i>
                                Suspendre
                            </button>
                        </form>
                    @endif
                    
                    @if($book->status !== 'under_review')
                        <form action="{{ admin_route('books.review', $book) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-search mr-2"></i>
                                Mettre en révision
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            <!-- Statistiques -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                    Statistiques
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Téléchargements</span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $book->downloads ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Vues</span>
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">{{ $book->views ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Note moyenne</span>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-{{ ($book->average_rating ?? 0) >= $i ? 'yellow' : 'gray' }}-400"></i>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $book->ratings_count ?? 0 }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Colonne centrale et droite - Informations détaillées -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations générales -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informations générales
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Auteur</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $book->author_name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Catégorie</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $book->category ?? 'Non catégorisé' }}</p>
                    </div>
                    
                    @if($book->isbn)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">ISBN</label>
                        <p class="text-gray-900 dark:text-white font-medium font-mono">{{ $book->isbn }}</p>
                    </div>
                    @endif
                    
                    @if($book->publisher)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Éditeur</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $book->publisher }}</p>
                    </div>
                    @endif
                    
                    @if($book->publication_year)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Année de publication</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $book->publication_year }}</p>
                    </div>
                    @endif
                    
                    @if($book->pages)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nombre de pages</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $book->pages }} pages</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Téléchargé par</label>
                        <a href="{{ admin_route('users.show', $book->uploader) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            {{ $book->uploader->name }}
                        </a>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Date d'ajout</label>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $book->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            @if($book->description)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-align-left mr-2 text-blue-600"></i>
                    Description
                </h3>
                <div class="prose prose-gray dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $book->description }}</p>
                </div>
            </div>
            @endif
            
            <!-- Métadonnées techniques -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-cog mr-2 text-blue-600"></i>
                    Informations techniques
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">ID du livre</label>
                        <p class="text-gray-900 dark:text-white font-mono">#{{ $book->id }}</p>
                    </div>
                    
                    @if($book->pdf_path)
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Fichier PDF</label>
                        <p class="text-gray-900 dark:text-white font-mono text-sm truncate">{{ basename($book->pdf_path) }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Dernière modification</label>
                        <p class="text-gray-900 dark:text-white">{{ $book->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Taille du fichier</label>
                        <p class="text-gray-900 dark:text-white">
                            @if($book->pdf_path && Storage::disk('public')->exists($book->pdf_path))
                                {{ number_format(Storage::disk('public')->size($book->pdf_path) / 1048576, 2) }} MB
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Historique des statuts -->
            @if($book->status_history ?? false)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-history mr-2 text-blue-600"></i>
                    Historique des statuts
                </h3>
                <div class="space-y-3">
                    @foreach($book->status_history as $history)
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <i class="fas fa-circle text-xs text-gray-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                Changé en <span class="font-semibold">{{ $history->status }}</span>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Par {{ $history->user->name }} le {{ $history->created_at->format('d/m/Y à H:i') }}
                            </p>
                            @if($history->reason)
                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $history->reason }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Modal de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Confirmer la suppression</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Cette action est irréversible</p>
                    </div>
                </div>
                
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Êtes-vous sûr de vouloir supprimer le livre "<strong>{{ $book->title }}</strong>" ? 
                    Cette action supprimera également le fichier PDF et la couverture associés.
                </p>
                
                <div class="flex justify-end space-x-3">
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium transition-colors">
                        Annuler
                    </button>
                    <form action="{{ admin_route('books.delete', $book) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonctions pour le lecteur PDF
        function togglePdfReader() {
            const readerContainer = document.getElementById('pdfReaderContainer');
            const btnText = document.getElementById('readerBtnText');
            
            if (readerContainer) {
                if (readerContainer.style.display === 'none' || readerContainer.style.display === '') {
                    readerContainer.style.display = 'block';
                    if (btnText) btnText.textContent = 'Fermer lecteur';
                } else {
                    readerContainer.style.display = 'none';
                    if (btnText) btnText.textContent = 'Lire ici';
                }
            }
        }
        
        function closePdfReader() {
            const readerContainer = document.getElementById('pdfReaderContainer');
            const btnText = document.getElementById('readerBtnText');
            
            if (readerContainer) {
                readerContainer.style.display = 'none';
                if (btnText) btnText.textContent = 'Lire ici';
            }
        }
        
        // Fonctions pour le modal de suppression
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Fermer en cliquant à l'extérieur
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
@endsection

