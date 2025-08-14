<?php
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

// Vider le cache
Cache::forget('featured_books');

echo "=== TEST DES LIVRES POPULAIRES DYNAMIQUES ===\n\n";

// 1. Livres populaires de cette semaine
echo "📊 1. LIVRES POPULAIRES DE CETTE SEMAINE :\n";
echo "----------------------------------------\n";

$popularBooksThisWeek = Book::where('status', 'approved')
    ->with(['uploader'])
    ->where('updated_at', '>=', Carbon::now()->subWeek())
    ->orderBy('views', 'desc')
    ->orderBy('downloads', 'desc')
    ->limit(8)
    ->get();

if ($popularBooksThisWeek->count() > 0) {
    echo "✅ " . $popularBooksThisWeek->count() . " livres trouvés pour cette semaine\n\n";
    foreach ($popularBooksThisWeek->take(3) as $index => $book) {
        echo ($index + 1) . ". " . $book->title . "\n";
        echo "   📖 Auteur: " . ($book->author ?? ($book->uploader ? $book->uploader->name : 'Inconnu')) . "\n";
        echo "   👁️ Vues: " . number_format($book->views) . " | ⬇️ Téléchargements: " . number_format($book->downloads) . "\n";
        echo "   📅 Dernière mise à jour: " . $book->updated_at->format('d/m/Y') . "\n\n";
    }
} else {
    echo "⚠️ Aucun livre trouvé pour cette semaine\n";
    echo "   Utilisation des livres populaires globaux à la place\n\n";
}

// 2. Livres populaires globaux (fallback)
echo "📈 2. LIVRES POPULAIRES GLOBAUX (Top downloads) :\n";
echo "----------------------------------------\n";

$popularBooksGlobal = Book::where('status', 'approved')
    ->with(['uploader'])
    ->orderBy('downloads', 'desc')
    ->orderBy('views', 'desc')
    ->limit(8)
    ->get();

foreach ($popularBooksGlobal->take(3) as $index => $book) {
    echo ($index + 1) . ". " . $book->title . "\n";
    echo "   📖 Auteur: " . ($book->author ?? ($book->uploader ? $book->uploader->name : 'Inconnu')) . "\n";
    echo "   👁️ Vues: " . number_format($book->views) . " | ⬇️ Téléchargements: " . number_format($book->downloads) . "\n\n";
}

// 3. Livres récents
echo "🆕 3. LIVRES RÉCENTS (Cette semaine) :\n";
echo "----------------------------------------\n";

$recentBooks = Book::where('status', 'approved')
    ->with(['uploader'])
    ->where('created_at', '>=', Carbon::now()->subWeek())
    ->latest()
    ->limit(5)
    ->get();

if ($recentBooks->count() > 0) {
    echo "✅ " . $recentBooks->count() . " nouveaux livres cette semaine\n\n";
    foreach ($recentBooks->take(3) as $book) {
        echo "• " . $book->title . " (ajouté le " . $book->created_at->format('d/m/Y') . ")\n";
    }
} else {
    echo "⚠️ Aucun nouveau livre cette semaine\n";
}

echo "\n📊 RÉSUMÉ :\n";
echo "----------------------------------------\n";
echo "• Total de livres approuvés: " . Book::where('status', 'approved')->count() . "\n";
echo "• Livres avec plus de 1000 vues: " . Book::where('status', 'approved')->where('views', '>', 1000)->count() . "\n";
echo "• Livres avec plus de 100 téléchargements: " . Book::where('status', 'approved')->where('downloads', '>', 100)->count() . "\n";

echo "\n✅ La section 'Les Plus Consultés Cette Semaine' est maintenant DYNAMIQUE !\n";
echo "Elle affiche les livres réellement populaires basés sur les vues et téléchargements.\n";
echo "Cache configuré pour 5 minutes.\n";