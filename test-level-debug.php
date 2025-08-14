<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;
use Illuminate\Support\Facades\DB;

echo "=== TEST DU FILTRE DE NIVEAU ===\n\n";

// 1. Vérifier les niveaux distincts dans la base
$levels = Book::whereNotNull('level')->distinct()->pluck('level');
echo "Niveaux distincts dans la base de données:\n";
foreach ($levels as $level) {
    $count = Book::where('level', $level)->count();
    echo "- '$level': $count livres\n";
}

// 2. Test du filtre avec 'primaire'
echo "\n=== Test du filtre avec level=primaire ===\n";
$request = new \Illuminate\Http\Request();
$request->merge(['level' => 'primaire']);

$query = Book::query();
if ($request->filled('level') && $request->level !== 'all') {
    $query->where('level', $request->level);
    echo "Filtre appliqué: WHERE level = 'primaire'\n";
}

$books = $query->get();
echo "Nombre de livres trouvés: " . $books->count() . "\n";

if ($books->count() > 0) {
    echo "\nPremiers livres avec level='primaire':\n";
    foreach ($books->take(5) as $book) {
        echo "- ID: {$book->id}, Titre: {$book->title}, Level: '{$book->level}'\n";
    }
}

// 3. Vérifier s'il y a des espaces ou caractères invisibles
echo "\n=== Vérification des caractères dans les niveaux ===\n";
$rawLevels = DB::select("SELECT DISTINCT level, LENGTH(level) as len, HEX(level) as hex_value FROM books WHERE level IS NOT NULL");
foreach ($rawLevels as $row) {
    echo "Level: '{$row->level}', Longueur: {$row->len}, Hex: {$row->hex_value}\n";
}

// 4. Test avec LIKE pour voir s'il y a des espaces
echo "\n=== Test avec LIKE '%primaire%' ===\n";
$likebooks = Book::where('level', 'LIKE', '%primaire%')->count();
echo "Livres avec level LIKE '%primaire%': $likebooks\n";

// 5. Vérifier la casse
echo "\n=== Test de la casse ===\n";
$caseSensitive = Book::whereRaw("BINARY level = 'primaire'")->count();
$caseInsensitive = Book::whereRaw("LOWER(level) = 'primaire'")->count();
echo "Avec casse exacte (BINARY): $caseSensitive\n";
echo "Sans tenir compte de la casse (LOWER): $caseInsensitive\n";