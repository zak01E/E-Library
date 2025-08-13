@extends('layouts.app')

@section('title', 'Devenir Mentor - Programme de Parrainage Académique')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:to-gray-800">
    
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-16">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <i class="fas fa-chalkboard-teacher mr-4"></i>
                    Devenez Mentor
                </h1>
                <p class="text-xl opacity-90 max-w-3xl mx-auto">
                    Partagez vos connaissances et aidez les étudiants ivoiriens à réussir leur parcours académique
                </p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-12 -mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-hand-holding-heart text-green-600 dark:text-green-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Impact Social</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Contribuez au développement de l'éducation en Côte d'Ivoire</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-blue-600 dark:text-blue-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Revenus Flexibles</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Gagnez un revenu supplémentaire selon votre disponibilité</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                    <div class="w-16 h-16 bg-teal-100 dark:bg-purple-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-network-wired text-teal-600 dark:text-purple-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Réseau Professionnel</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Élargissez votre réseau dans le milieu éducatif</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-certificate text-orange-600 dark:text-orange-400 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">Reconnaissance</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Certification officielle du Ministère de l'Éducation</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form -->
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">
                    <h2 class="text-2xl font-bold">Formulaire de Candidature</h2>
                    <p class="mt-2 opacity-90">Remplissez ce formulaire pour devenir mentor certifié</p>
                </div>

                <form action="{{ route('mentorship.apply') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <!-- Specialization -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-graduation-cap mr-2"></i>Spécialisation principale *
                        </label>
                        <select name="specialization" required 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Sélectionnez votre spécialisation</option>
                            @foreach($specializations as $spec)
                                <option value="{{ $spec }}">{{ $spec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subjects -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-book mr-2"></i>Matières que vous pouvez enseigner * (Sélectionnez plusieurs)
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg max-h-60 overflow-y-auto">
                            @foreach($subjects as $subject)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-white dark:hover:bg-gray-600 p-2 rounded transition">
                                <input type="checkbox" name="subjects[]" value="{{ $subject }}" 
                                       class="rounded text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $subject }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Educational Levels -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-layer-group mr-2"></i>Niveaux d'enseignement * (Sélectionnez plusieurs)
                        </label>
                        <div class="grid grid-cols-3 md:grid-cols-4 gap-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg max-h-48 overflow-y-auto">
                            @foreach($levels as $level)
                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-white dark:hover:bg-gray-600 p-2 rounded transition">
                                <input type="checkbox" name="levels[]" value="{{ $level }}" 
                                       class="rounded text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $level }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Bio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-user-edit mr-2"></i>Biographie professionnelle * (100-1000 caractères)
                        </label>
                        <textarea name="bio" rows="4" required minlength="100" maxlength="1000"
                                  placeholder="Présentez-vous, votre parcours et votre motivation pour devenir mentor..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white"></textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span id="bio-count">0</span>/1000 caractères
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Qualification -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-certificate mr-2"></i>Qualification/Diplôme *
                            </label>
                            <input type="text" name="qualification" required
                                   placeholder="Ex: Licence en Mathématiques"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Years of Experience -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-clock mr-2"></i>Années d'expérience *
                            </label>
                            <input type="number" name="years_experience" min="0" required
                                   placeholder="0"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <!-- Languages -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-language mr-2"></i>Langues parlées * (Sélectionnez plusieurs)
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach(['Français', 'Anglais', 'Dioula', 'Baoulé', 'Bété', 'Sénoufo', 'Malinké', 'Dan'] as $lang)
                            <label class="flex items-center space-x-2 cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 p-3 rounded-lg transition">
                                <input type="checkbox" name="languages_spoken[]" value="{{ $lang }}" 
                                       class="rounded text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $lang }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Availability -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-calendar-check mr-2"></i>Disponibilité hebdomadaire *
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="availability[{{ strtolower($day) }}][available]" 
                                           class="rounded text-emerald-600 focus:ring-emerald-500">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $day }}</span>
                                </label>
                                <div class="flex gap-2 text-sm">
                                    <select name="availability[{{ strtolower($day) }}][start]" class="px-2 py-1 border rounded dark:bg-gray-600 dark:text-white">
                                        @for($h = 6; $h <= 22; $h++)
                                            <option value="{{ $h }}:00">{{ $h }}:00</option>
                                        @endfor
                                    </select>
                                    <span class="self-center">-</span>
                                    <select name="availability[{{ strtolower($day) }}][end]" class="px-2 py-1 border rounded dark:bg-gray-600 dark:text-white">
                                        @for($h = 7; $h <= 23; $h++)
                                            <option value="{{ $h }}:00" {{ $h == 18 ? 'selected' : '' }}>{{ $h }}:00</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mentoring Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-laptop-house mr-2"></i>Type de mentorat *
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <input type="radio" name="mentoring_type" value="online" required 
                                       class="text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-3">
                                    <span class="block font-medium text-gray-700 dark:text-gray-300">En ligne</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Via visioconférence</span>
                                </span>
                            </label>
                            
                            <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <input type="radio" name="mentoring_type" value="in_person" required 
                                       class="text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-3">
                                    <span class="block font-medium text-gray-700 dark:text-gray-300">En personne</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Rencontre physique</span>
                                </span>
                            </label>
                            
                            <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                                <input type="radio" name="mentoring_type" value="both" required checked
                                       class="text-emerald-600 focus:ring-emerald-500">
                                <span class="ml-3">
                                    <span class="block font-medium text-gray-700 dark:text-gray-300">Les deux</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Flexible</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-money-bill-wave mr-2"></i>Tarif horaire (FCFA)
                            </label>
                            <input type="number" name="hourly_rate" min="0" step="500"
                                   placeholder="Laissez vide pour du bénévolat"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fab fa-linkedin mr-2"></i>Profil LinkedIn (optionnel)
                            </label>
                            <input type="url" name="linkedin_url"
                                   placeholder="https://linkedin.com/in/..."
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <!-- Volunteer Option -->
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="is_volunteer" value="1"
                                   class="mt-1 rounded text-green-600 focus:ring-green-500">
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Je souhaite être mentor bénévole</span>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Contribuez gratuitement au développement de l'éducation en Côte d'Ivoire et recevez une certification spéciale.
                                </p>
                            </div>
                        </label>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" required
                                   class="mt-1 rounded text-emerald-600 focus:ring-emerald-500">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                J'accepte les <a href="#" class="text-emerald-600 hover:text-emerald-700 underline">conditions d'utilisation</a> 
                                et je certifie que toutes les informations fournies sont exactes. Je comprends que ma candidature 
                                sera examinée et que je serai contacté sous 48 heures.
                            </div>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('mentorship.index') }}" 
                           class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-105 font-medium">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Soumettre ma candidature
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">
                Questions Fréquentes
            </h2>
            
            <div class="space-y-4">
                <details class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 cursor-pointer">
                    <summary class="font-medium text-gray-900 dark:text-white flex justify-between items-center">
                        Quelles sont les conditions pour devenir mentor?
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </summary>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Vous devez avoir au minimum un diplôme de niveau BAC+2 dans votre domaine d'expertise, 
                        ou une expérience professionnelle significative. Une vérification des antécédents sera effectuée.
                    </p>
                </details>

                <details class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 cursor-pointer">
                    <summary class="font-medium text-gray-900 dark:text-white flex justify-between items-center">
                        Combien de temps prend le processus de vérification?
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </summary>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Le processus de vérification prend généralement 24 à 48 heures. Vous recevrez un email 
                        de confirmation une fois votre profil approuvé.
                    </p>
                </details>

                <details class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 cursor-pointer">
                    <summary class="font-medium text-gray-900 dark:text-white flex justify-between items-center">
                        Comment sont calculés les paiements?
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </summary>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Les paiements sont effectués mensuellement via Mobile Money ou virement bancaire. 
                        La plateforme prélève une commission de 15% pour la maintenance et le développement.
                    </p>
                </details>

                <details class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 cursor-pointer">
                    <summary class="font-medium text-gray-900 dark:text-white flex justify-between items-center">
                        Puis-je choisir mes étudiants?
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </summary>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">
                        Oui, vous avez le contrôle total sur les demandes de mentorat. Vous pouvez accepter 
                        ou refuser les demandes selon votre disponibilité et vos préférences.
                    </p>
                </details>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    // Character counter for bio
    const bioTextarea = document.querySelector('textarea[name="bio"]');
    const bioCount = document.getElementById('bio-count');
    
    bioTextarea.addEventListener('input', function() {
        bioCount.textContent = this.value.length;
    });

    // Auto-disable time selects when day is not checked
    document.querySelectorAll('input[name*="availability"][name*="available"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parent = this.closest('div');
            const selects = parent.querySelectorAll('select');
            selects.forEach(select => {
                select.disabled = !this.checked;
                if (!this.checked) select.value = select.options[0].value;
            });
        });
    });

    // Initialize on load
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name*="availability"][name*="available"]').forEach(checkbox => {
            if (!checkbox.checked) {
                const parent = checkbox.closest('div');
                const selects = parent.querySelectorAll('select');
                selects.forEach(select => select.disabled = true);
            }
        });
    });
</script>
@endpush
@endsection