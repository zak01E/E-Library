<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;

echo "═══════════════════════════════════════════════════════\n";
echo "    GÉNÉRATION DE DONNÉES D'ACTIVITÉ DE TEST\n";
echo "═══════════════════════════════════════════════════════\n\n";

// Obtenir quelques utilisateurs et livres
$users = User::limit(10)->get();
$books = Book::limit(20)->get();

if ($users->isEmpty() || $books->isEmpty()) {
    echo "❌ Pas assez d'utilisateurs ou de livres pour générer des activités\n";
    exit;
}

$actions = [
    'login' => 'Connexion utilisateur',
    'logout' => 'Déconnexion utilisateur',
    'book.view' => 'Consultation d\'un livre',
    'book.download' => 'Téléchargement d\'un livre',
    'book.create' => 'Ajout d\'un nouveau livre',
    'book.update' => 'Mise à jour d\'un livre',
    'book.delete' => 'Suppression d\'un livre',
    'user.update' => 'Mise à jour du profil',
    'search' => 'Recherche effectuée',
    'category.view' => 'Consultation d\'une catégorie'
];

$ips = [
    '192.168.1.1',
    '10.0.0.1',
    '172.16.0.1',
    '192.168.0.100',
    '10.10.10.10'
];

$userAgents = [
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
    'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36',
    'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X)',
    'Mozilla/5.0 (Android 11; Mobile) AppleWebKit/537.36'
];

// Générer 100 activités sur les 30 derniers jours
echo "Génération de 100 activités de test...\n\n";

for ($i = 0; $i < 100; $i++) {
    $user = $users->random();
    $action = array_rand($actions);
    $description = $actions[$action];
    
    // Ajouter des détails spécifiques selon l'action
    $properties = [];
    
    if (strpos($action, 'book.') !== false && !$books->isEmpty()) {
        $book = $books->random();
        $description .= ": " . $book->title;
        $properties = [
            'book_id' => $book->id,
            'book_title' => $book->title
        ];
    } elseif ($action === 'search') {
        $searchTerms = ['mathématiques', 'histoire', 'science', 'littérature', 'philosophie'];
        $term = $searchTerms[array_rand($searchTerms)];
        $description .= ": \"$term\"";
        $properties = ['search_term' => $term];
    }
    
    $activity = ActivityLog::create([
        'user_id' => $user->id,
        'action' => $action,
        'description' => $description,
        'ip_address' => $ips[array_rand($ips)],
        'user_agent' => $userAgents[array_rand($userAgents)],
        'properties' => json_encode($properties),
        'session_id' => bin2hex(random_bytes(16)),
        'created_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59))
    ]);
    
    if ($i % 10 == 0) {
        echo "✓ " . ($i + 1) . " activités créées\n";
    }
}

// Statistiques
$stats = [
    'total' => ActivityLog::count(),
    'today' => ActivityLog::whereDate('created_at', Carbon::today())->count(),
    'week' => ActivityLog::where('created_at', '>=', Carbon::now()->subWeek())->count(),
    'month' => ActivityLog::where('created_at', '>=', Carbon::now()->subMonth())->count(),
];

echo "\n═══════════════════════════════════════════════════════\n";
echo "                     RÉSUMÉ\n";
echo "═══════════════════════════════════════════════════════\n\n";

echo "✅ Activités générées avec succès!\n\n";
echo "📊 Statistiques:\n";
echo "   • Total: {$stats['total']} activités\n";
echo "   • Aujourd'hui: {$stats['today']} activités\n";
echo "   • Cette semaine: {$stats['week']} activités\n";
echo "   • Ce mois: {$stats['month']} activités\n";

echo "\n🔗 Vous pouvez maintenant visiter:\n";
echo "   http://127.0.0.1:8000/admin/activity\n\n";

echo "📌 La page affichera:\n";
echo "   • Graphiques d'activité en temps réel\n";
echo "   • Statistiques des utilisateurs\n";
echo "   • Journal des dernières actions\n";
echo "   • Métriques de performance\n";