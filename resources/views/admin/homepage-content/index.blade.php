@extends('layouts.admin-dashboard')

@section('page-title', 'Contenu Page d\'Accueil')
@section('page-description', 'Gérez tous les textes et contenus de votre page d\'accueil')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Contenu de la Page d'Accueil</h1>
                <p class="text-gray-600 mt-1">Personnalisez tous les textes et contenus affichés sur votre page d'accueil</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ url('/') }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Voir la Page
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('admin.homepage-content.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-lg shadow-sm" x-data="{ activeTab: 'navigation' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6">
                    @foreach($sections as $sectionKey => $section)
                        <button type="button"
                                @click="activeTab = '{{ $sectionKey }}'"
                                :class="activeTab === '{{ $sectionKey }}' ? 'border-emerald-500 text-emerald-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                            {{ $section['title'] }}
                        </button>
                    @endforeach
                </nav>
            </div>

            <!-- Tab Contents -->
            <div class="p-6">
                @foreach($sections as $sectionKey => $section)
                    <div x-show="activeTab === '{{ $sectionKey }}'" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $section['title'] }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($section['settings'] as $settingKey => $settingLabel)
                                    <div>
                                        <label for="{{ $settingKey }}" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ $settingLabel }}
                                        </label>
                                        @if(in_array($settingKey, ['testimonial1_text', 'testimonial2_text', 'testimonial3_text', 'faq1_answer', 'faq2_answer', 'faq3_answer', 'faq4_answer', 'faq5_answer', 'cta_subtitle', 'newsletter_subtitle']))
                                            <textarea name="settings[{{ $settingKey }}]" 
                                                      id="{{ $settingKey }}"
                                                      rows="3"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                                                      placeholder="Entrez {{ strtolower($settingLabel) }}...">{{ $settings[$settingKey] ?? '' }}</textarea>
                                        @else
                                            @php
                                                $defaultValues = [
                                                    'simple_authors_title' => 'Auteurs Vedettes',
                                                    'simple_authors_subtitle' => 'Découvrez les auteurs les plus appréciés de notre communauté',
                                                    'simple_authors_button' => 'Voir les livres',
                                                    'simple_authors_view_all' => 'Voir tous les auteurs'
                                                ];
                                                $currentValue = $settings[$settingKey] ?? $defaultValues[$settingKey] ?? '';
                                                $placeholder = $defaultValues[$settingKey] ?? "Entrez " . strtolower($settingLabel) . "...";
                                            @endphp
                                            <input type="text"
                                                   name="settings[{{ $settingKey }}]"
                                                   id="{{ $settingKey }}"
                                                   value="{{ $currentValue }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm"
                                                   placeholder="{{ $placeholder }}">
                                        @endif
                                        
                                        @if(str_contains($settingKey, 'icon'))
                                            <p class="text-xs text-gray-500 mt-1">
                                                Exemple: fas fa-book-reader, fas fa-search, etc.
                                            </p>
                                        @elseif(str_contains($settingKey, 'color'))
                                            <p class="text-xs text-gray-500 mt-1">
                                                Couleurs disponibles: emerald, green, blue, orange, purple, red, gray
                                            </p>
                                        @elseif(str_contains($settingKey, 'simple_authors'))
                                            <p class="text-xs text-gray-500 mt-1">
                                                @if($settingKey === 'simple_authors_title')
                                                    📝 Le titre principal affiché en haut de la section (ex: "Auteurs Vedettes")
                                                @elseif($settingKey === 'simple_authors_subtitle')
                                                    📄 La description qui apparaît sous le titre (ex: "Découvrez nos meilleurs auteurs")
                                                @elseif($settingKey === 'simple_authors_button')
                                                    🔗 Le texte du petit bouton sous chaque auteur (ex: "Voir les livres")
                                                @elseif($settingKey === 'simple_authors_view_all')
                                                    🔘 Le texte du gros bouton en bas de la section (ex: "Voir tous les auteurs")
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="window.location.reload()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-undo mr-2"></i>
                Annuler
            </button>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                <i class="fas fa-save mr-2"></i>
                Enregistrer les Modifications
            </button>
        </div>
    </form>

    <!-- Preview Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Aperçu des Modifications</h3>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-600 mb-3">
                <i class="fas fa-info-circle mr-2"></i>
                Les modifications seront visibles immédiatement sur votre site après sauvegarde.
            </p>
            <div class="flex space-x-3">
                <a href="{{ url('/') }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                    <i class="fas fa-external-link-alt mr-1"></i>
                    Voir la page d'accueil
                </a>
                <span class="text-gray-300">|</span>
                <button type="button" onclick="window.location.reload()" class="text-gray-600 hover:text-gray-700 text-sm font-medium">
                    <i class="fas fa-sync-alt mr-1"></i>
                    Actualiser cette page
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-save functionality (optional)
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            // Add visual indicator that changes are pending
            const saveButton = document.querySelector('button[type="submit"]');
            if (!saveButton.classList.contains('bg-yellow-500')) {
                saveButton.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                saveButton.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
                saveButton.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Modifications en attente';
            }
        });
    });
});
</script>
@endsection
