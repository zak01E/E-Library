<!DOCTYPE html>
<html lang="fr" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
    }
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Library - Design Showcase</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-50 dark:bg-neutral-900">
    <!-- Header -->
    <header class="bg-white dark:bg-neutral-800 shadow-soft sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book-open text-white text-lg"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold gradient-text">E-Library Design</span>
                </div>
                <button @click="toggleDarkMode()" class="btn-glass p-3 rounded-lg">
                    <i class="fas fa-moon" x-show="!darkMode"></i>
                    <i class="fas fa-sun text-yellow-400" x-show="darkMode"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="gradient-bg py-20 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white/5 rounded-full blur-3xl animate-pulse-glow"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-white/3 rounded-full blur-3xl animate-pulse-glow" style="animation-delay: 1s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-responsive-4xl font-black text-white mb-6 animate-fade-in-up">
                Design System 
                <span class="text-yellow-300">Showcase</span>
            </h1>
            <p class="text-responsive-lg text-white/80 mb-8 animate-fade-in-up animate-stagger-1">
                Découvrez les améliorations apportées au design de E-Library
            </p>
        </div>
    </section>

    <!-- Components Showcase -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Buttons Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Boutons Améliorés</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Boutons Primaires</h3>
                        <button class="btn-primary w-full">
                            <i class="fas fa-rocket mr-2"></i>
                            Bouton Principal
                        </button>
                        <button class="btn-secondary w-full">
                            <i class="fas fa-heart mr-2"></i>
                            Bouton Secondaire
                        </button>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Boutons Glass</h3>
                        <button class="btn-glass w-full">
                            <i class="fas fa-magic mr-2"></i>
                            Effet Glass
                        </button>
                        <button class="glass-effect text-primary-600 px-6 py-3 rounded-lg w-full font-semibold">
                            <i class="fas fa-sparkles mr-2"></i>
                            Glass Card
                        </button>
                    </div>
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">États Interactifs</h3>
                        <button class="btn-primary w-full hover-lift">
                            <i class="fas fa-arrow-up mr-2"></i>
                            Hover Lift
                        </button>
                        <button class="btn-primary w-full hover-scale">
                            <i class="fas fa-expand mr-2"></i>
                            Hover Scale
                        </button>
                    </div>
                </div>
            </div>

            <!-- Cards Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Cartes Modernes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Modern Card -->
                    <div class="card-modern p-6 interactive-card">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Carte Moderne</h3>
                        <p class="text-gray-600 dark:text-gray-400">Avec effets de survol et interactions avancées</p>
                    </div>

                    <!-- Glass Card -->
                    <div class="glass-card p-6 rounded-2xl">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-leaf text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Carte Glass</h3>
                        <p class="text-gray-600 dark:text-gray-400">Effet glassmorphism avec transparence</p>
                    </div>

                    <!-- Neomorphism Card -->
                    <div class="neomorphism p-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center mb-4">
                            <i class="fas fa-gem text-white"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Neomorphism</h3>
                        <p class="text-gray-600 dark:text-gray-400">Style neumorphique avec ombres douces</p>
                    </div>
                </div>
            </div>

            <!-- Animations Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Animations</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl mx-auto mb-4 animate-float flex items-center justify-center">
                            <i class="fas fa-cloud text-white"></i>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Float Animation</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl mx-auto mb-4 animate-pulse-glow flex items-center justify-center">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pulse Glow</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl mx-auto mb-4 animate-bounce-in flex items-center justify-center">
                            <i class="fas fa-heart text-white"></i>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Bounce In</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl mx-auto mb-4 animate-scale-in flex items-center justify-center">
                            <i class="fas fa-fire text-white"></i>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Scale In</p>
                    </div>
                </div>
            </div>

            <!-- Typography Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Typographie</h2>
                <div class="space-y-6">
                    <div>
                        <h1 class="text-responsive-4xl font-black gradient-text mb-2">Titre Principal</h1>
                        <p class="text-gray-600 dark:text-gray-400">Utilise la classe gradient-text avec animation</p>
                    </div>
                    <div>
                        <h2 class="text-responsive-2xl font-bold text-gray-900 dark:text-white mb-2 text-shadow">Titre avec Ombre</h2>
                        <p class="text-gray-600 dark:text-gray-400">Classe text-shadow pour plus de profondeur</p>
                    </div>
                    <div>
                        <p class="text-responsive-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                            Texte responsive qui s'adapte automatiquement à la taille de l'écran avec des proportions harmonieuses.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book-open text-white"></i>
            </div>
            <h3 class="text-xl font-bold mb-2">E-Library Design System</h3>
            <p class="text-gray-400">Design moderne et accessible pour une expérience utilisateur optimale</p>
        </div>
    </footer>

    <script>
        // Add some interactive demos
        document.addEventListener('DOMContentLoaded', function() {
            // Demo for interactive cards
            const cards = document.querySelectorAll('.interactive-card');
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</body>
</html>
