@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Centre de support</h1>
            <p class="text-gray-600 dark:text-gray-400">Obtenez de l'aide et contactez notre équipe</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('author.support.faq') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-question-circle mr-2"></i>FAQ
            </a>
            <button onclick="openTicketModal()" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Nouveau ticket
            </button>
        </div>
    </div>

    <!-- Support Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 dark:bg-orange-900 rounded-lg">
                    <i class="fas fa-ticket-alt text-orange-600 dark:text-orange-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tickets ouverts</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['open_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tickets résolus</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['resolved_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <i class="fas fa-clock text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Temps de réponse</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['avg_response_time'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-teal-100 dark:bg-purple-900 rounded-lg">
                    <i class="fas fa-heart text-teal-600 dark:text-purple-400"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Satisfaction</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['satisfaction_rate'] }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Help -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aide rapide</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('author.support.faq') }}" 
               class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-blue-500 transition-colors">
                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg mr-4">
                    <i class="fas fa-question-circle text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">FAQ</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Questions fréquentes</p>
                </div>
            </a>

            <a href="#" onclick="openTicketModal()" 
               class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-green-500 transition-colors">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg mr-4">
                    <i class="fas fa-headset text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Contact support</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Créer un ticket</p>
                </div>
            </a>

            <a href="#" 
               class="flex items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-purple-500 transition-colors">
                <div class="p-2 bg-teal-100 dark:bg-purple-900 rounded-lg mr-4">
                    <i class="fas fa-book text-teal-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Guide d'utilisation</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Documentation complète</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Tickets -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Vos tickets récents</h3>
        </div>
        <div class="p-6">
            @if($recentTickets->isEmpty())
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-ticket-alt text-4xl mb-4"></i>
                <p class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun ticket de support</p>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Vous n'avez pas encore créé de ticket de support. Notre équipe est là pour vous aider !
                </p>
                <button onclick="openTicketModal()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Créer votre premier ticket
                </button>
            </div>
            @else
            <div class="space-y-4">
                @foreach($recentTickets as $ticket)
                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-{{ $ticket->status_color }}-100 dark:bg-{{ $ticket->status_color }}-900 rounded-lg mr-4">
                            <i class="fas fa-{{ $ticket->status_icon }} text-{{ $ticket->status_color }}-600 dark:text-{{ $ticket->status_color }}-400"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $ticket->subject }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $ticket->category }} • {{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-{{ $ticket->status_color }}-100 text-{{ $ticket->status_color }}-800 text-xs rounded-full">
                        {{ $ticket->status }}
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Autres moyens de nous contacter</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg mr-4">
                    <i class="fas fa-envelope text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Email</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">support@bookplatform.com</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg mr-4">
                    <i class="fas fa-comments text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Chat en direct</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Lun-Ven 9h-18h</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="p-2 bg-teal-100 dark:bg-purple-800 rounded-lg mr-4">
                    <i class="fas fa-phone text-teal-600 dark:text-purple-400"></i>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 dark:text-white">Téléphone</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">+33 1 23 45 67 89</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Modal -->
<div id="ticketModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Créer un ticket de support</h3>
                    <button onclick="closeTicketModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <form action="{{ route('author.support.ticket') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catégorie *</label>
                        <select name="category" required 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            <option value="">Sélectionner une catégorie</option>
                            <option value="technical">Problème technique</option>
                            <option value="account">Compte et profil</option>
                            <option value="publishing">Publication de livre</option>
                            <option value="payment">Paiements et revenus</option>
                            <option value="general">Question générale</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Priorité *</label>
                        <select name="priority" required 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                            <option value="low">Faible</option>
                            <option value="medium" selected>Moyenne</option>
                            <option value="high">Élevée</option>
                            <option value="urgent">Urgente</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sujet *</label>
                    <input type="text" name="subject" required 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                           placeholder="Décrivez brièvement votre problème">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description *</label>
                    <textarea name="message" rows="6" required 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                              placeholder="Décrivez votre problème en détail..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeTicketModal()" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer le ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTicketModal() {
    document.getElementById('ticketModal').classList.remove('hidden');
}

function closeTicketModal() {
    document.getElementById('ticketModal').classList.add('hidden');
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('ticketModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeTicketModal();
    }
});
</script>
@endsection
