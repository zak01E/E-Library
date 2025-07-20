@extends('layouts.admin-dashboard')

@section('page-title', 'Paramètres Système')
@section('page-description', 'Configurez les paramètres globaux de votre plateforme eLibrary')

@section('content')
<div class="space-y-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erreurs de validation :</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Settings Form -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Paramètres généraux</h3>

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Site Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700">Nom du site</label>
                        <input type="text" 
                               name="site_name" 
                               id="site_name" 
                               value="{{ old('site_name', $settings['site_name'] ?? 'E-Library') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                               required>
                    </div>
                    
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <input type="text" 
                               name="site_description" 
                               id="site_description" 
                               value="{{ old('site_description', $settings['site_description'] ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700">Email de contact</label>
                        <input type="email" 
                               name="contact_email" 
                               id="contact_email" 
                               value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="support_phone" class="block text-sm font-medium text-gray-700">Téléphone de support</label>
                        <input type="tel" 
                               name="support_phone" 
                               id="support_phone" 
                               value="{{ old('support_phone', $settings['support_phone'] ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Localization -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="default_language" class="block text-sm font-medium text-gray-700">Langue par défaut</label>
                        <select name="default_language" 
                                id="default_language"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="fr" {{ ($settings['default_language'] ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                            <option value="en" {{ ($settings['default_language'] ?? 'fr') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="es" {{ ($settings['default_language'] ?? 'fr') == 'es' ? 'selected' : '' }}>Español</option>
                            <option value="de" {{ ($settings['default_language'] ?? 'fr') == 'de' ? 'selected' : '' }}>Deutsch</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700">Fuseau horaire</label>
                        <select name="timezone" 
                                id="timezone"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="Europe/Paris" {{ ($settings['timezone'] ?? 'Europe/Paris') == 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris (UTC+1)</option>
                            <option value="Europe/London" {{ ($settings['timezone'] ?? 'Europe/Paris') == 'Europe/London' ? 'selected' : '' }}>Europe/London (UTC+0)</option>
                            <option value="America/New_York" {{ ($settings['timezone'] ?? 'Europe/Paris') == 'America/New_York' ? 'selected' : '' }}>America/New_York (UTC-5)</option>
                        </select>
                    </div>
                </div>

                <!-- Maintenance Mode -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-base font-medium text-gray-900 mb-4">Mode maintenance</h4>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="maintenance_mode" 
                                   id="maintenance_mode" 
                                   value="1"
                                   {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                                Activer le mode maintenance
                            </label>
                        </div>
                        <div>
                            <label for="maintenance_message" class="block text-sm font-medium text-gray-700">Message de maintenance</label>
                            <textarea name="maintenance_message" 
                                      id="maintenance_message" 
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('maintenance_message', $settings['maintenance_message'] ?? 'Le site est actuellement en maintenance. Nous serons de retour bientôt.') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <!-- Test Button -->
                    <a href="{{ route('admin.test.settings.update') }}"
                       class="inline-flex justify-center py-2 px-4 border border-yellow-300 shadow-sm text-sm font-medium rounded-md text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Test Sauvegarde
                    </a>

                    <!-- Normal Submit Button -->
                    <button type="submit"
                            onclick="console.log('Form submission clicked'); return true;"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Logos Section -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">Logos et icônes</h3>

            <form method="POST" action="{{ route('admin.settings.logos.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <!-- Site Logo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo principal</label>
                        @if($settings['site_logo'] ?? false)
                            <div class="mb-3 flex items-center space-x-3">
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo actuel" class="h-16 w-auto border border-gray-200 rounded">
                                <div>
                                    <p class="text-xs text-gray-500">Logo actuel</p>
                                    <button type="button" class="text-xs text-red-600 hover:text-red-800 mt-1"
                                            onclick="deleteLogo('site_logo')">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        @endif
                        <input type="file" name="site_logo" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, SVG jusqu'à 2MB. Recommandé : 200x60px</p>
                    </div>

                    <!-- Favicon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                        @if($settings['site_favicon'] ?? false)
                            <div class="mb-3 flex items-center space-x-3">
                                <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon actuel" class="h-8 w-8 border border-gray-200 rounded">
                                <div>
                                    <p class="text-xs text-gray-500">Favicon actuel</p>
                                    <button type="button" class="text-xs text-red-600 hover:text-red-800 mt-1"
                                            onclick="deleteLogo('site_favicon')">
                                        Supprimer
                                    </button>
                                </div>
                            </div>
                        @endif
                        <input type="file" name="site_favicon" accept="image/x-icon,image/png"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        <p class="text-xs text-gray-500 mt-1">ICO ou PNG jusqu'à 512KB. Recommandé : 32x32px</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Formulaires cachés pour la suppression des logos -->
<form id="delete-logo-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal de confirmation professionnel -->
<div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.962-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4" id="modal-title">Confirmer la suppression</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="modal-message">
                    Cette action est irréversible. Êtes-vous sûr de vouloir continuer ?
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="modal-confirm" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Supprimer
                </button>
                <button id="modal-cancel" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentDeleteType = null;

function deleteLogo(type) {
    currentDeleteType = type;
    const itemName = type === 'site_favicon' ? 'favicon' : 'logo';

    document.getElementById('modal-title').textContent = `Supprimer le ${itemName}`;
    document.getElementById('modal-message').textContent = `Êtes-vous sûr de vouloir supprimer ce ${itemName} ? Cette action est irréversible.`;
    document.getElementById('confirmModal').classList.remove('hidden');
}

document.getElementById('modal-confirm').addEventListener('click', function() {
    if (currentDeleteType) {
        const form = document.getElementById('delete-logo-form');
        form.action = '{{ route("admin.settings.logo.delete", ":type") }}'.replace(':type', currentDeleteType);
        form.submit();
    }
});

document.getElementById('modal-cancel').addEventListener('click', function() {
    document.getElementById('confirmModal').classList.add('hidden');
    currentDeleteType = null;
});

// Fermer le modal en cliquant à l'extérieur
document.getElementById('confirmModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
        currentDeleteType = null;
    }
});
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Settings page loaded');

    // Debug all forms
    const forms = document.querySelectorAll('form[method="POST"]');
    console.log('Found POST forms:', forms.length);

    forms.forEach((form, index) => {
        console.log(`Form ${index}:`, form.action);

        // Add submit event listener
        form.addEventListener('submit', function(e) {
            console.log('Form submission started:', form.action);
            console.log('Form data:', new FormData(form));
            console.log('CSRF Token:', form.querySelector('input[name="_token"]')?.value);

            // Check if form is valid
            if (!form.checkValidity()) {
                console.log('Form is invalid');
                e.preventDefault();
                return false;
            }

            console.log('Form is valid, submitting...');
            return true;
        });

        // Add click listener to submit buttons
        const submitButtons = form.querySelectorAll('button[type="submit"]');
        submitButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                console.log('Submit button clicked');

                // Force form submission after a small delay
                setTimeout(() => {
                    console.log('Forcing form submission...');
                    form.submit();
                }, 100);
            });
        });
    });
});
</script>
@endpush
