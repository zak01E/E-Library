@props(['book'])

<div class="flex items-center space-x-2">
    <!-- Current Status Badge -->
    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $book->status_badge_class }}">
        @switch($book->status)
            @case('approved')
                <i class="fas fa-check-circle mr-1"></i>
                @break
            @case('pending')
                <i class="fas fa-clock mr-1"></i>
                @break
            @case('rejected')
                <i class="fas fa-times-circle mr-1"></i>
                @break
            @case('under_review')
                <i class="fas fa-search mr-1"></i>
                @break
            @case('suspended')
                <i class="fas fa-pause-circle mr-1"></i>
                @break
            @default
                <i class="fas fa-question-circle mr-1"></i>
        @endswitch
        {{ $book->status_label }}
    </span>

    <!-- Quick Change Form -->
    <form method="POST" action="{{ route('admin.books.change-status', $book) }}" class="inline-flex items-center space-x-1">
        @csrf
        @method('PATCH')
        
        <select name="status" class="text-xs border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" onchange="this.form.submit()">
            <option value="">Changer...</option>
            @if($book->status !== 'pending')
                <option value="pending">⏳ En attente</option>
            @endif
            @if($book->status !== 'approved')
                <option value="approved">✅ Approuvé</option>
            @endif
            @if($book->status !== 'under_review')
                <option value="under_review">🔍 En révision</option>
            @endif
            @if($book->status !== 'suspended')
                <option value="suspended">⚠️ Suspendu</option>
            @endif
            @if($book->status !== 'rejected')
                <option value="rejected">❌ Rejeté</option>
            @endif
        </select>
        
        <input type="hidden" name="reason" value="Changement rapide depuis l'interface admin">
        <input type="hidden" name="notify_author" value="1">
    </form>

    <!-- History Link -->
    <a href="{{ route('admin.books.status-history', $book) }}"
       class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
       title="Voir l'historique des statuts">
        <i class="fas fa-history text-xs"></i>
    </a>
</div>
