@extends('layouts.admin-dashboard')

@section('title', 'Templates de Messages - Mama École')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Templates de Messages</h1>
        <button onclick="openCreateTemplateModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouveau Template
        </button>
    </div>

    <!-- Catégories de Templates -->
    <div class="flex gap-2 mb-6">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tous</button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Notes</button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Absences</button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Réunions</button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Urgent</button>
        <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Personnalisé</button>
    </div>

    <!-- Grille de Templates -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $template)
        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-lg">{{ $template->name }}</h3>
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($template->type == 'urgent') bg-red-100 text-red-800
                    @elseif($template->type == 'meeting') bg-blue-100 text-blue-800
                    @elseif($template->type == 'grades') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($template->type) }}
                </span>
            </div>
            
            <div class="mb-3">
                <p class="text-sm text-gray-600 mb-2">Aperçu (Français):</p>
                <div class="bg-gray-50 p-2 rounded text-sm">
                    {{ json_decode($template->content)->french ?? 'Non défini' }}
                </div>
            </div>
            
            <div class="mb-3">
                <p class="text-sm text-gray-600 mb-1">Variables disponibles:</p>
                <div class="flex flex-wrap gap-1">
                    @foreach(json_decode($template->variables ?? '[]') as $var)
                    <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs rounded">{{ $var }}</span>
                    @endforeach
                </div>
            </div>
            
            <div class="flex justify-between items-center pt-3 border-t">
                <div class="text-sm text-gray-500">
                    <i class="fas fa-chart-bar mr-1"></i>
                    Utilisé {{ $template->usage_count }} fois
                </div>
                <div class="flex gap-2">
                    <button onclick="previewTemplate({{ $template->id }})" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="editTemplate({{ $template->id }})" class="text-green-600 hover:text-green-800">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button onclick="deleteTemplate({{ $template->id }})" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-8 text-gray-500">
            <i class="fas fa-file-alt text-4xl mb-3"></i>
            <p>Aucun template disponible</p>
            <button onclick="openCreateTemplateModal()" class="mt-2 text-blue-600 hover:text-blue-800">
                Créer votre premier template
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Créer Template -->
<div id="createTemplateModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
        
        <div class="relative bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b sticky top-0 bg-white">
                <h3 class="text-lg font-semibold">Créer un Template</h3>
                <button onclick="closeCreateTemplateModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="createTemplateForm" class="p-6">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du Template *</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                    <select name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="grades">Notes</option>
                        <option value="absence">Absence</option>
                        <option value="meeting">Réunion</option>
                        <option value="urgent">Urgent</option>
                        <option value="custom">Personnalisé</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Variables (séparées par des virgules)</label>
                    <input type="text" name="variables" placeholder="student_name, grade, date, time" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Utilisez {variable} dans vos messages</p>
                </div>
                
                <!-- Messages multilingues -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <img src="https://flagcdn.com/16x12/fr.png" class="inline mr-1"> Message en Français *
                        </label>
                        <textarea name="content_french" rows="3" required 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Bonjour, votre enfant {student_name} a obtenu {grade}/20..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <img src="https://flagcdn.com/16x12/ci.png" class="inline mr-1"> Message en Dioula
                        </label>
                        <textarea name="content_dioula" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="I ni ce, i den {student_name} ye {grade} sɔrɔ..."></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message en Baoulé
                        </label>
                        <textarea name="content_baoule" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message en Bété
                        </label>
                        <textarea name="content_bete" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message en Sénoufo
                        </label>
                        <textarea name="content_senoufo" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeCreateTemplateModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Créer Template
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openCreateTemplateModal() {
    document.getElementById('createTemplateModal').classList.remove('hidden');
}

function closeCreateTemplateModal() {
    document.getElementById('createTemplateModal').classList.add('hidden');
}

function previewTemplate(id) {
    // Implémenter la prévisualisation
    console.log('Preview template:', id);
}

function editTemplate(id) {
    // Implémenter l'édition
    console.log('Edit template:', id);
}

function deleteTemplate(id) {
    if(confirm('Êtes-vous sûr de vouloir supprimer ce template?')) {
        // Implémenter la suppression
        console.log('Delete template:', id);
    }
}

document.getElementById('createTemplateForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Construire l'objet content multilingue
    const content = {
        french: formData.get('content_french'),
        dioula: formData.get('content_dioula') || '',
        baoule: formData.get('content_baoule') || '',
        bete: formData.get('content_bete') || '',
        senoufo: formData.get('content_senoufo') || ''
    };
    
    const data = {
        name: formData.get('name'),
        type: formData.get('type'),
        variables: formData.get('variables').split(',').map(v => v.trim()),
        content: content
    };
    
    try {
        // Implémenter l'envoi au serveur
        console.log('Creating template:', data);
        alert('Template créé avec succès!');
        closeCreateTemplateModal();
        location.reload();
    } catch(error) {
        console.error('Error:', error);
        alert('Erreur lors de la création du template');
    }
});
</script>
@endpush

@endsection