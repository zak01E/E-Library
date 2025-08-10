@props(['book', 'compact' => false])

<div class="relative" x-data="{ open: false, loading: false }" x-init="console.log('Status selector initialized for book:', {{ $book->id }})"
    <!-- Current Status Badge -->
    <button @click="open = !open" 
            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $book->status_badge_class }} hover:opacity-80 transition-opacity cursor-pointer">
        <span class="mr-1">
            @switch($book->status)
                @case('approved')
                    <i class="fas fa-check-circle"></i>
                    @break
                @case('pending')
                    <i class="fas fa-clock"></i>
                    @break
                @case('rejected')
                    <i class="fas fa-times-circle"></i>
                    @break
                @case('under_review')
                    <i class="fas fa-search"></i>
                    @break
                @case('suspended')
                    <i class="fas fa-pause-circle"></i>
                    @break
                @default
                    <i class="fas fa-question-circle"></i>
            @endswitch
        </span>
        {{ $book->status_label }}
        <i class="fas fa-chevron-down ml-1 text-xs"></i>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute {{ $compact ? 'right-0' : 'left-0' }} mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
        
        <div class="p-3">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Changer le statut</h4>
            
            <form action="{{ route('admin.books.change-status', $book) }}" method="POST" class="space-y-3">
                @csrf
                @method('PATCH')
                
                <!-- Status Selection -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nouveau statut</label>
                    <select name="status" required class="w-full text-xs border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="pending" {{ $book->status === 'pending' ? 'disabled' : '' }}>
                            ⏳ En attente
                        </option>
                        <option value="approved" {{ $book->status === 'approved' ? 'disabled' : '' }}>
                            ✅ Approuvé
                        </option>
                        <option value="under_review" {{ $book->status === 'under_review' ? 'disabled' : '' }}>
                            🔍 En révision
                        </option>
                        <option value="suspended" {{ $book->status === 'suspended' ? 'disabled' : '' }}>
                            ⚠️ Suspendu
                        </option>
                        <option value="rejected" {{ $book->status === 'rejected' ? 'disabled' : '' }}>
                            ❌ Rejeté
                        </option>
                    </select>
                </div>

                <!-- Reason -->
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Raison (optionnel)</label>
                    <textarea name="reason" 
                              rows="2" 
                              placeholder="Expliquez pourquoi vous changez ce statut..."
                              class="w-full text-xs border border-gray-300 rounded px-2 py-1 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 resize-none"></textarea>
                </div>

                <!-- Notification Option -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="notify_author" 
                           id="notify_author_{{ $book->id }}" 
                           checked 
                           class="h-3 w-3 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    <label for="notify_author_{{ $book->id }}" class="ml-2 text-xs text-gray-700">
                        Notifier l'auteur
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex justify-between pt-2">
                    <button type="button" 
                            @click="open = false"
                            class="text-xs text-gray-500 hover:text-gray-700">
                        Annuler
                    </button>
                    <button type="submit"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-3 py-1 rounded font-medium transition-colors"
                            onclick="console.log('Form submitted for book:', {{ $book->id }})">
                        Changer
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Actions (for common status changes) -->
        @if($book->status !== 'approved')
        <div class="border-t border-gray-200 p-2">
            <div class="text-xs text-gray-500 mb-1">Actions rapides :</div>
            <div class="flex space-x-1">
                @if($book->status === 'pending')
                    <form action="{{ route('admin.books.approve', $book) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs bg-green-100 hover:bg-green-200 text-green-800 px-2 py-1 rounded">
                            ✅ Approuver
                        </button>
                    </form>
                @endif
                
                @if(in_array($book->status, ['approved', 'under_review']))
                    <form action="{{ route('admin.books.suspend', $book) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs bg-orange-100 hover:bg-orange-200 text-orange-800 px-2 py-1 rounded">
                            ⚠️ Suspendre
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
