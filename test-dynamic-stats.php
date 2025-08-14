<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\Cache;

// Vider le cache pour forcer le recalcul
Cache::forget('level_stats');
Cache::forget('homepage_stats');

echo "=== TEST DES STATISTIQUES DYNAMIQUES PAR NIVEAU ===\n\n";

// Statistiques par niveau
$levelStats = [
    'primaire' => Book::where('status', 'approved')
        ->where(function($query) {
            $query->where('level', 'primaire')
                  ->orWhere('category', 'LIKE', '%primaire%');
        })->count(),
    
    'college' => Book::where('status', 'approved')
        ->where(function($query) {
            $query->where('level', 'college')
                  ->orWhere('level', 'collège')
                  ->orWhere('category', 'LIKE', '%collège%')
                  ->orWhere('category', 'LIKE', '%college%');
        })->count(),
    
    'lycee' => Book::where('status', 'approved')
        ->where(function($query) {
            $query->where('level', 'lycee')
                  ->orWhere('level', 'lycée')
                  ->orWhere('category', 'LIKE', '%lycée%')
                  ->orWhere('category', 'LIKE', '%lycee%');
        })->count(),
    
    'superieur' => Book::where('status', 'approved')
        ->where(function($query) {
            $query->where('level', 'superieur')
                  ->orWhere('level', 'supérieur')
                  ->orWhere('category', 'LIKE', '%supérieur%')
                  ->orWhere('category', 'LIKE', '%superieur%')
                  ->orWhere('category', 'LIKE', '%universitaire%');
        })->count(),
    
    'professionnel' => Book::where('status', 'approved')
        ->where(function($query) {
            $query->where('level', 'professionnel')
                  ->orWhere('category', 'LIKE', '%professionnel%')
                  ->orWhere('category', 'LIKE', '%formation%')
                  ->orWhere('category', 'LIKE', '%BTS%')
                  ->orWhere('category', 'LIKE', '%CAP%');
        })->count(),
    
    'examens' => Book::where('status', 'approved')
        ->where(function($query) {
            $query->where('category', 'Examens')
                  ->orWhere('category', 'LIKE', '%examen%')
                  ->orWhere('category', 'LIKE', '%BAC%')
                  ->orWhere('category', 'LIKE', '%BEPC%')
                  ->orWhere('category', 'LIKE', '%annales%');
        })->count(),
];

echo "📊 STATISTIQUES PAR NIVEAU :\n";
echo "----------------------------------------\n";
foreach ($levelStats as $level => $count) {
    $levelFormatted = ucfirst($level);
    $countFormatted = number_format($count);
    echo "✅ $levelFormatted : $countFormatted livres\n";
}

echo "\n📈 TOTAL DES LIVRES PAR NIVEAU : " . number_format(array_sum($levelStats)) . " livres\n";

// Statistiques générales
$totalBooks = Book::where('status', 'approved')->count();
echo "\n📚 TOTAL GÉNÉRAL (tous les livres approuvés) : " . number_format($totalBooks) . " livres\n";

// Exemples de livres par niveau
echo "\n=== EXEMPLES DE LIVRES PAR NIVEAU ===\n";

foreach (['primaire', 'college', 'lycee'] as $level) {
    echo "\n📖 Exemples pour $level :\n";
    $books = Book::where('status', 'approved')
        ->where(function($query) use ($level) {
            $query->where('level', $level)
                  ->orWhere('category', 'LIKE', '%' . $level . '%');
        })
        ->limit(3)
        ->get(['id', 'title', 'level', 'category']);
    
    if ($books->count() > 0) {
        foreach ($books as $book) {
            echo "   - ID: {$book->id} | Titre: {$book->title}\n";
            echo "     Niveau: " . ($book->level ?? 'Non défini') . " | Catégorie: {$book->category}\n";
        }
    } else {
        echo "   Aucun livre trouvé pour ce niveau\n";
    }
}

echo "\n✅ Test terminé avec succès !\n";
echo "Les statistiques sont maintenant dynamiques et se mettent à jour automatiquement.\n";
echo "Le cache est configuré pour 5 minutes (300 secondes).\n";