<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Book;

echo "=== STATISTIQUES DES LIVRES PAR NIVEAU ===\n\n";

$levels = ['primaire', 'college', 'lycee', 'superieur', 'professionnel'];

foreach ($levels as $level) {
    $count = Book::where('status', 'approved')->where('level', $level)->count();
    echo ucfirst($level) . ": $count livres approuvés\n";
    echo "URL de test: http://127.0.0.1:8000/search?level=$level\n\n";
}

echo "=== INSTRUCTIONS DE TEST ===\n";
echo "1. Ouvrez votre navigateur\n";
echo "2. Allez à http://127.0.0.1:8000/search\n";
echo "3. Utilisez le menu déroulant 'Niveau' pour sélectionner 'Primaire'\n";
echo "4. Cliquez sur 'Rechercher'\n";
echo "5. Vous devriez voir 5363 livres du niveau primaire\n\n";

echo "OU testez directement ces URLs:\n";
echo "- http://127.0.0.1:8000/search?level=primaire (devrait afficher 5363 livres)\n";
echo "- http://127.0.0.1:8000/search?level=college (devrait afficher 3800 livres)\n";
echo "- http://127.0.0.1:8000/search?level=lycee (devrait afficher 3156 livres)\n";