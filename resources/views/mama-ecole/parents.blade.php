@extends('layouts.admin-dashboard')

@section('title', 'Gestion des Parents - Mama École')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Parents</h1>
        <button onclick="openAddParentModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-user-plus mr-2"></i>Ajouter un Parent
        </button>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 rounded-lg p-4">
            <p class="text-sm text-blue-600">Total Parents</p>
            <p class="text-2xl font-bold text-blue-800">{{ $stats['total'] ?? 0 }}</p>
        </div>
        <div class="bg-red-50 rounded-lg p-4">
            <p class="text-sm text-red-600">Parents Illettrés</p>
            <p class="text-2xl font-bold text-red-800">{{ $stats['illiterate'] ?? 0 }}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-sm text-green-600">Inscrits Mama École</p>
            <p class="text-2xl font-bold text-green-800">{{ $stats['enrolled'] ?? 0 }}</p>
        </div>
        <div class="bg-purple-50 rounded-lg p-4">
            <p class="text-sm text-purple-600">Parents Actifs</p>
            <p class="text-2xl font-bold text-purple-800">{{ $stats['active'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-gray-50 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" placeholder="Rechercher par nom ou téléphone..." 
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Toutes les langues</option>
                <option value="french">Français</option>
                <option value="dioula">Dioula</option>
                <option value="baoule">Baoulé</option>
                <option value="bete">Bété</option>
                <option value="senoufo">Sénoufo</option>
            </select>
            <select class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les statuts</option>
                <option value="enrolled">Inscrit</option>
                <option value="not_enrolled">Non inscrit</option>
                <option value="active">Actif</option>
                <option value="inactive">Inactif</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>Filtrer
            </button>
        </div>
    </div>

    <!-- Tableau des Parents -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Langue</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enfants</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engagement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($parents as $parent)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $parent->name ?? 'Sans nom' }}</div>
                                <div class="text-sm text-gray-500">
                                    @if(!$parent->can_read)
                                    <span class="text-red-500"><i class="fas fa-eye-slash"></i> Illettré</span>
                                    @else
                                    <span class="text-green-500"><i class="fas fa-book"></i> Lettré</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $parent->phone_number }}</div>
                        <div class="text-sm text-gray-500">{{ ucfirst($parent->preferred_call_time ?? 'Non défini') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($parent->preferred_language) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $parent->students ? $parent->students->count() : 0 }} enfant(s)
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($parent->enrolled_mama_ecole)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Inscrit
                        </span>
                        @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Non inscrit
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm text-gray-900">{{ $parent->engagement_score }}%</div>
                            <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $parent->engagement_score }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button onclick="callParent({{ $parent->id }})" class="text-green-600 hover:text-green-900 mr-3" title="Appeler">
                            <i class="fas fa-phone"></i>
                        </button>
                        <button onclick="sendSMS({{ $parent->id }})" class="text-blue-600 hover:text-blue-900 mr-3" title="SMS">
                            <i class="fas fa-sms"></i>
                        </button>
                        <button onclick="editParent({{ $parent->id }})" class="text-gray-600 hover:text-gray-900 mr-3" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="viewHistory({{ $parent->id }})" class="text-purple-600 hover:text-purple-900" title="Historique">
                            <i class="fas fa-history"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Aucun parent trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $parents->links() }}
    </div>
</div>

<!-- Modal Ajouter Parent -->
<div id="addParentModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
        
        <div class="relative bg-white rounded-lg max-w-lg w-full">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold">Ajouter un Parent</h3>
                <button onclick="closeAddParentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="addParentForm" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom (optionnel)</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de Téléphone *</label>
                    <input type="text" name="phone_number" placeholder="+2250700000000" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Langue Préférée *</label>
                    <select name="preferred_language" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="french">Français</option>
                        <option value="dioula">Dioula</option>
                        <option value="baoule">Baoulé</option>
                        <option value="bete">Bété</option>
                        <option value="senoufo">Sénoufo</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Peut Lire?</label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="radio" name="can_read" value="1" class="mr-2">
                            <span>Oui</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="can_read" value="0" class="mr-2" checked>
                            <span>Non</span>
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Heure d'Appel Préférée</label>
                    <select name="preferred_call_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Non défini</option>
                        <option value="morning">Matin (8h-12h)</option>
                        <option value="afternoon">Après-midi (14h-18h)</option>
                        <option value="evening">Soir (18h30-20h30)</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeAddParentModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openAddParentModal() {
    document.getElementById('addParentModal').classList.remove('hidden');
}

function closeAddParentModal() {
    document.getElementById('addParentModal').classList.add('hidden');
}

function callParent(id) {
    if(confirm('Voulez-vous appeler ce parent maintenant?')) {
        // Implémenter l'appel
        console.log('Calling parent:', id);
    }
}

function sendSMS(id) {
    const message = prompt('Entrez votre message SMS:');
    if(message) {
        // Implémenter l'envoi SMS
        console.log('Sending SMS to parent:', id, message);
    }
}

function editParent(id) {
    // Implémenter la modification
    console.log('Edit parent:', id);
}

function viewHistory(id) {
    // Implémenter l'historique
    window.location.href = `/mama-ecole/parents/${id}/history`;
}

document.getElementById('addParentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("mama-ecole.configure-parent") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if(result.success) {
            alert('Parent ajouté avec succès!');
            closeAddParentModal();
            location.reload();
        } else {
            alert('Erreur: ' + result.message);
        }
    } catch(error) {
        console.error('Error:', error);
        alert('Erreur lors de l\'ajout du parent');
    }
});
</script>
@endpush

@endsection