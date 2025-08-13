@extends('layouts.admin-dashboard')

@section('title', 'Administration Mama École')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Administration Mama École</h1>
        <button onclick="window.location.href='{{ route('mama-ecole.dashboard') }}'" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-chart-line mr-2"></i>Tableau de Bord
        </button>
    </div>

    <!-- Statistiques Rapides -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100">Parents Inscrits</p>
                    <p class="text-3xl font-bold">{{ $stats['total_parents'] ?? 0 }}</p>
                    <p class="text-sm text-blue-100 mt-1">+12% ce mois</p>
                </div>
                <i class="fas fa-users text-4xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100">Appels Aujourd'hui</p>
                    <p class="text-3xl font-bold">{{ $stats['calls_today'] ?? 0 }}</p>
                    <p class="text-sm text-green-100 mt-1">{{ $stats['success_rate'] ?? 0 }}% réussis</p>
                </div>
                <i class="fas fa-phone text-4xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100">SMS Envoyés</p>
                    <p class="text-3xl font-bold">{{ $stats['sms_sent'] ?? 0 }}</p>
                    <p class="text-sm text-purple-100 mt-1">{{ $stats['sms_delivered'] ?? 0 }} délivrés</p>
                </div>
                <i class="fas fa-sms text-4xl text-purple-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100">Taux Engagement</p>
                    <p class="text-3xl font-bold">{{ $stats['engagement_rate'] ?? 0 }}%</p>
                    <p class="text-sm text-orange-100 mt-1">Score moyen: 78/100</p>
                </div>
                <i class="fas fa-chart-pie text-4xl text-orange-200"></i>
            </div>
        </div>
    </div>

    <!-- Actions Rapides -->
    <div class="bg-gray-50 rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Actions Rapides</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <button onclick="openNotificationModal()" 
                    class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                <i class="fas fa-bullhorn mr-3"></i>
                Nouvelle Notification
            </button>
            
            <button onclick="openCampaignModal()" 
                    class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 transition flex items-center justify-center">
                <i class="fas fa-rocket mr-3"></i>
                Créer Campagne
            </button>
            
            <button onclick="openParentModal()" 
                    class="bg-purple-600 text-white p-4 rounded-lg hover:bg-purple-700 transition flex items-center justify-center">
                <i class="fas fa-user-plus mr-3"></i>
                Ajouter Parent
            </button>
        </div>
    </div>

    <!-- Tableau des Dernières Interactions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold">Dernières Interactions</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Canal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentInteractions ?? [] as $interaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $interaction->parent_name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $interaction->phone_number ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($interaction->message_type == 'urgent') bg-red-100 text-red-800
                                @elseif($interaction->message_type == 'meeting') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($interaction->message_type ?? 'info') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($interaction->channel == 'voice')
                                <i class="fas fa-phone text-green-500"></i> Appel
                            @elseif($interaction->channel == 'sms')
                                <i class="fas fa-sms text-blue-500"></i> SMS
                            @else
                                <i class="fas fa-mobile text-purple-500"></i> USSD
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($interaction->status == 'completed') bg-green-100 text-green-800
                                @elseif($interaction->status == 'failed') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($interaction->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $interaction->created_at ? $interaction->created_at->format('d/m H:i') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="viewDetails({{ $interaction->id ?? 0 }})" class="text-blue-600 hover:text-blue-900">Détails</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Aucune interaction récente
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nouvelle Notification -->
<div id="notificationModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white rounded-lg max-w-2xl w-full">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Envoyer une Notification</h3>
                <button onclick="closeNotificationModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="notificationForm" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Classe</label>
                    <select name="class_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Toutes les classes</option>
                        @foreach($classes ?? [] as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de Message</label>
                    <select name="message_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="grades">Notes</option>
                        <option value="absence">Absence</option>
                        <option value="meeting">Réunion</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Canal</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="channels[]" value="voice" class="mr-2" checked>
                            <span>Appel Vocal</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="channels[]" value="sms" class="mr-2">
                            <span>SMS</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="channels[]" value="ussd" class="mr-2">
                            <span>USSD</span>
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                    <textarea name="message" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                              placeholder="Entrez votre message ici..."></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Langues</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="french" class="mr-2" checked>
                            <span>Français</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="dioula" class="mr-2">
                            <span>Dioula</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="baoule" class="mr-2">
                            <span>Baoulé</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="bete" class="mr-2">
                            <span>Bété</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="languages[]" value="senoufo" class="mr-2">
                            <span>Sénoufo</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeNotificationModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openNotificationModal() {
    document.getElementById('notificationModal').classList.remove('hidden');
}

function closeNotificationModal() {
    document.getElementById('notificationModal').classList.add('hidden');
}

function openCampaignModal() {
    window.location.href = '{{ route("mama-ecole.campaigns") }}';
}

function openParentModal() {
    window.location.href = '{{ route("mama-ecole.parents") }}';
}

function viewDetails(id) {
    // Implémenter la vue détaillée
    console.log('View details for interaction:', id);
}

// Soumettre le formulaire de notification
document.getElementById('notificationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    try {
        const response = await fetch('{{ route("mama-ecole.notify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Notification envoyée avec succès!');
            closeNotificationModal();
            location.reload();
        } else {
            alert('Erreur lors de l\'envoi: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Erreur lors de l\'envoi de la notification');
    }
});

// Auto-refresh des statistiques toutes les 30 secondes
setInterval(() => {
    fetch('{{ route("mama-ecole.dashboard") }}')
        .then(response => response.text())
        .then(html => {
            // Mettre à jour les statistiques
            console.log('Stats refreshed');
        });
}, 30000);
</script>
@endpush

@endsection