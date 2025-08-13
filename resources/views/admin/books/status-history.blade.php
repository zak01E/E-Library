@extends('layouts.admin-dashboard')

@section('page-title', 'Historique des Statuts')
@section('page-description', 'Historique des changements de statut pour "' . $book->title . '"')

@section('content')
<div class="space-y-6">
    <!-- Book Info Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-start space-x-4">
                <div class="w-16 h-20 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-lg flex items-center justify-center">
                    @if($book->cover_image)
                        <img src="{{ Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <i class="fas fa-book text-white text-xl"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 mb-1">{{ $book->title }}</h1>
                    <p class="text-gray-600 mb-2">par {{ $book->author_name }}</p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span><i class="fas fa-eye mr-1"></i>{{ number_format($book->views) }} vues</span>
                        <span><i class="fas fa-download mr-1"></i>{{ number_format($book->downloads) }} téléchargements</span>
                        <span><i class="fas fa-calendar mr-1"></i>{{ $book->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <!-- Current Status -->
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $book->status_badge_class }}">
                    {{ $book->status_label }}
                </span>
                <a href="{{ admin_route('books.show', $book) }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Retour au livre
                </a>
            </div>
        </div>
    </div>

    <!-- Status History -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Historique des Changements</h2>
            <p class="text-sm text-gray-600">Tous les changements de statut pour ce livre</p>
        </div>

        @if($history->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($history as $change)
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <!-- Timeline Icon -->
                            <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                @switch($change->new_status)
                                    @case('approved')
                                        <i class="fas fa-check text-green-600"></i>
                                        @break
                                    @case('rejected')
                                        <i class="fas fa-times text-red-600"></i>
                                        @break
                                    @case('under_review')
                                        <i class="fas fa-search text-blue-600"></i>
                                        @break
                                    @case('suspended')
                                        <i class="fas fa-pause text-orange-600"></i>
                                        @break
                                    @case('pending')
                                        <i class="fas fa-clock text-yellow-600"></i>
                                        @break
                                    @default
                                        <i class="fas fa-question text-gray-600"></i>
                                @endswitch
                            </div>

                            <!-- Change Details -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    @if($change->old_status)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $change->old_status_badge_class }}">
                                            {{ $change->old_status_label }}
                                        </span>
                                        <i class="fas fa-arrow-right text-gray-400 text-xs"></i>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $change->new_status_badge_class }}">
                                        {{ $change->new_status_label }}
                                    </span>
                                </div>

                                @if($change->reason)
                                    <p class="text-gray-700 mb-2">{{ $change->reason }}</p>
                                @endif

                                @if($change->admin_notes)
                                    <div class="bg-gray-50 rounded-lg p-3 mb-2">
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-sticky-note mr-1"></i>
                                            <strong>Note interne :</strong> {{ $change->admin_notes }}
                                        </p>
                                    </div>
                                @endif

                                <div class="flex items-center space-x-4 text-xs text-gray-500">
                                    <span>
                                        <i class="fas fa-user mr-1"></i>
                                        {{ $change->changedBy->name ?? 'Système' }}
                                    </span>
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $change->created_at->format('d/m/Y à H:i') }}
                                    </span>
                                    @if($change->notification_sent)
                                        <span class="text-green-600">
                                            <i class="fas fa-envelope mr-1"></i>
                                            Auteur notifié
                                        </span>
                                    @else
                                        <span class="text-orange-600">
                                            <i class="fas fa-envelope-open mr-1"></i>
                                            Notification en attente
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($history->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $history->links() }}
                </div>
            @endif
        @else
            <div class="p-12 text-center">
                <i class="fas fa-history text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun historique</h3>
                <p class="text-gray-600">Ce livre n'a pas encore d'historique de changements de statut.</p>
            </div>
        @endif
    </div>
</div>
@endsection
