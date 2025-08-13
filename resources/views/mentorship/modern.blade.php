<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programme de Mentorat - E-Library Côte d'Ivoire</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .mentor-card {
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
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
        .float-animation {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <i class="fas fa-hands-helping text-emerald-600 text-2xl mr-3"></i>
                        <span class="text-xl font-bold text-gray-900">Programme Mentorat CI</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#mentors" class="text-gray-600 hover:text-emerald-600 hidden md:block">Mentors</a>
                    <a href="#comment" class="text-gray-600 hover:text-emerald-600 hidden md:block">Comment ça marche</a>
                    <a href="#temoignages" class="text-gray-600 hover:text-emerald-600 hidden md:block">Témoignages</a>
                    <a href="{{ route('home') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-teal-600 opacity-10"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-emerald-200 rounded-full opacity-30 float-animation"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-teal-200 rounded-full opacity-20 float-animation" style="animation-delay: 2s;"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-block px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-star mr-2"></i>Programme National d'Excellence
                </span>
                <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                    <span class="gradient-text">Trouvez votre Mentor</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Connectez-vous avec des professionnels expérimentés pour accélérer votre parcours académique et professionnel
                </p>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="openMentorForm()" class="px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl font-semibold hover:shadow-xl transform hover:scale-105 transition">
                        <i class="fas fa-user-graduate mr-2"></i>
                        Devenir Étudiant Mentoré
                    </button>
                    <button onclick="openBecomeMentor()" class="px-8 py-4 bg-white text-emerald-600 border-2 border-emerald-600 rounded-xl font-semibold hover:bg-emerald-50 transition">
                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                        Devenir Mentor
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16 max-w-4xl mx-auto">
                <div class="glass rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-emerald-600">250+</div>
                    <div class="text-sm text-gray-600 mt-1">Mentors Actifs</div>
                </div>
                <div class="glass rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-teal-600">1,500+</div>
                    <div class="text-sm text-gray-600 mt-1">Étudiants Mentorés</div>
                </div>
                <div class="glass rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-cyan-600">95%</div>
                    <div class="text-sm text-gray-600 mt-1">Taux de Satisfaction</div>
                </div>
                <div class="glass rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-emerald-600">15</div>
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
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4">
                        1
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Inscription</h3>
                    <p class="text-gray-600 text-sm">Créez votre profil et définissez vos objectifs d'apprentissage</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4">
                        2
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Matching</h3>
                    <p class="text-gray-600 text-sm">Notre algorithme vous connecte avec le mentor idéal</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4">
                        3
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Sessions</h3>
                    <p class="text-gray-600 text-sm">Rencontres régulières en ligne ou en présentiel</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-400 to-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4">
                        4
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Progression</h3>
                    <p class="text-gray-600 text-sm">Suivez votre évolution et atteignez vos objectifs</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Mentors -->
    <section id="mentors" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nos Mentors Étoiles</h2>
                <p class="text-gray-600">Des professionnels passionnés prêts à partager leur expertise</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Mentor Card 1 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition mentor-card">
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
                            <span class="px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full text-xs">Data Science</span>
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
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition mentor-card">
                    <div class="h-48 bg-gradient-to-br from-teal-400 to-cyan-500 relative">
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
                            <span class="px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full text-xs">EdTech</span>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">Business</span>
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
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition mentor-card">
                    <div class="h-48 bg-gradient-to-br from-cyan-400 to-blue-500 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-gray-400 rounded-full inline-block"></span>
                            <span class="text-white text-xs ml-1">Hors ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user-graduate text-4xl text-cyan-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Prof. N'Guessan Paul</h3>
                        <p class="text-cyan-600 font-semibold mb-3">Professeur Université FHB</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Docteur en Mathématiques Appliquées. Expert en recherche académique.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-cyan-100 text-cyan-700 rounded-full text-xs">Maths</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">Recherche</span>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs">PhD</span>
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
                            <button class="text-cyan-600 hover:text-cyan-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mentor Card 4 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition mentor-card">
                    <div class="h-48 bg-gradient-to-br from-violet-400 to-purple-500 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-green-500 rounded-full inline-block pulse-dot"></span>
                            <span class="text-white text-xs ml-1">En ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-4xl text-violet-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Dr. Koné Mariam</h3>
                        <p class="text-violet-600 font-semibold mb-3">Médecin Chercheur</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Spécialiste en santé publique. Experte en épidémiologie et biostatistiques.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-violet-100 text-violet-700 rounded-full text-xs">Médecine</span>
                            <span class="px-3 py-1 bg-teal-100 text-purple-700 rounded-full text-xs">Santé</span>
                            <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs">Recherche</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600 ml-2">5.0 (29)</span>
                            </div>
                            <button class="text-violet-600 hover:text-violet-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mentor Card 5 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition mentor-card">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-red-500 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-green-500 rounded-full inline-block pulse-dot"></span>
                            <span class="text-white text-xs ml-1">En ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user-tie text-4xl text-orange-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">M. Traoré Seydou</h3>
                        <p class="text-orange-600 font-semibold mb-3">Directeur Marketing</p>
                        <p class="text-gray-600 text-sm mb-4">
                            20 ans dans le marketing digital. Expert en growth hacking et branding.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs">Marketing</span>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">Digital</span>
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs">Growth</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="far fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600 ml-2">4.6 (51)</span>
                            </div>
                            <button class="text-orange-600 hover:text-orange-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mentor Card 6 -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition mentor-card">
                    <div class="h-48 bg-gradient-to-br from-pink-400 to-rose-500 relative">
                        <div class="absolute top-4 right-4">
                            <span class="w-3 h-3 bg-gray-400 rounded-full inline-block"></span>
                            <span class="text-white text-xs ml-1">Hors ligne</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-4xl text-pink-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Mlle Yao Christine</h3>
                        <p class="text-pink-600 font-semibold mb-3">Designer UX/UI</p>
                        <p class="text-gray-600 text-sm mb-4">
                            Lead Designer chez MTN CI. Experte en design thinking et prototypage.
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs">Design</span>
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs">UX/UI</span>
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs">Figma</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="text-sm text-gray-600 ml-2">4.8 (44)</span>
                            </div>
                            <button class="text-pink-600 hover:text-pink-700">
                                <i class="fas fa-comment-dots"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <button class="px-8 py-3 bg-white border-2 border-emerald-600 text-emerald-600 rounded-lg font-semibold hover:bg-emerald-50 transition">
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
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-2xl p-6">
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
                <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-2xl p-6">
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
                <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-quote-left text-cyan-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Mon mentor m'a aidé à lancer ma startup. 
                        Son expérience entrepreneuriale a été un atout majeur."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-cyan-200 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-cyan-600"></i>
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
                <button onclick="openMentorForm()" class="px-8 py-4 bg-white text-emerald-600 rounded-xl font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-rocket mr-2"></i>Commencer maintenant
                </button>
                <button onclick="openInfo()" class="px-8 py-4 bg-emerald-500 text-white rounded-xl font-semibold hover:bg-emerald-400 transition">
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
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">Programme Mentorat</h3>
                    <p class="text-gray-400 text-sm">
                        Connecter les générations pour un avenir meilleur
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white">Comment ça marche</a></li>
                        <li><a href="#" class="hover:text-white">Devenir mentor</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Contact</h3>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><i class="fas fa-envelope mr-2"></i>mentorat@education.ci</li>
                        <li><i class="fas fa-phone mr-2"></i>+225 27 22 00 00 00</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 E-Library Côte d'Ivoire - Programme National de Mentorat</p>
            </div>
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
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Niveau d'études</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option>Licence</option>
                        <option>Master</option>
                        <option>Doctorat</option>
                        <option>Professionnel</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Domaine d'intérêt</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        <option>Technologie</option>
                        <option>Business</option>
                        <option>Santé</option>
                        <option>Education</option>
                        <option>Design</option>
                        <option>Marketing</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Objectifs (optionnel)</label>
                    <textarea rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-3 rounded-lg font-semibold hover:shadow-lg transition">
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