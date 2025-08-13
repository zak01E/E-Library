<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme de Mentorat - {{ site_name() }}</title>
    <link rel="icon" type="image/x-icon" href="{{ site_favicon() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .mentor-card {
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ mobileMenuOpen: false }">

    @include('partials.public-header')

    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-block px-4 py-2 bg-white/20 text-white rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-star mr-2"></i>Programme National d'Excellence
                </span>
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                    Trouvez votre <span class="text-emerald-200">Mentor</span>
                </h1>
                <p class="text-xl text-emerald-100 max-w-3xl mx-auto mb-8">
                    Connectez-vous avec des professionnels expérimentés pour accélérer votre parcours académique et professionnel
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="openMentorForm()" class="px-8 py-4 bg-white text-emerald-600 rounded-xl font-semibold hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Devenir Étudiant Mentoré
                    </button>
                    <button onclick="openBecomeMentor()" class="px-8 py-4 bg-emerald-700/30 text-white border-2 border-white/50 rounded-xl font-semibold hover:bg-emerald-700/50 transition-all duration-200">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                        Devenir Mentor
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 max-w-4xl mx-auto">
                <div class="glass rounded-xl p-6 text-center card-hover">
                    <div class="text-3xl font-bold text-emerald-700">250+</div>
                    <div class="text-sm text-gray-600 mt-1">Mentors Actifs</div>
                </div>
                <div class="glass rounded-xl p-6 text-center card-hover">
                    <div class="text-3xl font-bold text-teal-700">1,500+</div>
                    <div class="text-sm text-gray-600 mt-1">Étudiants Mentorés</div>
                </div>
                <div class="glass rounded-xl p-6 text-center card-hover">
                    <div class="text-3xl font-bold text-emerald-600">95%</div>
                    <div class="text-sm text-gray-600 mt-1">Taux de Satisfaction</div>
                </div>
                <div class="glass rounded-xl p-6 text-center card-hover">
                    <div class="text-3xl font-bold text-teal-600">15</div>
                    <div class="text-sm text-gray-600 mt-1">Domaines d'Expertise</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="comment" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                Comment fonctionne le programme ?
            </h2>
            
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 card-hover">
                        1
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Inscription</h3>
                    <p class="text-gray-600 text-sm">Créez votre profil et définissez vos objectifs d'apprentissage</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-teal-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 card-hover">
                        2
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Matching</h3>
                    <p class="text-gray-600 text-sm">Notre algorithme vous connecte avec le mentor idéal</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-600 to-teal-700 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 card-hover">
                        3
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Sessions</h3>
                    <p class="text-gray-600 text-sm">Rencontres régulières en ligne ou en présentiel</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-teal-600 to-emerald-700 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 card-hover">
                        4
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Progression</h3>
                    <p class="text-gray-600 text-sm">Suivez votre évolution et atteignez vos objectifs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Mentors -->
    <section id="mentors" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Mentors Étoiles</h2>
                <p class="text-gray-600">Des professionnels passionnés prêts à partager leur expertise</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Mentor Card 1 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 mentor-card card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-emerald-400 to-teal-500 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-green-500 rounded-full inline-block pulse-dot"></span>
                            <span class="text-white text-xs ml-1">En ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-4xl text-emerald-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Kouassi Jean</h3>
                        <p class="text-emerald-600 font-semibold mb-3">Ingénieur Logiciel Senior</p>
                        <p class="text-gray-600 text-sm mb-4">
                            15 ans d'expérience chez Orange CI. Spécialiste en IA et Machine Learning.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Python</span>
                            <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs">IA</span>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs">Data Science</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600 ml-2">5.0 (47)</span>
                            </div>
                            <button class="text-emerald-600 hover:text-emerald-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mentor Card 2 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 mentor-card card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-teal-400 to-emerald-500 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-green-500 rounded-full inline-block pulse-dot"></span>
                            <span class="text-white text-xs ml-1">En ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-4xl text-teal-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Mme Diabaté Aminata</h3>
                        <p class="text-teal-600 font-semibold mb-3">Entrepreneure Tech</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Fondatrice de 3 startups EdTech. Experte en stratégie digitale et innovation.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs">Startup</span>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">EdTech</span>
                            <span class="px-3 py-1 bg-teal-50 text-teal-600 rounded-full text-xs">Business</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600 ml-2">4.9 (62)</span>
                            </div>
                            <button class="text-teal-600 hover:text-teal-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mentor Card 3 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 mentor-card card-hover border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-emerald-500 to-teal-600 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-gray-400 rounded-full inline-block"></span>
                            <span class="text-white text-xs ml-1">Hors ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user-graduate text-4xl text-emerald-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Prof. N'Guessan Paul</h3>
                        <p class="text-emerald-600 font-semibold mb-3">Professeur Université FHB</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Docteur en Mathématiques Appliquées. Expert en recherche académique.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Maths</span>
                            <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs">Recherche</span>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs">PhD</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="far fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600 ml-2">4.7 (38)</span>
                            </div>
                            <button class="text-emerald-600 hover:text-emerald-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <button class="px-8 py-3 bg-white border-2 border-emerald-600 text-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition-all duration-200">
                    Voir tous les mentors <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="temoignages" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Témoignages</h2>
                <p class="text-gray-600">Ce que disent nos étudiants mentorés</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 card-hover border border-emerald-100">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-quote-left text-emerald-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Grâce à mon mentor, j'ai décroché un stage chez Orange CI. 
                        Ses conseils ont été précieux pour ma préparation aux entretiens."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-emerald-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Kouadio Marc</h4>
                            <p class="text-sm text-gray-600">Étudiant en Informatique</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-gradient-to-br from-teal-50 to-emerald-50 rounded-2xl p-6 card-hover border border-teal-100">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-quote-left text-teal-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Le programme m'a permis de clarifier mon projet professionnel 
                        et de développer un réseau dans mon domaine."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-teal-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-teal-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Adjoua Sarah</h4>
                            <p class="text-sm text-gray-600">Étudiante en Marketing</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6 card-hover border border-emerald-100">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-quote-left text-emerald-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Mon mentor m'a aidé à lancer ma startup. 
                        Son expérience entrepreneuriale a été un atout majeur."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-emerald-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-emerald-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Bamba Ibrahim</h4>
                            <p class="text-sm text-gray-600">Jeune Entrepreneur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Prêt à transformer votre avenir ?</h2>
            <p class="text-xl opacity-90 mb-8">
                Rejoignez notre communauté de 1,500+ étudiants et 250+ mentors
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openMentorForm()" class="px-8 py-4 bg-white text-emerald-600 rounded-xl font-semibold hover:bg-emerald-50 transition-all duration-200 shadow-md hover:shadow-xl">
                    <i class="fas fa-rocket mr-2"></i>Commencer maintenant
                </button>
                <button onclick="openInfo()" class="px-8 py-4 bg-teal-500 text-white rounded-xl font-semibold hover:bg-teal-400 transition-all duration-200">
                    <i class="fas fa-info-circle mr-2"></i>En savoir plus
                </button>
            </div>

            <!-- Trust Badges -->
            <div class="flex flex-wrap justify-center gap-8 mt-12">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-3xl mr-3"></i>
                    <span>100% Sécurisé</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-award text-3xl mr-3"></i>
                    <span>Certifié MENET-FP</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-users text-3xl mr-3"></i>
                    <span>Communauté Active</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} {{ site_name() }} - Programme National de Mentorat</p>
        </div>
    </footer>

    <!-- Application Modal -->
    <div id="applicationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-8">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Inscription au Programme</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Niveau d'études</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>Licence</option>
                        <option>Master</option>
                        <option>Doctorat</option>
                        <option>Professionnel</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Domaine d'intérêt</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option>Technologie</option>
                        <option>Business</option>
                        <option>Santé</option>
                        <option>Education</option>
                        <option>Design</option>
                        <option>Marketing</option>
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-xl">
                    Soumettre ma candidature
                </button>
            </form>
        </div>
    </div>

    <script>
        function openMentorForm() {
            document.getElementById('applicationModal').classList.remove('hidden');
        }
        
        function openBecomeMentor() {
            alert('Formulaire de candidature mentor - Bientôt disponible!');
        }
        
        function openInfo() {
            window.location.href = '#comment';
        }
        
        function closeModal() {
            document.getElementById('applicationModal').classList.add('hidden');
        }
        
        // Close modal on outside click
        document.getElementById('applicationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>