<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║          NETTOYAGE ET STANDARDISATION DE LA BASE DE DONNÉES      ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

DB::beginTransaction();

try {
    $totalChanges = 0;
    
    // 1. NETTOYER LES ESPACES
    echo "1. SUPPRESSION DES ESPACES SUPERFLUS\n";
    echo "-------------------------------------\n";
    
    $affected = DB::update("UPDATE books SET level = TRIM(level) WHERE level IS NOT NULL");
    echo "  Level: $affected enregistrements nettoyés\n";
    $totalChanges += $affected;
    
    $affected = DB::update("UPDATE books SET category = TRIM(category) WHERE category IS NOT NULL");
    echo "  Category: $affected enregistrements nettoyés\n";
    $totalChanges += $affected;
    
    $affected = DB::update("UPDATE books SET language = TRIM(language) WHERE language IS NOT NULL");
    echo "  Language: $affected enregistrements nettoyés\n";
    $totalChanges += $affected;
    
    $affected = DB::update("UPDATE books SET author_name = TRIM(author_name) WHERE author_name IS NOT NULL");
    echo "  Author: $affected enregistrements nettoyés\n\n";
    $totalChanges += $affected;
    
    // 2. STANDARDISER LES LANGUES
    echo "2. STANDARDISATION DES CODES DE LANGUE\n";
    echo "---------------------------------------\n";
    
    $languageMapping = [
        'Français' => 'fr',
        'Francais' => 'fr',
        'French' => 'fr',
        'Anglais' => 'en',
        'English' => 'en',
        'Espagnol' => 'es',
        'Spanish' => 'es',
        'Español' => 'es',
        'Allemand' => 'de',
        'German' => 'de',
        'Deutsch' => 'de',
        'Italien' => 'it',
        'Italian' => 'it',
        'Italiano' => 'it',
        'Portugais' => 'pt',
        'Portuguese' => 'pt',
        'Português' => 'pt',
        'Arabe' => 'ar',
        'Arabic' => 'ar',
        'العربية' => 'ar',
        'Chinois' => 'zh',
        'Chinese' => 'zh',
        '中文' => 'zh',
        'Japonais' => 'ja',
        'Japanese' => 'ja',
        '日本語' => 'ja',
        'Russe' => 'ru',
        'Russian' => 'ru',
        'Русский' => 'ru'
    ];
    
    foreach ($languageMapping as $old => $new) {
        $affected = Book::where('language', $old)->update(['language' => $new]);
        if ($affected > 0) {
            echo "  '$old' → '$new': $affected livres\n";
            $totalChanges += $affected;
        }
    }
    
    // 3. RÉORGANISER LES CATÉGORIES ÉDUCATIVES
    echo "\n3. RÉORGANISATION DES CATÉGORIES ÉDUCATIVES\n";
    echo "--------------------------------------------\n";
    
    // Créer des catégories éducatives cohérentes basées sur le contenu réel
    $educationalCategories = [
        'primaire' => [
            'categories' => ['Primaire', 'Contes', 'Albums jeunesse', 'Littérature jeunesse'],
            'keywords' => ['CE1', 'CE2', 'CM1', 'CM2', 'école primaire', 'enfants']
        ],
        'college' => [
            'categories' => ['Collège', 'Français', 'Mathématiques', 'Histoire-Géographie', 
                           'Sciences Physiques', 'SVT', 'Anglais', 'Espagnol', 'Allemand'],
            'keywords' => ['6ème', '5ème', '4ème', '3ème', 'BEPC', 'Brevet', 'collège']
        ],
        'lycee' => [
            'categories' => ['Lycée', 'Terminale', 'Première', 'Seconde'],
            'keywords' => ['BAC', 'Baccalauréat', 'lycée', 'terminale', 'première', 'seconde']
        ],
        'superieur' => [
            'categories' => ['Supérieur', 'Université', 'Philosophy', 'Philosophie', 'Medicine', 
                           'Médecine', 'Law', 'Droit', 'Economics', 'Économie', 'Politics', 
                           'Sciences Politiques', 'Sociology', 'Psychology'],
            'keywords' => ['université', 'master', 'doctorat', 'thèse', 'recherche']
        ],
        'professionnel' => [
            'categories' => ['Professionnel', 'Business', 'Management', 'Marketing', 'Finance', 
                           'Entrepreneurship', 'Leadership', 'Self-Help'],
            'keywords' => ['carrière', 'professional', 'business', 'management']
        ]
    ];
    
    // Réinitialiser les niveaux
    Book::query()->update(['level' => null]);
    echo "  Réinitialisation des niveaux...\n";
    
    // Assigner les niveaux basés sur les catégories
    foreach ($educationalCategories as $level => $data) {
        $count = Book::whereIn('category', $data['categories'])
                     ->whereNull('level')
                     ->update(['level' => $level]);
        echo "  $level: $count livres assignés par catégorie\n";
        
        // Assigner aussi basé sur les mots-clés dans le titre
        foreach ($data['keywords'] as $keyword) {
            $count = Book::whereNull('level')
                         ->where(function($q) use ($keyword) {
                             $q->where('title', 'LIKE', "%$keyword%")
                               ->orWhere('description', 'LIKE', "%$keyword%");
                         })
                         ->update(['level' => $level]);
            if ($count > 0) {
                echo "    + $count livres via mot-clé '$keyword'\n";
            }
        }
    }
    
    // 4. CATÉGORIES GÉNÉRALES
    echo "\n4. ORGANISATION DES CATÉGORIES GÉNÉRALES\n";
    echo "-----------------------------------------\n";
    
    // Les livres sans niveau restent accessibles à tous
    $generalBooks = Book::whereNull('level')->count();
    echo "  $generalBooks livres restent sans niveau (catégories générales)\n";
    echo "  Ces livres sont accessibles à tous les publics\n";
    
    // 5. VÉRIFICATION DES DOUBLONS
    echo "\n5. GESTION DES DOUBLONS\n";
    echo "------------------------\n";
    
    $duplicates = DB::select("
        SELECT title, author_name, COUNT(*) as count 
        FROM books 
        WHERE title IS NOT NULL AND author_name IS NOT NULL
        GROUP BY title, author_name 
        HAVING COUNT(*) > 1
    ");
    
    echo "  " . count($duplicates) . " titres en double détectés\n";
    
    // 6. CRÉATION D'INDEX POUR AMÉLIORER LES PERFORMANCES
    echo "\n6. OPTIMISATION DES PERFORMANCES\n";
    echo "---------------------------------\n";
    
    // Vérifier si les index existent déjà
    $indexes = DB::select("SHOW INDEX FROM books");
    $existingIndexes = array_column($indexes, 'Key_name');
    
    if (!in_array('idx_level', $existingIndexes)) {
        DB::statement("CREATE INDEX idx_level ON books(level)");
        echo "  ✓ Index créé sur 'level'\n";
    } else {
        echo "  - Index sur 'level' existe déjà\n";
    }
    
    if (!in_array('idx_category', $existingIndexes)) {
        DB::statement("CREATE INDEX idx_category ON books(category)");
        echo "  ✓ Index créé sur 'category'\n";
    } else {
        echo "  - Index sur 'category' existe déjà\n";
    }
    
    if (!in_array('idx_language', $existingIndexes)) {
        DB::statement("CREATE INDEX idx_language ON books(language)");
        echo "  ✓ Index créé sur 'language'\n";
    } else {
        echo "  - Index sur 'language' existe déjà\n";
    }
    
    if (!in_array('idx_status', $existingIndexes)) {
        DB::statement("CREATE INDEX idx_status ON books(status)");
        echo "  ✓ Index créé sur 'status'\n";
    } else {
        echo "  - Index sur 'status' existe déjà\n";
    }
    
    // 7. STATISTIQUES FINALES
    echo "\n7. STATISTIQUES APRÈS NETTOYAGE\n";
    echo "--------------------------------\n";
    
    $stats = Book::select('level', DB::raw('COUNT(*) as count'))
                 ->where('status', 'approved')
                 ->groupBy('level')
                 ->orderBy('count', 'desc')
                 ->get();
    
    foreach ($stats as $stat) {
        $levelName = $stat->level ?: 'Sans niveau (général)';
        echo "  $levelName: {$stat->count} livres\n";
    }
    
    // Confirmer les changements
    echo "\n╔══════════════════════════════════════════════════════════════════╗\n";
    echo "║  Total de $totalChanges modifications effectuées                  ║\n";
    echo "╚══════════════════════════════════════════════════════════════════╝\n";
    
    DB::commit();
    echo "\n✅ Base de données nettoyée et optimisée avec succès!\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ Erreur: " . $e->getMessage() . "\n";
    echo "Les changements ont été annulés.\n";
}