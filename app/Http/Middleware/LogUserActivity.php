<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log uniquement pour les utilisateurs connectés et les requêtes GET réussies
        if (auth()->check() && $request->isMethod('GET') && $response->getStatusCode() == 200) {
            $this->logPageView($request);
        }

        return $response;
    }

    /**
     * Log page view activity
     */
    private function logPageView(Request $request)
    {
        $ignorePaths = [
            'admin/activity/realtime-data', // Éviter de logger les appels AJAX
            'api/',
            'broadcasting/',
            '_debugbar'
        ];

        $path = $request->path();
        
        // Ignorer certains chemins
        foreach ($ignorePaths as $ignorePath) {
            if (str_contains($path, $ignorePath)) {
                return;
            }
        }

        // Déterminer l'action et la description basées sur la route
        $action = 'page.view';
        $description = 'Consultation de la page';

        if (str_contains($path, 'books')) {
            if (preg_match('/books\/(\d+)/', $path, $matches)) {
                $bookId = $matches[1];
                $action = 'book.view';
                $description = 'Consultation du livre #' . $bookId;
            } else {
                $action = 'books.browse';
                $description = 'Navigation dans les livres';
            }
        } elseif (str_contains($path, 'search')) {
            $action = 'search';
            $description = 'Recherche: ' . ($request->get('q') ?? 'général');
        } elseif (str_contains($path, 'download')) {
            $action = 'book.download';
            $description = 'Téléchargement d\'un livre';
        } elseif (str_contains($path, 'profile')) {
            $action = 'profile.view';
            $description = 'Consultation du profil';
        } elseif (str_contains($path, 'admin')) {
            $action = 'admin.access';
            $description = 'Accès au panneau admin: ' . $path;
        }

        ActivityLog::log(
            $action,
            auth()->id(),
            $description,
            [
                'url' => $request->fullUrl(),
                'path' => $path,
                'method' => $request->method(),
                'query_params' => $request->query()
            ]
        );
    }
}