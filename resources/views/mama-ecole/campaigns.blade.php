@extends('layouts.admin-dashboard')

@section('title', 'Campagnes de Notification - Mama École')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Campagnes de Notification</h1>
        <button onclick="window.location.href='{{ route('mama-ecole.campaigns.create') ?? '#' }}'" 
                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-rocket mr-2"></i>Nouvelle Campagne
        </button>
    </div>

    <!-- Statistiques des Campagnes -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-sm text-blue-600">Campagnes Actives</p>
            <p class="text-2xl font-bold text-blue-800">3</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-sm text-green-600">Parents Touchés</p>
            <p class="text-2xl font-bold text-green-800">2,456</p>
        </div>
        <div class="bg-purple-50 rounded-lg p-4">
            <p class="text-sm text-purple-600">Taux de Réussite</p>
            <p class="text-2xl font-bold text-purple-800">87%</p>
        </div>
        <div class="bg-orange-50 rounded-lg p-4">
            <p class="text-sm text-orange-600">Coût Total</p>
            <p class="text-2xl font-bold text-orange-800">45,000 FCFA</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Toutes</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">En cours</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Planifiées</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Terminées</button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Brouillons</button>
        </div>
    </div>

    <!-- Liste des Campagnes -->
    <div class="space-y-4">
        @forelse($campaigns as $campaign)
        <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <h3 class="text-xl font-semibold mr-3">{{ $campaign->name }}</h3>
                        <span class="px-3 py-1 text-xs rounded-full 
                            @if($campaign->status == 'completed') bg-green-100 text-green-800
                            @elseif($campaign->status == 'in_progress') bg-blue-100 text-blue-800
                            @elseif($campaign->status == 'scheduled') bg-yellow-100 text-yellow-800
                            @elseif($campaign->status == 'draft') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $campaign->status)) }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-3">{{ $campaign->description }}</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Cible</p>
                            <p class="font-semibold">{{ ucfirst($campaign->target_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Destinataires</p>
                            <p class="font-semibold">{{ $campaign->total_recipients }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Réussis</p>
                            <p class="font-semibold text-green-600">{{ $campaign->successful_calls }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Échoués</p>
                            <p class="font-semibold text-red-600">{{ $campaign->failed_calls }}</p>
                        </div>
                    </div>
                    
                    @if($campaign->status == 'in_progress')
                    <div class="mb-3">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Progression</span>
                            <span>{{ round(($campaign->successful_calls + $campaign->failed_calls) / max($campaign->total_recipients, 1) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ round(($campaign->successful_calls + $campaign->failed_calls) / max($campaign->total_recipients, 1) * 100) }}%"></div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar mr-2"></i>
                        @if($campaign->scheduled_at)
                            Planifiée pour: {{ \Carbon\Carbon::parse($campaign->scheduled_at)->format('d/m/Y H:i') }}
                        @elseif($campaign->started_at)
                            Démarrée: {{ \Carbon\Carbon::parse($campaign->started_at)->format('d/m/Y H:i') }}
                        @else
                            Créée: {{ \Carbon\Carbon::parse($campaign->created_at)->format('d/m/Y') }}
                        @endif
                    </div>
                </div>
                
                <div class="ml-4 flex flex-col gap-2">
                    @if($campaign->status == 'draft')
                    <button onclick="editCampaign({{ $campaign->id }})" 
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                        <i class="fas fa-edit mr-1"></i>Modifier
                    </button>
                    <button onclick="launchCampaign({{ $campaign->id }})" 
                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                        <i class="fas fa-play mr-1"></i>Lancer
                    </button>
                    @elseif($campaign->status == 'scheduled')
                    <button onclick="cancelCampaign({{ $campaign->id }})" 
                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        <i class="fas fa-times mr-1"></i>Annuler
                    </button>
                    @elseif($campaign->status == 'in_progress')
                    <button onclick="pauseCampaign({{ $campaign->id }})" 
                            class="px-3 py-1 bg-yellow-600 text-white rounded hover:bg-yellow-700 text-sm">
                        <i class="fas fa-pause mr-1"></i>Pause
                    </button>
                    @endif
                    
                    <button onclick="viewReport({{ $campaign->id }})" 
                            class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">
                        <i class="fas fa-chart-bar mr-1"></i>Rapport
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-gray-500">
            <i class="fas fa-rocket text-6xl mb-4"></i>
            <p class="text-xl mb-2">Aucune campagne créée</p>
            <p class="mb-4">Commencez par créer votre première campagne de notification</p>
            <button onclick="window.location.href='{{ route('mama-ecole.campaigns.create') ?? '#' }}'" 
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Créer une Campagne
            </button>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($campaigns->hasPages())
    <div class="mt-6">
        {{ $campaigns->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
function editCampaign(id) {
    window.location.href = `/mama-ecole/campaigns/${id}/edit`;
}

function launchCampaign(id) {
    if(confirm('Êtes-vous sûr de vouloir lancer cette campagne maintenant?')) {
        // Implémenter le lancement
        fetch(`/mama-ecole/campaigns/${id}/launch`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Campagne lancée avec succès!');
                location.reload();
            } else {
                alert('Erreur: ' + data.message);
            }
        });
    }
}

function cancelCampaign(id) {
    if(confirm('Êtes-vous sûr de vouloir annuler cette campagne?')) {
        // Implémenter l'annulation
        console.log('Cancel campaign:', id);
    }
}

function pauseCampaign(id) {
    if(confirm('Voulez-vous mettre en pause cette campagne?')) {
        // Implémenter la pause
        console.log('Pause campaign:', id);
    }
}

function viewReport(id) {
    window.location.href = `/mama-ecole/campaigns/${id}/report`;
}
</script>
@endpush

@endsection