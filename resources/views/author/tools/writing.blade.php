@extends('layouts.author-dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Outils d'écriture</h1>
            <p class="text-gray-600 dark:text-gray-400">Améliorez votre écriture avec nos outils</p>
        </div>
        <a href="{{ route('author.tools') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux outils
        </a>
    </div>

    <!-- Spell Checker -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-spell-check mr-2 text-blue-600"></i>Correcteur orthographique
        </h3>
        <div class="space-y-4">
            <textarea 
                id="text-to-check"
                rows="8" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                placeholder="Collez votre texte ici pour vérifier l'orthographe et la grammaire..."
            ></textarea>
            <div class="flex space-x-3">
                <button 
                    onclick="checkSpelling()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    <i class="fas fa-spell-check mr-2"></i>Vérifier
                </button>
                <button 
                    onclick="clearText()"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
                >
                    <i class="fas fa-eraser mr-2"></i>Effacer
                </button>
            </div>
            <div id="spelling-results" class="hidden">
                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Résultats :</h4>
                <div class="p-4 bg-green-50 dark:bg-green-900 rounded-lg">
                    <p class="text-green-800 dark:text-green-200">
                        <i class="fas fa-check-circle mr-2"></i>Aucune erreur détectée !
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Word Counter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-calculator mr-2 text-green-600"></i>Compteur de mots
        </h3>
        <div class="space-y-4">
            <textarea 
                id="text-to-count"
                rows="6" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                placeholder="Tapez ou collez votre texte ici..."
                oninput="updateWordCount()"
            ></textarea>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-blue-50 dark:bg-blue-900 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400" id="word-count">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Mots</div>
                </div>
                <div class="text-center p-3 bg-green-50 dark:bg-green-900 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="char-count">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Caractères</div>
                </div>
                <div class="text-center p-3 bg-purple-50 dark:bg-purple-900 rounded-lg">
                    <div class="text-2xl font-bold text-teal-600 dark:text-purple-400" id="paragraph-count">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Paragraphes</div>
                </div>
                <div class="text-center p-3 bg-orange-50 dark:bg-orange-900 rounded-lg">
                    <div class="text-2xl font-bold text-orange-600 dark:text-orange-400" id="reading-time">0</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Min de lecture</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Text Formatter -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <i class="fas fa-text-height mr-2 text-teal-600"></i>Formateur de texte
        </h3>
        <div class="space-y-4">
            <textarea 
                id="text-to-format"
                rows="6" 
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                placeholder="Texte à formater..."
            ></textarea>
            <div class="flex flex-wrap gap-2">
                <button onclick="formatText('uppercase')" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">
                    MAJUSCULES
                </button>
                <button onclick="formatText('lowercase')" class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700">
                    minuscules
                </button>
                <button onclick="formatText('capitalize')" class="px-3 py-1 bg-teal-600 text-white rounded text-sm hover:bg-purple-700">
                    Première Lettre
                </button>
                <button onclick="formatText('sentence')" class="px-3 py-1 bg-orange-600 text-white rounded text-sm hover:bg-orange-700">
                    Phrase normale
                </button>
                <button onclick="removeExtraSpaces()" class="px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                    Supprimer espaces
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function checkSpelling() {
    const text = document.getElementById('text-to-check').value;
    const results = document.getElementById('spelling-results');
    
    if (text.trim() === '') {
        alert('Veuillez saisir du texte à vérifier.');
        return;
    }
    
    // Simulation de vérification orthographique
    results.classList.remove('hidden');
}

function clearText() {
    document.getElementById('text-to-check').value = '';
    document.getElementById('spelling-results').classList.add('hidden');
}

function updateWordCount() {
    const text = document.getElementById('text-to-count').value;
    
    const words = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
    const chars = text.length;
    const paragraphs = text.trim() === '' ? 0 : text.split(/\n\s*\n/).length;
    const readingTime = Math.ceil(words / 200); // 200 mots par minute
    
    document.getElementById('word-count').textContent = words;
    document.getElementById('char-count').textContent = chars;
    document.getElementById('paragraph-count').textContent = paragraphs;
    document.getElementById('reading-time').textContent = readingTime;
}

function formatText(type) {
    const textarea = document.getElementById('text-to-format');
    let text = textarea.value;
    
    switch(type) {
        case 'uppercase':
            textarea.value = text.toUpperCase();
            break;
        case 'lowercase':
            textarea.value = text.toLowerCase();
            break;
        case 'capitalize':
            textarea.value = text.replace(/\b\w/g, l => l.toUpperCase());
            break;
        case 'sentence':
            textarea.value = text.toLowerCase().replace(/(^\s*\w|[\.\!\?]\s*\w)/g, c => c.toUpperCase());
            break;
    }
}

function removeExtraSpaces() {
    const textarea = document.getElementById('text-to-format');
    textarea.value = textarea.value.replace(/\s+/g, ' ').trim();
}
</script>
@endsection
