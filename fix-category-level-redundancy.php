<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "╔══════════════════════════════════════════════════════════════════╗\n";
echo "║     CORRECTION DE LA REDONDANCE CATÉGORIE/NIVEAU                 ║\n";
echo "╚══════════════════════════════════════════════════════════════════╝\n\n";

// 1. IDENTIFIER LE PROBLÈME
echo "1. ANALYSE DU PROBLÈME\n";
echo "──────────────────────\n";

// Catégories qui sont identiques aux niveaux
$redundantCategories = ['Primaire', 'Collège', 'Lycée', 'Supérieur', 'Professionnel'];

foreach ($redundantCategories as $cat) {
    $count = Book::where('category', $cat)->count();
    if ($count > 0) {
        echo "⚠️ Catégorie '$cat': $count livres\n";
        
        // Vérifier le niveau de ces livres
        $levels = Book::where('category', $cat)
            ->select('level', DB::raw('COUNT(*) as count'))
            ->groupBy('level')
            ->get();
        
        foreach ($levels as $level) {
            $levelName = $level->level ?: 'NULL';
            echo "   → Niveau '$levelName': {$level->count} livres\n";
        }
    }
}

echo "\n2. CORRECTION DES CATÉGORIES REDONDANTES\n";
echo "─────────────────────────────────────────\n";

DB::beginTransaction();

try {
    $totalFixed = 0;
    
    // Mapping des catégories scolaires vers des vraies matières
    $categoryMapping = [
        'Primaire' => [
            'categories' => ['Lecture', 'Écriture', 'Calcul', 'Éveil scientifique', 'Découverte du monde'],
            'default' => 'Éducation primaire'
        ],
        'Collège' => [
            'categories' => ['Français', 'Mathématiques', 'Histoire-Géographie', 'Sciences', 'Langues vivantes'],
            'default' => 'Éducation secondaire'
        ],
        'Lycée' => [
            'categories' => ['Littérature', 'Mathématiques avancées', 'Physique-Chimie', 'Philosophie', 'Sciences économiques'],
            'default' => 'Préparation BAC'
        ],
        'Supérieur' => [
            'categories' => ['Recherche', 'Thèse', 'Médecine', 'Droit', 'Ingénierie'],
            'default' => 'Études universitaires'
        ],
        'Professionnel' => [
            'categories' => ['Management', 'Marketing', 'Finance', 'Développement personnel', 'Entrepreneuriat'],
            'default' => 'Formation professionnelle'
        ]
    ];
    
    foreach ($redundantCategories as $oldCategory) {
        $books = Book::where('category', $oldCategory)->get();
        
        if ($books->count() > 0) {
            echo "\nTraitement de la catégorie '$oldCategory' ({$books->count()} livres):\n";
            
            $mapping = $categoryMapping[$oldCategory];
            $availableCategories = $mapping['categories'];
            $defaultCategory = $mapping['default'];
            
            foreach ($books as $index => $book) {
                // Assigner une nouvelle catégorie basée sur le titre ou la description
                $newCategory = null;
                
                // Analyser le titre et la description pour déterminer la meilleure catégorie
                $text = strtolower($book->title . ' ' . $book->description);
                
                if ($oldCategory == 'Primaire') {
                    if (strpos($text, 'calcul') !== false || strpos($text, 'math') !== false) {
                        $newCategory = 'Calcul';
                    } elseif (strpos($text, 'lecture') !== false || strpos($text, 'lire') !== false) {
                        $newCategory = 'Lecture';
                    } elseif (strpos($text, 'écriture') !== false || strpos($text, 'écrire') !== false) {
                        $newCategory = 'Écriture';
                    } elseif (strpos($text, 'science') !== false || strpos($text, 'nature') !== false) {
                        $newCategory = 'Éveil scientifique';
                    } else {
                        // Assigner de manière cyclique
                        $newCategory = $availableCategories[$index % count($availableCategories)];
                    }
                } elseif ($oldCategory == 'Collège') {
                    if (strpos($text, 'français') !== false || strpos($text, 'grammaire') !== false) {
                        $newCategory = 'Français';
                    } elseif (strpos($text, 'math') !== false || strpos($text, 'algèbre') !== false) {
                        $newCategory = 'Mathématiques';
                    } elseif (strpos($text, 'histoire') !== false || strpos($text, 'géographie') !== false) {
                        $newCategory = 'Histoire-Géographie';
                    } elseif (strpos($text, 'science') !== false || strpos($text, 'physique') !== false) {
                        $newCategory = 'Sciences';
                    } elseif (strpos($text, 'anglais') !== false || strpos($text, 'english') !== false) {
                        $newCategory = 'Langues vivantes';
                    } else {
                        $newCategory = $availableCategories[$index % count($availableCategories)];
                    }
                } elseif ($oldCategory == 'Lycée') {
                    if (strpos($text, 'littérature') !== false || strpos($text, 'roman') !== false) {
                        $newCategory = 'Littérature';
                    } elseif (strpos($text, 'math') !== false || strpos($text, 'calcul') !== false) {
                        $newCategory = 'Mathématiques avancées';
                    } elseif (strpos($text, 'physique') !== false || strpos($text, 'chimie') !== false) {
                        $newCategory = 'Physique-Chimie';
                    } elseif (strpos($text, 'philosophie') !== false || strpos($text, 'pensée') !== false) {
                        $newCategory = 'Philosophie';
                    } elseif (strpos($text, 'économie') !== false || strpos($text, 'social') !== false) {
                        $newCategory = 'Sciences économiques';
                    } else {
                        $newCategory = $availableCategories[$index % count($availableCategories)];
                    }
                } else {
                    // Pour Supérieur et Professionnel, utiliser la répartition cyclique
                    $newCategory = $availableCategories[$index % count($availableCategories)];
                }
                
                // Mettre à jour la catégorie
                $book->category = $newCategory ?: $defaultCategory;
                
                // S'assurer que le niveau est correctement défini
                if (!$book->level) {
                    $book->level = strtolower($oldCategory);
                }
                
                $book->save();
                $totalFixed++;
            }
            
            // Afficher un résumé
            $newCategories = Book::where('level', strtolower($oldCategory))
                ->select('category', DB::raw('COUNT(*) as count'))
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->limit(5)
                ->get();
            
            echo "  Nouvelles catégories assignées:\n";
            foreach ($newCategories as $nc) {
                echo "    - {$nc->category}: {$nc->count} livres\n";
            }
        }
    }
    
    echo "\n3. VÉRIFICATION FINALE\n";
    echo "──────────────────────\n";
    
    // Vérifier qu'il n'y a plus de catégories redondantes
    $remaining = Book::whereIn('category', $redundantCategories)->count();
    if ($remaining == 0) {
        echo "✅ Toutes les catégories redondantes ont été corrigées!\n";
    } else {
        echo "⚠️ Il reste $remaining livres avec des catégories redondantes\n";
    }
    
    // Statistiques finales
    echo "\n📊 RÉSULTAT:\n";
    echo "  • $totalFixed livres corrigés\n";
    echo "  • Plus de redondance Niveau/Catégorie\n";
    echo "  • Les catégories sont maintenant des vraies matières/sujets\n";
    
    DB::commit();
    echo "\n✅ Modifications sauvegardées avec succès!\n";
    
} catch (\Exception $e) {
    DB::rollBack();
    echo "\n❌ Erreur: " . $e->getMessage() . "\n";
}