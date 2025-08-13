@extends('layouts.app')

@section('title', 'Trouver un Mentor - Programme de Parrainage')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
    
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-emerald-500 to-teal-600 text-white py-16">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <i class="fas fa-search mr-4"></i>
                    Trouvez Votre Mentor Idéal
                </h1>
                <p class="text-xl opacity-90 max-w-3xl mx-auto">
                    Explorez notre réseau de {{ $totalMentors ?? 250 }}+ mentors qualifiés et trouvez celui qui correspond à vos besoins
                </p>
            </div>
        </div>
    </section>

    <!-- Filters Bar -->
    <section class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <form method="GET" action="{{ route('mentorship.browse') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Rechercher un mentor..." 
                                   class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Specialization -->
                    <select name="specialization" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Toutes les spécialisations</option>
                        @foreach($specializations ?? ['Mathématiques', 'Sciences', 'Français', 'Anglais', 'Informatique'] as $spec)
                        <option value="{{ $spec }}" {{ request('specialization') == $spec ? 'selected' : '' }}>
                            {{ $spec }}
                        </option>
                        @endforeach
                    </select>

                    <!-- Level -->
                    <select name="level" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tous les niveaux</option>
                        @foreach($levels ?? ['Primaire', 'Collège', 'Lycée', 'Supérieur'] as $level)
                        <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                        @endforeach
                    </select>

                    <!-- Availability -->
                    <select name="availability" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Toute disponibilité</option>
                        <option value="morning" {{ request('availability') == 'morning' ? 'selected' : '' }}>Matin</option>
                        <option value="afternoon" {{ request('availability') == 'afternoon' ? 'selected' : '' }}>Après-midi</option>
                        <option value="evening" {{ request('availability') == 'evening' ? 'selected' : '' }}>Soir</option>
                        <option value="weekend" {{ request('availability') == 'weekend' ? 'selected' : '' }}>Week-end</option>
                    </select>

                    <!-- Type -->
                    <select name="type" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Tous types</option>
                        <option value="volunteer" {{ request('type') == 'volunteer' ? 'selected' : '' }}>Bénévole</option>
                        <option value="paid" {{ request('type') == 'paid' ? 'selected' : '' }}>Payant</option>
                    </select>
                </div>

                <!-- Advanced Filters -->
                <div class="flex flex-wrap gap-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="verified_only" value="1" {{ request('verified_only') ? 'checked' : '' }}
                               class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Mentors vérifiés uniquement</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="online" value="1" {{ request('online') ? 'checked' : '' }}
                               class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sessions en ligne</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="in_person" value="1" {{ request('in_person') ? 'checked' : '' }}
                               class="rounded text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sessions en personne</span>
                    </label>
                </div>

                <!-- Sort and Submit -->
                <div class="flex justify-between items-center">
                    <select name="sort" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 dark:bg-gray-700 dark:text-white">
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Meilleures notes</option>
                        <option value="experience" {{ request('sort') == 'experience' ? 'selected' : '' }}>Plus expérimentés</option>
                        <option value="students" {{ request('sort') == 'students' ? 'selected' : '' }}>Plus d'étudiants</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>

                    <div class="flex gap-2">
                        <a href="{{ route('mentorship.browse') }}" 
                           class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Réinitialiser
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                            <i class="fas fa-filter mr-2"></i>Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-gray-600 dark:text-gray-400">
                <span class="font-semibold text-gray-900 dark:text-white">{{ $mentors->total() ?? 0 }}</span> 
                mentors trouvés
                @if(request()->hasAny(['search', 'specialization', 'level']))
                    pour votre recherche
                @endif
            </p>
        </div>

        <!-- Mentors Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $mentors = $mentors ?? collect([
                    (object)[
                        'id' => 1,
                        'user' => (object)['name' => 'Dr. Kouassi Jean', 'profile_photo_path' => null],
                        'specialization' => 'Mathématiques',
                        'subjects' => ['Algèbre', 'Géométrie', 'Statistiques'],
                        'years_experience' => 8,
                        'rating' => 4.8,
                        'total_sessions' => 150,
                        'students_helped' => 45,
                        'hourly_rate' => 5000,
                        'is_volunteer' => false,
                        'is_verified' => true,
                        'bio' => 'Professeur de mathématiques passionné avec 8 ans d\'expérience.'
                    ],
                    (object)[
                        'id' => 2,
                        'user' => (object)['name' => 'Mme Diabaté Aminata', 'profile_photo_path' => null],
                        'specialization' => 'Français',
                        'subjects' => ['Grammaire', 'Littérature', 'Expression écrite'],
                        'years_experience' => 5,
                        'rating' => 4.9,
                        'total_sessions' => 120,
                        'students_helped' => 38,
                        'hourly_rate' => null,
                        'is_volunteer' => true,
                        'is_verified' => true,
                        'bio' => 'Enseignante de français dévouée, spécialisée dans la préparation aux examens.'
                    ],
                    (object)[
                        'id' => 3,
                        'user' => (object)['name' => 'M. Traoré Ibrahim', 'profile_photo_path' => null],
                        'specialization' => 'Sciences Physiques',
                        'subjects' => ['Physique', 'Chimie', 'TP'],
                        'years_experience' => 10,
                        'rating' => 4.7,
                        'total_sessions' => 200,
                        'students_helped' => 62,
                        'hourly_rate' => 7500,
                        'is_volunteer' => false,
                        'is_verified' => false,
                        'bio' => 'Ingénieur et formateur en sciences avec une approche pratique.'
                    ]
                ]);
            @endphp

            @forelse($mentors as $mentor)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all group">
                <!-- Mentor Header -->
                <div class="relative h-32 bg-gradient-to-br from-indigo-500 to-purple-600">
                    @if($mentor->user->profile_photo_path)
                    <img src="{{ asset('storage/' . $mentor->user->profile_photo_path) }}" 
                         alt="{{ $mentor->user->name }}"
                         class="absolute bottom-0 left-6 transform translate-y-1/2 w-24 h-24 rounded-full border-4 border-white dark:border-gray-800">
                    @else
                    <div class="absolute bottom-0 left-6 transform translate-y-1/2 w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full border-4 border-white dark:border-gray-800 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($mentor->user->name, 0, 2)) }}
                    </div>
                    @endif
                    
                    @if($mentor->is_verified)
                    <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center">
                        <i class="fas fa-check mr-1"></i>Vérifié
                    </div>
                    @endif
                </div>

                <!-- Mentor Info -->
                <div class="pt-14 p-6">
                    <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-1">
                        {{ $mentor->user->name }}
                    </h3>
                    <p class="text-emerald-600 dark:text-emerald-400 font-medium mb-3">
                        {{ $mentor->specialization }}
                    </p>

                    <!-- Rating -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($mentor->rating))
                                    <i class="fas fa-star text-sm"></i>
                                @elseif($i - 0.5 <= $mentor->rating)
                                    <i class="fas fa-star-half-alt text-sm"></i>
                                @else
                                    <i class="far fa-star text-sm"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ number_format($mentor->rating, 1) }} ({{ $mentor->total_sessions }} sessions)
                        </span>
                    </div>

                    <!-- Bio -->
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                        {{ $mentor->bio }}
                    </p>

                    <!-- Subjects -->
                    <div class="flex flex-wrap gap-1 mb-4">
                        @foreach(array_slice($mentor->subjects, 0, 3) as $subject)
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-xs">
                            {{ $subject }}
                        </span>
                        @endforeach
                        @if(count($mentor->subjects) > 3)
                        <span class="px-2 py-1 text-gray-500 dark:text-gray-400 text-xs">
                            +{{ count($mentor->subjects) - 3 }} autres
                        </span>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $mentor->students_helped }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Étudiants</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $mentor->years_experience }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Ans Exp.</div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                @if($mentor->is_volunteer)
                                    <span class="text-green-600">Gratuit</span>
                                @elseif($mentor->hourly_rate)
                                    {{ number_format($mentor->hourly_rate) }}
                                @else
                                    Variable
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                @if(!$mentor->is_volunteer && $mentor->hourly_rate)
                                    FCFA/h
                                @else
                                    &nbsp;
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('mentorship.mentor.show', $mentor->id) }}" 
                           class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white text-center py-2 rounded-lg font-medium transition">
                            Voir le profil
                        </a>
                        @auth
                        <button onclick="contactMentor({{ $mentor->id }})" 
                                class="flex-1 border border-emerald-600 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-indigo-900/20 py-2 rounded-lg font-medium transition">
                            Contacter
                        </button>
                        @endauth
                    </div>

                    <!-- Volunteer Badge -->
                    @if($mentor->is_volunteer)
                    <div class="mt-3 bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200 px-3 py-1 rounded-full text-xs font-semibold text-center">
                        <i class="fas fa-heart mr-1"></i>Mentor Bénévole
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Aucun mentor trouvé
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Essayez de modifier vos critères de recherche
                </p>
                <a href="{{ route('mentorship.browse') }}" 
                   class="inline-block px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    Réinitialiser les filtres
                </a>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($mentors) && method_exists($mentors, 'links'))
        <div class="mt-8">
            {{ $mentors->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function contactMentor(mentorId) {
        // Implementation for contacting mentor
        window.location.href = `/parrainage/mentor/${mentorId}#contact`;
    }
</script>
@endpush

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush
@endsection