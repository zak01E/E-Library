@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Outils Marketing</h1>
            <p class="text-gray-600 dark:text-gray-400">Promouvoir vos livres efficacement</p>
        </div>
        <a href="{{ route('author.tools') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux outils
        </a>
    </div>

    <!-- Social Media Generator -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-share-alt mr-2 text-blue-600"></i>Générateur de contenu social
        </h3>
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Titre du livre</label>
                    <input type="text" id="book-title" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                           placeholder="Mon nouveau livre">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Genre</label>
                    <select id="book-genre" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-fiction</option>
                        <option value="romance">Romance</option>
                        <option value="thriller">Thriller</option>
                        <option value="fantasy">Fantasy</option>
                        <option value="biography">Biographie</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description courte</label>
                <textarea id="book-description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                          placeholder="Une brève description de votre livre..."></textarea>
            </div>
            <div class="flex space-x-3">
                <button onclick="generateSocialPost('twitter')" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fab fa-twitter mr-2"></i>Twitter
                </button>
                <button onclick="generateSocialPost('facebook')" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fab fa-facebook mr-2"></i>Facebook
                </button>
                <button onclick="generateSocialPost('instagram')" 
                        class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition-colors">
                    <i class="fab fa-instagram mr-2"></i>Instagram
                </button>
            </div>
            <div id="social-output" class="hidden">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contenu généré</label>
                <textarea id="generated-content" rows="4" readonly
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600"></textarea>
                <button onclick="copyToClipboard('generated-content')" 
                        class="mt-2 px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                    <i class="fas fa-copy mr-1"></i>Copier
                </button>
            </div>
        </div>
    </div>

    <!-- Email Template Generator -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-envelope mr-2 text-green-600"></i>Générateur d'emails marketing
        </h3>
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type d'email</label>
                    <select id="email-type" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="launch">Lancement de livre</option>
                        <option value="promotion">Promotion</option>
                        <option value="newsletter">Newsletter</option>
                        <option value="thank-you">Remerciement</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ton</label>
                    <select id="email-tone" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="friendly">Amical</option>
                        <option value="professional">Professionnel</option>
                        <option value="excited">Enthousiaste</option>
                        <option value="casual">Décontracté</option>
                    </select>
                </div>
            </div>
            <button onclick="generateEmailTemplate()" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                <i class="fas fa-magic mr-2"></i>Générer le template
            </button>
            <div id="email-output" class="hidden">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Template généré</label>
                <textarea id="generated-email" rows="8" readonly
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-600"></textarea>
                <button onclick="copyToClipboard('generated-email')" 
                        class="mt-2 px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                    <i class="fas fa-copy mr-1"></i>Copier
                </button>
            </div>
        </div>
    </div>

    <!-- Keyword Research -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-search mr-2 text-teal-600"></i>Recherche de mots-clés
        </h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sujet principal</label>
                <input type="text" id="keyword-topic" 
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700"
                       placeholder="Ex: romance contemporaine">
            </div>
            <button onclick="searchKeywords()" 
                    class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-search mr-2"></i>Rechercher
            </button>
            <div id="keywords-output" class="hidden">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Mots-clés suggérés</h4>
                <div id="keywords-list" class="grid grid-cols-2 md:grid-cols-3 gap-2"></div>
            </div>
        </div>
    </div>

    <!-- Marketing Calendar -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-calendar-alt mr-2 text-orange-600"></i>Planificateur marketing
        </h3>
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date de lancement</label>
                    <input type="date" id="launch-date" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Durée de campagne</label>
                    <select id="campaign-duration" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="1">1 semaine</option>
                        <option value="2">2 semaines</option>
                        <option value="4">1 mois</option>
                        <option value="8">2 mois</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget</label>
                    <select id="marketing-budget" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700">
                        <option value="low">Faible (0-50€)</option>
                        <option value="medium">Moyen (50-200€)</option>
                        <option value="high">Élevé (200€+)</option>
                    </select>
                </div>
            </div>
            <button onclick="generateMarketingPlan()" 
                    class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                <i class="fas fa-calendar-plus mr-2"></i>Générer le plan
            </button>
            <div id="marketing-plan-output" class="hidden">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Plan marketing suggéré</h4>
                <div id="marketing-timeline" class="space-y-3"></div>
            </div>
        </div>
    </div>
</div>

<script>
function generateSocialPost(platform) {
    const title = document.getElementById('book-title').value;
    const genre = document.getElementById('book-genre').value;
    const description = document.getElementById('book-description').value;
    
    if (!title) {
        alert('Veuillez saisir le titre du livre.');
        return;
    }
    
    let content = '';
    const hashtags = {
        fiction: '#Fiction #Livre #Lecture',
        'non-fiction': '#NonFiction #Apprentissage #Livre',
        romance: '#Romance #Amour #Lecture',
        thriller: '#Thriller #Suspense #Livre',
        fantasy: '#Fantasy #Fantastique #Lecture',
        biography: '#Biographie #VieRéelle #Livre'
    };
    
    switch(platform) {
        case 'twitter':
            content = `🚀 Nouveau livre disponible : "${title}" !\n\n${description}\n\n${hashtags[genre]} #NouveauLivre #Auteur`;
            break;
        case 'facebook':
            content = `Je suis ravi(e) de vous annoncer la sortie de mon nouveau livre : "${title}" !\n\n${description}\n\nMerci de votre soutien ! ${hashtags[genre]}`;
            break;
        case 'instagram':
            content = `📚 "${title}" est maintenant disponible !\n\n${description}\n\n${hashtags[genre]} #NouveauLivre #Auteur #Lecture`;
            break;
    }
    
    document.getElementById('generated-content').value = content;
    document.getElementById('social-output').classList.remove('hidden');
}

function generateEmailTemplate() {
    const type = document.getElementById('email-type').value;
    const tone = document.getElementById('email-tone').value;
    
    const templates = {
        launch: {
            friendly: `Objet : Mon nouveau livre est enfin là ! 📚

Cher(e) lecteur/lectrice,

J'espère que vous allez bien ! Je suis ravi(e) de partager avec vous une nouvelle excitante : mon nouveau livre vient de sortir !

[Titre du livre] est maintenant disponible et j'ai hâte que vous le découvriez.

Merci pour votre soutien continu !

Amicalement,
[Votre nom]`,
            professional: `Objet : Nouveau livre disponible - [Titre]

Bonjour,

J'ai le plaisir de vous informer de la publication de mon nouveau livre : [Titre du livre].

Cette œuvre représente [description courte] et sera disponible dès maintenant.

Je vous remercie de votre attention.

Cordialement,
[Votre nom]`
        }
    };
    
    const template = templates[type]?.[tone] || templates.launch.friendly;
    document.getElementById('generated-email').value = template;
    document.getElementById('email-output').classList.remove('hidden');
}

function searchKeywords() {
    const topic = document.getElementById('keyword-topic').value;
    
    if (!topic) {
        alert('Veuillez saisir un sujet.');
        return;
    }
    
    // Simulation de recherche de mots-clés
    const keywords = [
        `${topic}`, `livre ${topic}`, `roman ${topic}`, `histoire ${topic}`,
        `${topic} français`, `${topic} 2024`, `meilleur ${topic}`, `nouveau ${topic}`,
        `${topic} populaire`, `${topic} bestseller`
    ];
    
    const keywordsList = document.getElementById('keywords-list');
    keywordsList.innerHTML = '';
    
    keywords.forEach(keyword => {
        const span = document.createElement('span');
        span.className = 'px-3 py-1 bg-teal-100 text-purple-800 rounded-full text-sm';
        span.textContent = keyword;
        keywordsList.appendChild(span);
    });
    
    document.getElementById('keywords-output').classList.remove('hidden');
}

function generateMarketingPlan() {
    const launchDate = document.getElementById('launch-date').value;
    const duration = parseInt(document.getElementById('campaign-duration').value);
    const budget = document.getElementById('marketing-budget').value;
    
    if (!launchDate) {
        alert('Veuillez sélectionner une date de lancement.');
        return;
    }
    
    const timeline = document.getElementById('marketing-timeline');
    timeline.innerHTML = '';
    
    const activities = [
        { week: -2, activity: 'Préparation du contenu marketing', icon: 'fas fa-edit' },
        { week: -1, activity: 'Annonce sur les réseaux sociaux', icon: 'fas fa-bullhorn' },
        { week: 0, activity: 'Lancement officiel', icon: 'fas fa-rocket' },
        { week: 1, activity: 'Campagne de promotion', icon: 'fas fa-chart-line' },
        { week: 2, activity: 'Suivi et ajustements', icon: 'fas fa-cog' }
    ];
    
    activities.forEach(item => {
        const div = document.createElement('div');
        div.className = 'flex items-center p-3 bg-orange-50 dark:bg-orange-900 rounded-lg';
        div.innerHTML = `
            <i class="${item.icon} text-orange-600 mr-3"></i>
            <div>
                <div class="font-medium text-gray-900 dark:text-white">Semaine ${item.week >= 0 ? '+' : ''}${item.week}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">${item.activity}</div>
            </div>
        `;
        timeline.appendChild(div);
    });
    
    document.getElementById('marketing-plan-output').classList.remove('hidden');
}

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    element.select();
    document.execCommand('copy');
    
    // Feedback visuel
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-check mr-1"></i>Copié !';
    button.className = button.className.replace('bg-green-600', 'bg-green-700');
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.className = button.className.replace('bg-green-700', 'bg-green-600');
    }, 2000);
}
</script>
@endsection
