<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Période par défaut : 30 derniers jours
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Statistiques générales
        $stats = $this->getGeneralStats($startDate, $endDate);
        
        // Données pour les graphiques
        $chartData = $this->getChartData($startDate, $endDate);
        
        // Rapports détaillés par onglets
        $userReports = $this->getUserReports($startDate, $endDate);
        $bookReports = $this->getBookReports($startDate, $endDate);
        $authorReports = $this->getAuthorReports($startDate, $endDate);
        $revenueReports = $this->getRevenueReports($startDate, $endDate);
        
        return view('admin.reports', compact(
            'stats', 
            'chartData', 
            'userReports', 
            'bookReports', 
            'authorReports', 
            'revenueReports',
            'startDate',
            'endDate'
        ));
    }
    
    private function getGeneralStats($startDate, $endDate, $variation = false)
    {
        $previousPeriodStart = Carbon::parse($startDate)->subDays(Carbon::parse($endDate)->diffInDays(Carbon::parse($startDate)));
        $previousPeriodEnd = Carbon::parse($startDate)->subDay();

        // Utilisateurs
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $previousNewUsers = User::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        $userGrowth = $previousNewUsers > 0 ? (($newUsers - $previousNewUsers) / $previousNewUsers) * 100 : 0;

        // Livres téléchargés (simulation basée sur les livres existants)
        $totalBooks = Book::count();
        $baseDownloads = $totalBooks * 72; // Base fixe
        $downloadsEstimate = $variation ? $baseDownloads + rand(-500, 1000) : $baseDownloads + rand(50, 200);
        $previousDownloads = $totalBooks * rand(40, 180);
        $downloadGrowth = $previousDownloads > 0 ? (($downloadsEstimate - $previousDownloads) / $previousDownloads) * 100 : 0;

        // Revenus (simulation avec variation)
        $baseRevenue = 45000;
        $revenue = $variation ? $baseRevenue + rand(-2000, 3000) : rand(40000, 50000);
        $previousRevenue = rand(35000, 45000);
        $revenueGrowth = (($revenue - $previousRevenue) / $previousRevenue) * 100;

        // Taux de conversion (simulation avec variation)
        $baseConversion = 3.5;
        $conversionRate = $variation ? $baseConversion + (rand(-50, 50) / 100) : rand(250, 400) / 100;
        $previousConversion = rand(300, 450) / 100;
        $conversionGrowth = (($conversionRate - $previousConversion) / $previousConversion) * 100;
        
        return [
            'revenue' => $revenue,
            'revenue_growth' => round($revenueGrowth, 1),
            'new_users' => $newUsers,
            'user_growth' => round($userGrowth, 1),
            'downloads' => $downloadsEstimate,
            'download_growth' => round($downloadGrowth, 1),
            'conversion_rate' => round($conversionRate, 2),
            'conversion_growth' => round($conversionGrowth, 1)
        ];
    }
    
    private function getChartData($startDate, $endDate, $variation = false)
    {
        // Données pour les graphiques (simulation basée sur des données réelles)
        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate)) + 1;

        $revenueData = [];
        $userActivityData = [];
        $labels = [];

        for ($i = 0; $i < min($days, 30); $i++) {
            $date = Carbon::parse($startDate)->addDays($i);
            $labels[] = $date->format('d/m');

            // Simulation de revenus avec tendance croissante
            $baseRevenue = 1500 + ($i * 50);
            if ($variation) {
                $baseRevenue += rand(-100, 200); // Variation plus petite pour temps réel
            } else {
                $baseRevenue += rand(-200, 300);
            }
            $revenueData[] = max(1000, $baseRevenue);

            // Simulation d'activité utilisateur
            $baseActivity = 100 + ($i * 5);
            if ($variation) {
                $baseActivity += rand(-10, 30); // Variation plus petite pour temps réel
            } else {
                $baseActivity += rand(-20, 40);
            }
            $userActivityData[] = max(50, $baseActivity);
        }
        
        return [
            'labels' => $labels,
            'revenue' => $revenueData,
            'user_activity' => $userActivityData
        ];
    }
    
    private function getUserReports($startDate, $endDate, $variation = false)
    {
        $totalUsers = User::count();
        // Simulation d'utilisateurs actifs basée sur les utilisateurs récents
        $activeUsers = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        if ($activeUsers == 0) {
            $baseActive = round($totalUsers * 0.65); // 65% d'utilisateurs actifs simulés
            $activeUsers = $variation ? $baseActive + rand(-2, 5) : $baseActive;
        }
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        // Calcul du taux de rétention (simulation)
        $retentionRate = $totalUsers > 0 ? ($activeUsers / $totalUsers) * 100 : 0;
        
        // Répartition par rôles
        $usersByRole = User::select('roles.name as role_name', DB::raw('count(*) as count'))
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->groupBy('roles.name')
            ->get();
        
        return [
            'total_users' => $totalUsers,
            'active_users' => $activeUsers,
            'new_users' => $newUsers,
            'retention_rate' => round($retentionRate, 1),
            'users_by_role' => $usersByRole
        ];
    }
    
    private function getBookReports($startDate, $endDate, $variation = false)
    {
        $totalBooks = Book::count();
        $recentBooks = Book::whereBetween('created_at', [$startDate, $endDate])->count();
        
        // Top 5 des livres les plus populaires (simulation basée sur les vrais livres)
        $topBooks = Book::select('title', 'author_name')
            ->inRandomOrder()
            ->limit(5)
            ->get()
            ->map(function ($book, $index) {
                return [
                    'title' => $book->title,
                    'author' => $book->author_name,
                    'downloads' => rand(5000, 15000) - ($index * 1000) // Décroissant
                ];
            });
        
        // Répartition par catégories (basée sur la colonne category directement)
        $booksByCategory = Book::select('category as category_name', DB::raw('count(*) as count'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->get();
        
        // Téléchargements avec variation
        $baseDownloads = 125000;
        $downloads30d = $variation ? $baseDownloads + rand(-5000, 10000) : rand(100000, 150000);

        return [
            'total_books' => $totalBooks,
            'recent_books' => $recentBooks,
            'downloads_30d' => $downloads30d,
            'average_rating' => 4.3,
            'top_books' => $topBooks,
            'books_by_category' => $booksByCategory
        ];
    }
    
    private function getAuthorReports($startDate, $endDate, $variation = false)
    {
        // Compter les auteurs uniques
        $totalAuthors = Book::distinct('author_name')->count('author_name');
        $activeAuthors = Book::whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()])
            ->distinct('author_name')->count('author_name');
        $newAuthors = Book::whereBetween('created_at', [$startDate, $endDate])
            ->distinct('author_name')->count('author_name');
        
        // Répartition par genres (basée sur les catégories)
        $genreDistribution = Category::withCount('books')->get()->map(function ($category) {
            return [
                'name' => $category->name,
                'count' => $category->books_count,
                'percentage' => 0 // Sera calculé côté vue
            ];
        });
        
        return [
            'total_authors' => $totalAuthors,
            'active_authors' => $activeAuthors,
            'new_authors' => $newAuthors,
            'genre_distribution' => $genreDistribution
        ];
    }
    
    private function getRevenueReports($startDate, $endDate, $variation = false)
    {
        // Simulation de données de revenus avec variation
        $baseTotalRevenue = 45000;
        $totalRevenue = $variation ? $baseTotalRevenue + rand(-2000, 3000) : rand(40000, 50000);
        
        $revenueBreakdown = [
            'premium_subscriptions' => round($totalRevenue * 0.71),
            'single_purchases' => round($totalRevenue * 0.19),
            'advertising' => round($totalRevenue * 0.07),
            'partnerships' => round($totalRevenue * 0.03)
        ];
        
        $projections = [
            'estimated_monthly' => rand(50000, 55000),
            'growth_projection' => rand(12, 18),
            'quarterly_target' => 150000,
            'progress_percentage' => rand(65, 75)
        ];
        
        return [
            'total_revenue' => $totalRevenue,
            'breakdown' => $revenueBreakdown,
            'projections' => $projections
        ];
    }
    
    public function getRealtimeData(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Ajouter une variation aléatoire pour simuler des données en temps réel
        $variation = $request->get('simulate', false);

        return response()->json([
            'stats' => $this->getGeneralStats($startDate, $endDate, $variation),
            'chartData' => $this->getChartData($startDate, $endDate, $variation),
            'userReports' => $this->getUserReports($startDate, $endDate, $variation),
            'bookReports' => $this->getBookReports($startDate, $endDate, $variation),
            'authorReports' => $this->getAuthorReports($startDate, $endDate, $variation),
            'revenueReports' => $this->getRevenueReports($startDate, $endDate, $variation),
            'timestamp' => now()->format('H:i:s'),
            'realtime' => true
        ]);
    }

    public function exportCsv(Request $request)
    {
        // TODO: Implémenter l'export CSV
        return response()->json(['message' => 'Export CSV en cours de développement']);
    }

    public function exportPdf(Request $request)
    {
        // TODO: Implémenter l'export PDF
        return response()->json(['message' => 'Export PDF en cours de développement']);
    }

    public function generateFullReport(Request $request)
    {
        // TODO: Implémenter la génération de rapport complet
        return response()->json(['message' => 'Génération de rapport complet en cours de développement']);
    }
}
