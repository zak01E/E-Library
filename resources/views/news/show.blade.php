@extends('layouts.app')

@section('title', $news->title ?? 'Article')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    
    <!-- Article Header -->
    <article>
        <header class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white py-24">
            <div class="absolute inset-0 bg-black opacity-30"></div>
            
            @if(isset($news->image_path) && $news->image_path)
            <img src="{{ asset('storage/' . $news->image_path) }}" 
                 alt="{{ $news->title }}"
                 class="absolute inset-0 w-full h-full object-cover opacity-30">
            @endif
            
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Category & Priority -->
                <div class="flex items-center gap-3 mb-6">
                    <span class="px-4 py-2 bg-white/20 backdrop-blur border border-white/30 rounded-full text-sm font-semibold">
                        <i class="{{ $news->icon ?? 'fas fa-tag' }} mr-2"></i>
                        {{ $news->category_label ?? $news->category }}
                    </span>
                    
                    @if($news->priority === 'urgent')
                    <span class="px-4 py-2 bg-red-600 rounded-full text-sm font-bold animate-pulse">
                        <i class="fas fa-exclamation-triangle mr-2"></i>URGENT
                    </span>
                    @elseif($news->priority === 'high')
                    <span class="px-4 py-2 bg-orange-600 rounded-full text-sm font-bold">
                        <i class="fas fa-flag mr-2"></i>IMPORTANT
                    </span>
                    @endif
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-bold mb-6">
                    {{ $news->title }}
                </h1>
                
                <!-- Meta Information -->
                <div class="flex flex-wrap items-center gap-6 text-white/90">
                    <div class="flex items-center">
                        <i class="fas fa-user-circle mr-2"></i>
                        <span>Par {{ $news->author ?? 'Admin' }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>{{ $news->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ $news->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-eye mr-2"></i>
                        <span>{{ number_format($news->views ?? 0) }} vues</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-comments mr-2"></i>
                        <span>{{ $news->comments_count ?? 0 }} commentaires</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <main class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                        <!-- Excerpt -->
                        @if($news->excerpt)
                        <div class="text-xl text-gray-700 dark:text-gray-300 font-medium mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                            {{ $news->excerpt }}
                        </div>
                        @endif
                        
                        <!-- Main Image -->
                        @if(isset($news->image_path) && $news->image_path)
                        <figure class="mb-8">
                            <img src="{{ asset('storage/' . $news->image_path) }}" 
                                 alt="{{ $news->title }}"
                                 class="w-full rounded-xl shadow-lg">
                            @if($news->image_caption)
                            <figcaption class="text-sm text-gray-600 dark:text-gray-400 mt-3 text-center italic">
                                {{ $news->image_caption }}
                            </figcaption>
                            @endif
                        </figure>
                        @endif
                        
                        <!-- Article Content -->
                        <div class="prose prose-lg dark:prose-invert max-w-none">
                            {!! nl2br(e($news->content)) !!}
                        </div>
                        
                        <!-- Tags -->
                        @if(isset($news->tags) && is_array($news->tags) && count($news->tags) > 0)
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-tags mr-2"></i>Tags
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($news->tags as $tag)
                                <a href="{{ route('news.index', ['tag' => $tag]) }}" 
                                   class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-700 dark:hover:text-blue-300 transition">
                                    #{{ $tag }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- Share Buttons -->
                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">
                                <i class="fas fa-share-alt mr-2"></i>Partager cet article
                            </h3>
                            <div class="flex gap-3">
                                <button onclick="shareOnFacebook()" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i class="fab fa-facebook-f mr-2"></i>Facebook
                                </button>
                                <button onclick="shareOnTwitter()" 
                                        class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition">
                                    <i class="fab fa-twitter mr-2"></i>Twitter
                                </button>
                                <button onclick="shareOnWhatsApp()" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                                </button>
                                <button onclick="shareOnLinkedIn()" 
                                        class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition">
                                    <i class="fab fa-linkedin-in mr-2"></i>LinkedIn
                                </button>
                                <button onclick="copyLink()" 
                                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                                    <i class="fas fa-link mr-2"></i>Copier le lien
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Author Box -->
                    @if(isset($news->author_bio))
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mt-8">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-user-edit mr-2"></i>À propos de l'auteur
                        </h3>
                        <div class="flex items-start gap-4">
                            @if($news->author_photo)
                            <img src="{{ asset('storage/' . $news->author_photo) }}" 
                                 alt="{{ $news->author }}"
                                 class="w-20 h-20 rounded-full">
                            @else
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                {{ substr($news->author ?? 'A', 0, 1) }}
                            </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $news->author ?? 'Admin' }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $news->author_bio }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Comments Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mt-8">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-6">
                            <i class="fas fa-comments mr-2"></i>Commentaires ({{ $news->comments_count ?? 0 }})
                        </h3>
                        
                        @auth
                        <!-- Comment Form -->
                        <form class="mb-8" action="{{ route('news.comment', $news->id) }}" method="POST">
                            @csrf
                            <textarea name="comment" 
                                      rows="4" 
                                      placeholder="Laissez votre commentaire..."
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                            <button type="submit" 
                                    class="mt-3 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="fas fa-paper-plane mr-2"></i>Publier
                            </button>
                        </form>
                        @else
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-6">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Connectez-vous</a> 
                                pour laisser un commentaire
                            </p>
                        </div>
                        @endauth
                        
                        <!-- Comments List -->
                        <div class="space-y-4">
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                Aucun commentaire pour le moment. Soyez le premier à commenter!
                            </p>
                        </div>
                    </div>
                </main>

                <!-- Sidebar -->
                <aside class="lg:col-span-1 space-y-6">
                    <!-- Related News -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sticky top-4">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-newspaper mr-2"></i>Articles similaires
                        </h3>
                        <div class="space-y-4">
                            @php
                                $relatedNews = $relatedNews ?? collect([
                                    (object)['id' => 1, 'title' => 'Calendrier des examens 2025 publié', 'created_at' => now()->subDays(2)],
                                    (object)['id' => 2, 'title' => 'Bourses d\'excellence: nouveaux critères', 'created_at' => now()->subDays(5)],
                                    (object)['id' => 3, 'title' => 'Réforme du système éducatif', 'created_at' => now()->subWeek()],
                                ]);
                            @endphp
                            
                            @foreach($relatedNews->take(5) as $related)
                            <article class="border-l-4 border-blue-500 pl-4">
                                <h4 class="font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400">
                                    <a href="{{ route('news.show', $related->id) }}">
                                        {{ $related->title }}
                                    </a>
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $related->created_at->diffForHumans() }}
                                </p>
                            </article>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                        <h3 class="font-bold mb-4">
                            <i class="fas fa-envelope mr-2"></i>Newsletter
                        </h3>
                        <p class="text-sm opacity-90 mb-4">
                            Recevez les dernières actualités directement dans votre boîte mail
                        </p>
                        <form>
                            <input type="email" 
                                   placeholder="Votre email" 
                                   class="w-full px-4 py-2 rounded-lg bg-white/20 backdrop-blur border border-white/30 placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white mb-3">
                            <button type="submit" 
                                    class="w-full bg-white text-blue-600 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                                S'abonner
                            </button>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-folder mr-2"></i>Catégories
                        </h3>
                        <div class="space-y-2">
                            @php
                                $categories = [
                                    'Examens' => 25,
                                    'Inscriptions' => 18,
                                    'Résultats' => 32,
                                    'Bourses' => 12,
                                    'Réformes' => 8,
                                ];
                            @endphp
                            @foreach($categories as $cat => $count)
                            <a href="{{ route('news.index', ['category' => $cat]) }}" 
                               class="flex items-center justify-between p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition">
                                <span class="text-gray-700 dark:text-gray-300">{{ $cat }}</span>
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                    {{ $count }}
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </article>
</div>

@push('scripts')
<script>
    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    }
    
    function shareOnTwitter() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $news->title }}');
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
    }
    
    function shareOnWhatsApp() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('{{ $news->title }}');
        window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
    }
    
    function shareOnLinkedIn() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
    }
    
    function copyLink() {
        navigator.clipboard.writeText(window.location.href);
        alert('Lien copié dans le presse-papier!');
    }
</script>
@endpush
@endsection